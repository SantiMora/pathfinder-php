<?php

namespace Pathfinder;

// traits
use Pathfinder\Utils\Traits\Nameable;
use Pathfinder\Utils\Traits\Alignable;
use Pathfinder\Utils\Traits\Equippable;
use Pathfinder\Utils\Traits\Featable;

use Pathfinder\Race\Race;
use Pathfinder\CharacterClass\CharacterClass;
use Pathfinder\Feat\Feat;
use Pathfinder\Utils\Dice;

class Character 
{
    use Nameable, Alignable, Equippable, Featable;

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
        if ($this->race instanceof \Pathfinder\Race\Races\Human)
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

                if ($this->hasFeat(new \Pathfinder\Feat\Feats\GreatFortitude))
                    $stSum += 2;

                break;
            case "REFLEX":

                $stSum += $this->getAbilityScoreBonus('dexterity');

                if ($this->hasFeat(new \Pathfinder\Feat\Feats\LightningReflexes))
                    $stSum += 2;

                break;
            case "WILL":

                $stSum += $this->getAbilityScoreBonus('wisdom');

                if ($this->hasFeat(new \Pathfinder\Feat\Feats\IronWill))
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
        return $this->getAbilityScoreBonus('dexterity') + ($this->hasFeat(new \Pathfinder\Feat\Feats\ImprovedInitiative) ? 4 : 0);
    }

    public function getMaxHitPoints(): int
    {
        $total = array_sum($this->HDs);
        $total += $this->getLevel() * $this->getAbilityScoreBonus('constitution');
        $total += $this->additionalHP;

        if ($this->hasFeat(new \Pathfinder\Feat\Feats\Endurance))
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

            if ($this->hasFeat(new \Pathfinder\Feat\Feats\Dodge()))
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
            new \Pathfinder\Feat\Feats\Acrobatic,
            new \Pathfinder\Feat\Feats\Alertness,
            new \Pathfinder\Feat\Feats\AnimalAffinity,
            new \Pathfinder\Feat\Feats\Athletic,
            new \Pathfinder\Feat\Feats\Deceitful,
            new \Pathfinder\Feat\Feats\DeftHands,
            new \Pathfinder\Feat\Feats\MagicalAptitude,
            new \Pathfinder\Feat\Feats\Persuasive,
            new \Pathfinder\Feat\Feats\SelfSufficient,
            new \Pathfinder\Feat\Feats\Stealthy
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
        $string = "♦ {$this->getName()} | {$this->race->getName()} ";
        $string .= ["M" => "♂", "F" => "♀", "U" => ""][$this->race->getGender()]." | ";
        $string .= $this->getClassList();
        
        return $string;
    }

    public function prettyPrint()
    {
        $mainWeapon = $this->getMainWeapon();
        $offHandWeapon = $this->getOffHandWeapon();

        $prints = [
            "{$this->shortPrint()}\t\t",
            "---------------------------------------------",
            "",
            "STR:\t{$this->getAbilityScore("strength")} ({$this->getAbilityScoreBonus('strength')})\t\tPG: {$this->getMaxHitPoints()}\t\t",
            "DEX:\t{$this->getAbilityScore("dexterity")} ({$this->getAbilityScoreBonus('dexterity')})\t\tInnitiative: {$this->getInitiative()}\t",
            "CON:\t{$this->getAbilityScore("constitution")} ({$this->getAbilityScoreBonus('constitution')})\t\tSpeed: ".$this->race::SPEED. "\t",
            "INT:\t{$this->getAbilityScore("intelligence")} ({$this->getAbilityScoreBonus('intelligence')})\t\t\t\t",
            "WIS:\t{$this->getAbilityScore("wisdom")} ({$this->getAbilityScoreBonus('wisdom')})\t\t\t\t",
            "CHA:\t{$this->getAbilityScore("charisma")} ({$this->getAbilityScoreBonus('charisma')})\t\t\t\t",
            "\t\t\t\t\t",
            "-+- Defense ---------------------------------",
            "\t\t\t\t\t",
            "Fortitude:\t{$this->getSavingThrow('FORTITUDE')}\tAC:             {$this->getArmorClass()}",
                //. ($this->getArmor() ? " ({$this->getArmor()->getName()} equipped)" : "")
                //. ($this->getShield() ? " ({$this->getArmor()->getName()} equipped)" : ""),
            "Reflex:\t\t{$this->getSavingThrow('REFLEX')}\tTouch AC:       {$this->getArmorClass(true)}",
            "Will:\t\t{$this->getSavingThrow('WILL')}\tFlat-footed:    {$this->getArmorClass(false, true)}",
            "\t\t\t\t\t",
            "CMD: {$this->getCMD()}\t\t\t\t\t",
            "\t\t\t\t\t",
            "-+- Attack ----------------------------------",
            "\t\t\t\t\t",
            "Base Attack Bonus: {$this->getBaseAttackBonus()}\t\tCMB: {$this->getCMB()}\t",
            "\t\t\t\t\t"
        ];

        if ($mainWeapon) {

            $weaponName = implode("", array_replace(
                str_split("                 "),
                str_split($mainWeapon->getName())
            ));

            $criticalString = implode("", array_replace(
                str_split("          "),
                str_split($mainWeapon->getCritical($this))
            ));

            $prints[] = "\e[1m· {$weaponName}\e[22m    {$mainWeapon->getBonus($this)}  {$mainWeapon->getDamage($this)}  {$criticalString}";
        }
        
        if ($offHandWeapon) {

            $weaponName = implode("", array_replace(
                str_split("                "),
                str_split($offHandWeapon->getName())
            ));

            $criticalString = implode("", array_replace(
                str_split("          "),
                str_split($offHandWeapon->getCritical($this))
            ));

            $prints[] = "\e[1m· {$offHandWeapon}\e[22m    {$offHandWeapon->getBonus($this)}    {$offHandWeapon->getDamage($this)}  {$criticalString}";
        }

        $prints = array_merge($prints, [
            "\t\t\t\t\t",
            "-+- Feats -----------------------------------",
            "\t\t\t\t\t",
        ]);

        foreach ($this->feats as $feat) {
            $prints[] = implode("", array_replace(
                str_split("                                            "),
                str_split($feat->getName())
            ));
        }

        $prints = array_merge($prints, [
            "\t\t\t\t\t",
            "-+- Class traits & special ------------------",
            "\t\t\t\t\t",
        ]);

        // TODO print class traits
        // TODO print race traits

        $skillPrints = ["-+- Skills -----------------------", ""];
        $offset = 1 ;

        foreach (self::SKILLS as $skill => $properties) {

            $skillName = implode("", array_replace(
                str_split("                            "),
                str_split($skill.": ")
            ));

            $skillBonus = strrev(implode("", array_replace(
                str_split("  "),
                str_split(strrev($this->getSkillBonus($skill))
            ))));

            $skillPrints[] = "· {$skillName}  {$skillBonus}";
        }

        for ($i = count($prints); $i < count($skillPrints) + $offset; $i++) 
            $prints[] = "\t\t\t\t\t";

        foreach ($prints as $key => $print) {

            echo "\n\t".$print;

            if ($key >= $offset) 
                echo "\t".$skillPrints[$key - $offset];
        }

        // TODO print spells

        echo "\n\n\t----------------------------------------------------------------------------------\n\n";
       
    }

    public function __toString(): string
    {
        return $this->shortPrint();
    }
}