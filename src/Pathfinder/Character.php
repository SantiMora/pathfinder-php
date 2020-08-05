<?php

namespace Pathfinder;

use Pathfinder\Race\{Race, Races};
use Pathfinder\CharacterClass\CharacterClass;
use Pathfinder\Feat\{Feat, Feats};
use Pathfinder\Utils\{Traits, Dice};

class Character 
{
    use Traits\Nameable, 
        Traits\Alignable, 
        Traits\Equippable, 
        Traits\Featable;

    const ABILITY_SCORES = [
        'strength', 
        'dexterity', 
        'constitution',
        'intelligence', 
        'wisdom', 
        'charisma'
    ];

    const SKILLS = [
        "acrobatics" => ["stat" => 'dexterity', "untrained" => true],
        "appraise" => ["stat" => 'intelligence', "untrained" => true],
        "bluff" => ["stat" => 'charisma', "untrained" => true],
        "climb" => ["stat" => 'strength', "untrained" => true],
        "craft" => ["stat" => 'intelligence', "untrained" => true],
        "diplomacy" => ["stat" => 'charisma', "untrained" => true],
        "disable device" => ["stat" => 'dexterity', "untrained" => false],
        "disguise" => ["stat" => 'charisma', "untrained" => true],
        "escape artist" => ["stat" => 'dexterity', "untrained" => true],
        "fly" => ["stat" => 'dexterity', "untrained" => true],
        "handle animal" => ["stat" => 'charisma', "untrained" => true],
        "heal" => ["stat" => 'wisdom', "untrained" => true],
        "intimidate" => ["stat" => 'charisma', "untrained" => true],
        "knowledge (arcana)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (dungeoneering)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (engineering)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (geography)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (history)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (nature)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (local)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (nobility)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (planes)" => ["stat" => 'intelligence', "untrained" => false],
        "knowledge (religion)" => ["stat" => 'intelligence', "untrained" => false],
        "linguistics" => ["stat" => 'intelligence', "untrained" => false],
        "perception" => ["stat" => 'wisdom', "untrained" => true],
        "perform" => ["stat" => 'charisma', "untrained" => true],
        "profession" => ["stat" => 'wisdom', "untrained" => false],
        "ride" => ["stat" => 'dexterity', "untrained" => true],
        "sense motive" => ["stat" => 'wisdom', "untrained" => true],
        "sleigth of hand" => ["stat" => 'dexterity', "untrained" => false],
        "spellcraft" => ["stat" => 'intelligence', "untrained" => false],
        "stealth" => ["stat" => 'dexterity', "untrained" => true],
        "survival" => ["stat" => 'wisdom', "untrained" => true],
        "swim" => ["stat" => 'strength', "untrained" => true],
        "use magic device" => ["stat" => 'charisma', "untrained" => false]
    ];

    private $name, $alignment, $abilityScores, $race, $favouriteClass, $classes = [];
    private $HDs = [];
    private $additionalHP = 0;
    private $skillRanks = [];

    public function __construct($name, $alignment, $abilityScores, $race, $favouriteClass, ... $levelFeatures)
    {
        $this->setName($name);
        $this->setAlignment($alignment);
        $this->setAbilityScores($abilityScores);
        $this->setRace($race);
        $this->setFavouriteClass($favouriteClass);
        $this->addLevel(... $levelFeatures); // see addLevel function arguments
    }
    
    public function addLevel(CharacterClass $classLevel, string $favouriteClassBonus = null, Feat $feat = null, array $skillRanks,string $abilityScoreToIncrease = null, ... $classFeatures): void
    {
        $targetLevel = $this->getLevel() + 1;

        // 1. increase stat if any
        if ($targetLevel % 4 == 0 && ! isset($abilityScoreToIncrease)) 
            throw new \Exception("No ability score to increase defined", 1);
        elseif ($targetLevel % 4 != 0 && isset($abilityScoreToIncrease))
            throw new \Exception("You can't increase an ability score at this level", 1);
        elseif (isset($abilityScoreToIncrease)) 
            $this->increaseAbilityScore($abilityScoreToIncrease);

        // 2. Apply feat if any
        if ($targetLevel % 2 == 1 && ! isset($feat)) 
            throw new \Exception("No feat selected", 1);
        elseif ($targetLevel % 2 == 0 && isset($feat)) 
            throw new \Exception("You can't select a feat, it's not an odd level", 1);
        elseif (isset($feat))
            $this->addFeat($feat);

        // 3. Apply favourite class bonus if any
        $isFavouriteClass = $this->checkFavouriteClass($classLevel);
        $additionalRank = false;

        if ($isFavouriteClass && ! isset($favouriteClassBonus))
            throw new \Exception("You have to select a favourite class bonus", 1);
        elseif (! $isFavouriteClass && isset($favouriteClassBonus)) 
            throw new \Exception("You can't select a favourite class bonus, it's not {$this->getName()}'s favourite class", 1);
        elseif (isset($favouriteClassBonus)) {
            if ($favouriteClassBonus == "HP")
                $this->additionalHP++;
            elseif ($favouriteClassBonus == "RANK")
                $additionalRank = true;
            else 
                throw new \Exception("Not valid class bonus", 1);
        }

        // 4. apply class features
        $this->HDs[] = $targetLevel == 1 ? $classLevel::HD : Dice::roll("d".$classLevel::HD);

        $findClass = array_filter($this->classes, function ($class) use ($classLevel) {
            return $classLevel instanceof $class;
        });

        if (count($findClass) > 0) 
            list($classLevel) = array_values($findClass);
        else 
            $this->classes[] = $classLevel;

        // Apply specific level function  (see Pathfinder\CharacterClass\CharacterClass::levelUp)
        $classLevel->levelUp($this, ... $classFeatures);

        // 5. apply skill ranks
        $rankCount = 0;
        $maxRanks = $classLevel::SKILL_RANKS_PER_LEVEL + $this->getAbilityScoreBonus("intelligence") + ($additionalRank ? 1 : 0);

        // 'skilled' human trait
        if ($this->race instanceof Races\Human)
            $maxRanks++;

        foreach ($skillRanks as $skill => $ranks) {

            if (! in_array($skill, array_keys(self::SKILLS))) 
                throw new \Exception("Not valid skill: '{$skill}'", 1);
            if (! is_numeric($ranks))
                throw new \Exception("Not valid skill rank", 1);

            $isClassSkill = in_array($skill, $this->getClassSkills());

            if (! $isClassSkill && $ranks % 2 == 1) 
                throw new \Exception("You can't assign a half rank to '{$skill}'", 1);
                
            if (! isset($this->skillRanks[$skill]))
                $this->skillRanks[$skill] = 0;
            
            $this->skillRanks[$skill] += $isClassSkill ? $ranks : $ranks / 2;

            if ($this->skillRanks[$skill] > $this->getLevel())
                throw new \Exception("You can't have ranks greater than your level ('{$skill}')", 1);

            $rankCount += $ranks;
        }

        if ($rankCount > $maxRanks) 
            throw new \Exception("You have assigned more ranks than you can ({$rankCount}/{$maxRanks})", 1);
        if ($rankCount < $maxRanks)
            throw new \Exception("You haven't assigned all your ranks ({$rankCount}/{$maxRanks}), check again ", 1);
    }

    /** Stat-related functions **/
    public function setAbilityScores(array $abilityScores): void
    {
        $this->abilityScores = array_combine(
            self::ABILITY_SCORES, 
            array_map(function ($definedStat, $statName, $statValue) {

                if ($definedStat !== $statName)
                    throw new \Exception("'{$statName}' stat not valid; '{$definedStat}' expected ", 1);
                if (! is_numeric($statValue) || $statValue < 7 || $statValue > 18) 
                    throw new \Exception("'{$statName}' value not valid", 1);

                return (object) ["value" => $statValue];

            },  self::ABILITY_SCORES, array_keys($abilityScores), $abilityScores)
        );
    }

    public function setTemporaryAbilityScore(string $abilityScore, int $value): void
    {
        $this->validateAbilityScore($abilityScore);
        $this->abilityScores[$abilityScore]->temp_value = $value;
    }

    public function removeTemporaryAbilityScore(string $abilityScore): void
    {
        $this->validateAbilityScore($abilityScore);

        if (isset($this->abilityScores[$abilityScore]->temp_value)) {
            unset($this->abilityScores[$abilityScore]->temp_value);
        }
    }

    public function getTemporaryAbilityScore(string $abilityScore): int
    {
        $this->validateAbilityScore($abilityScore);
        return $this->abilityScores[$abilityScore]->temp_value ?? null;
    }

    public function getAbilityScore(string $abilityScore): int
    {
        $this->validateAbilityScore($abilityScore);
        return $this->abilityScores[$abilityScore]->value;
    }

    public function getAbilityScoreBonus(string $abilityScore): int
    {
        $this->validateAbilityScore($abilityScore);
        $abilityScoreValue = $this->abilityScores[$abilityScore]->temp_value ?? $this->abilityScores[$abilityScore]->value;

        return floor(($abilityScoreValue - 10) / 2);
    }

    public function increaseAbilityScore($abilityScore, int $increment = 1): void
    {
        $this->validateAbilityScore($abilityScore);
        $this->abilityScores[$abilityScore]->value += $increment;
    }

    private function validateAbilityScore(string $abilityScore): void
    {
        if (! in_array($abilityScore, self::ABILITY_SCORES)) 
            throw new \Exception("Not valid stat", 1);   
    }
    /* END of Stat-related functions*/

    /* Start of race-related functions */
    public function getRace(): Race
    {
        return $this->race;
    }

    private function setRace(Race $race): void
    {
        $this->race = $race;
        $this->race->applyOn($this);
    }
    /* End of race-related functions */

    /* Start of favourite class functions*/
    private function setFavouriteClass($favouriteClass): void
    {
        if (is_array($favouriteClass)) {

            foreach ($favouriteClass as $class) {
                if (! $class instanceof CharacterClass) {
                    throw new Exception("Not valid favourite class", 1);
                }
            }

            $this->favouriteClass = $favouriteClass;

        } elseif ($favouriteClass instanceof CharacterClass) {
            $this->favouriteClass = [ $favouriteClass ];
        } else {
            throw new Exception("Not valid favourite class", 1);
        }
    }
    
    public function checkFavouriteClass(CharacterClass $class): bool
    {
        $favouriteClassSearch = array_filter(
            $this->favouriteClass, 
            function (CharacterClass $favouriteClass) use ($class) {
                return $class instanceof $favouriteClass;
            }
        );

        return count($favouriteClassSearch) > 0;
    }
    /* End of favourite class functions*/

    /* class related functions */
    public function getLevel(): int
    {
        return array_sum(
            array_map(function (CharacterClass $class) {
                return $class->getLevel();
            }, $this->classes)
        );
    }

    public function getBaseAttackBonus(): int
    {
        return array_sum(
            array_map(function (CharacterClass $class) {
                return $class->getBaseAttackBonus();
            }, $this->classes)
        );
    }

    public function getSavingThrow(string $st): int
    {
        $stSum = array_sum(
            array_map(function (CharacterClass $class) use ($st) {
                return $class->getSavingThrow($st);
            }, $this->classes)
        );

        switch ($st) {
            case "FORTITUDE":

                $stSum += $this->getAbilityScoreBonus('constitution');

                if ($this->hasFeat(new Feats\GreatFortitude))
                    $stSum += 2;

                break;
            case "REFLEX":

                $stSum += $this->getAbilityScoreBonus('dexterity');

                if ($this->hasFeat(new Feats\LightningReflexes))
                    $stSum += 2;

                break;
            case "WILL":

                $stSum += $this->getAbilityScoreBonus('wisdom');

                if ($this->hasFeat(new Feats\IronWill))
                    $stSum += 2;
        }

        return $stSum;
    }

    public function getClassList($separator = "/"): string
    {
        return implode(
            $separator, 
            array_map(function (CharacterClass $class) {
                return $class->getName() . " " . $class->getLevel(); 
            }, $this->classes)
        ); 
    }

    public function getClassSkills(): array
    {
        return array_unique(
            array_merge(... array_map(function (CharacterClass $class) {
                return $class::CLASS_SKILLS;
            }, $this->classes))
        );
    }

    public function getProficiencies(): array
    {
        return array_unique(
            array_merge(... array_map(function (CharacterClass $class) {
                return $class::PROFICIENCIES;
            }, $this->classes))
        );
    }
    /* end of class functions */

    /* other statistic-related functions */
    public function getInitiative (): int
    {
        return $this->getAbilityScoreBonus('dexterity') + ($this->hasFeat(new Feats\ImprovedInitiative) ? 4 : 0);
    }

    public function getMaxHitPoints(): int
    {
        $total = array_sum($this->HDs);
        $total += $this->getLevel() * $this->getAbilityScoreBonus('constitution');
        $total += $this->additionalHP;

        if ($this->hasFeat(new Feats\Endurance))
            $total += ($this->getLevel() < 3 ? 3 : $this->getLevel());

        return $total;
    }

    public function getArmorClass(bool $touchAttack = false, bool $flatFooted = false): int
    {
        $total = 10 - $this->race->getSizeBonus();
        $desBonus = $this->getAbilityScoreBonus("dexterity");
        $armor = $this->getArmor();
        $shield = $this->getShield();

        if (! $flatFooted) {

            $maxDexArr = [];

            if (isset($armor))
                $maxDexArr[] = $armor::MAX_DEX;

            if (isset($shield) && defined(get_class($shield)."::MAX_DEX"))
                $maxDexArr[] = $shield::MAX_DEX;

            $total += count($maxDexArr) > 0 && $desBonus > min($maxDexArr) ? min($maxDexArr) : $desBonus;

            if ($this->hasFeat(new Feats\Dodge()))
                $total++;
        }

        if (! $touchAttack) {
            if (isset($armor)) 
                $total += $armor::BONUS;
            if (isset($shield)) 
                $total += $shield::BONUS;

            $total += $this->race::NATURAL_ARMOR;
        }

        // TODO Dotes 
        // TODO Desvio
        // TODO Otros

        return $total;
    }

    public function getSkillBonus(string $skill): int
    {
        if (! in_array($skill, array_keys(self::SKILLS))) 
            throw new \Exception("Not valid skill", 1);

        $armor = $this->getArmor();
        $shield = $this->getShield();
        $penalty = 0;
        $ranks = $this->skillRanks[$skill] ?? 0;

        if ($ranks > 0 && in_array($skill, $this->getClassSkills()))
            $ranks += 3 ;

        if (isset($armor) && in_array(self::SKILLS[$skill]["stat"], ['strength', 'dexterity'])) 
            $penalty += $armor::PENALTY;

        if (isset($shield) && in_array(self::SKILLS[$skill]["stat"], ['strength', 'dexterity'])) 
            $penalty += $shield::PENALTY;

        // TODO apply feats and class traits
        $skillFeats = $this->searchFeats([
            new Feats\Acrobatic,
            new Feats\Alertness,
            new Feats\AnimalAffinity,
            new Feats\Athletic,
            new Feats\Deceitful,
            new Feats\DeftHands,
            new Feats\MagicalAptitude,
            new Feats\Persuasive,
            new Feats\SelfSufficient,
            new Feats\Stealthy
        ]);

        foreach ($skillFeats as $skillFeat) {
            if (in_array($skill, $skillFeat::AFFECTED_SKILLS)) 
                $ranks += 2;
        }

        // TODO soltura con una habilidad
        
        return $this->getAbilityScoreBonus(self::SKILLS[$skill]["stat"]) + $ranks + $penalty;
    }

    public function getCMD(): int
    {
        return $this->getAbilityScoreBonus('dexterity') + $this->getAbilityScoreBonus('strength') + $this->getBaseAttackBonus() + 10;
    }

    public function getCMB(): int
    {
        return $this->getAbilityScoreBonus('strength') + $this->getBaseAttackBonus();
    }

    /* print functions */
    public function shortPrint(): string
    {
        return sprintf(
            "♦ %s | %s %s %s | %s", 
            $this->getName(), 
            $this->race->getName(), 
            ["M" => "♂", "F" => "♀", "U" => ""][$this->race->getGender()],
            $this->getAlignment(),
            $this->getClassList()
        );
    }

    public function prettyPrint(int $leftColumnWidth = 48, int $rightColumnWidth = 32, $columnSpace = 3): void
    {
        // General section
        $general = [
            $this->shortPrint(),
            sprintf("%'-{$leftColumnWidth}s", ''),
            "",
            sprintf(
                "STR [ %2s  -> %2s ]       PG          [ %s ]", $this->getAbilityScore("strength"), $this->getAbilityScoreBonus('strength'), $this->getMaxHitPoints()), 
            sprintf("DEX [ %2s  -> %2s ]", $this->getAbilityScore("dexterity"), $this->getAbilityScoreBonus('dexterity')), 
            sprintf("CON [ %2s  -> %2s ]       Innitiative [ %s ]", $this->getAbilityScore("constitution"), $this->getAbilityScoreBonus('constitution'), $this->getInitiative()), 
            sprintf("INT [ %2s  -> %2s ]       Speed       [ %s' ]", $this->getAbilityScore("intelligence"), $this->getAbilityScoreBonus('intelligence'), $this->race::SPEED), 
            sprintf("WIS [ %2s  -> %2s ]", $this->getAbilityScore("wisdom"), $this->getAbilityScoreBonus('wisdom')), 
            sprintf("CHA [ %2s  -> %2s ]", $this->getAbilityScore("charisma"), $this->getAbilityScoreBonus('charisma'))
        ];

        // Defense section
        $defense = [
            "", 
            sprintf("%-'-{$leftColumnWidth}s", '-+ Defense '), 
            "",
            sprintf("Fortitude: [ %2s ]        AC:          [ %2s ]", $this->getSavingThrow('FORTITUDE'), $this->getArmorClass()),
            sprintf("Reflex:    [ %2s ]        Touch AC:    [ %2s ]", $this->getSavingThrow('REFLEX'), $this->getArmorClass(true)),
            sprintf("Will:      [ %2s ]        Flat-footed: [ %2s ]", $this->getSavingThrow('WILL'), $this->getArmorClass(false, true)),
            "",
            sprintf("CMD:       [ %s ] ", $this->getCMD())
        ];

        // Attack section
        $attack = [
            "", 
            sprintf("%-'-{$leftColumnWidth}s", '-+ Attack '), 
            "",
            sprintf("Base Attack bonus: %s CMB: %s", $this->getBaseAttackBonus(), $this->getCMB()),
            ""
        ];

        if ($mainWeapon = $this->getMainWeapon()) {
            array_push($attack, sprintf(
                "%s %s %s %s", 
                $mainWeapon->getName(), 
                $mainWeapon->getBonus($this),
                $mainWeapon->getDamage($this),
                $mainWeapon->getCritical($this)
            ));
        }
        
        if ($offHandWeapon = $this->getOffHandWeapon()) {
            array_push($attack, sprintf(
                "· %s %s %s %s", 
                $offHandWeapon->getName(), 
                $offHandWeapon->getBonus($this),
                $offHandWeapon->getDamage($this),
                $offHandWeapon->getCritical($this)
            ));
        }

        // Feats section
        $feats = ["", sprintf("%-'-{$leftColumnWidth}s", '-+ Feats '), ""];

        foreach ($this->feats as $feat) {
            array_push($feats, $feat->getName());
        }

        // TODO class traits
        // TODO spells
        // TODO Race traits
        // TODO full inventory

        
        // Skills section
        $skills = ["", sprintf("%-'-{$rightColumnWidth}s", '-+ Skills '), ""];
        $skillNameLength = $rightColumnWidth - 3;

        foreach (self::SKILLS as $skill => $properties) {
            array_push($skills, sprintf("%-{$skillNameLength}s%3s", $skill, $this->getSkillBonus($skill)));
        }

        // merge columns and print
        $leftPrints = array_merge($general, $defense, $attack, $feats);
        $rightPrints = $skills;
        $lineLength = $leftColumnWidth + $columnSpace + $rightColumnWidth;

        printf("\n\t%'-{$lineLength}s\n", "");

        for ($i = 0; $i < max(count($leftPrints), count($rightPrints)); $i++) {
            printf("\t%-{$leftColumnWidth}s", $leftPrints[$i] ?? "");
            printf("%{$columnSpace}s", "");
            printf("%-{$rightColumnWidth}s\n", $rightPrints[$i] ?? "");
        }

        printf("\n\t%'-{$lineLength}s\n\n", "");
    }

    public function __toString(): string
    {
        return $this->shortPrint();
    }
}