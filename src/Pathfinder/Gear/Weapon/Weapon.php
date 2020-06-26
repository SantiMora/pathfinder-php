<?php

namespace Pathfinder\Gear\Weapon;

use Pathfinder\Character;
use Pathfinder\Utils\Traits\Nameable;
use Pathfinder\Utils\Traits\Enchantable;

// Weapons bitmask
define("SIMPLE",        0b0000000000000001);
define("MARTIAL",       0b0000000000000010);
define("EXOTIC",        0b0000000000000100);
define("BLUDGEONING",   0b0000000000001000);
define("PIERCING",      0b0000000000010000);
define("SLASHING",      0b0000000000100000);
define("LIGHT",         0b0000000001000000);
define("ONE_HANDED",    0b0000000010000000);
define("TWO_HANDED",    0b0000000100000000);
define("MELEE",         0b0000001000000000);
define("THROWN",        0b0000010000000000);
define("RANGED",        0b0000100000000000);
define("MONK",          0b0001000000000000);
define("DOUBLE",        0b0010000000000000);
define("WEAPONLESS",    0b0100000000000000);
define("FINESSE",       0b1000000000000000);

abstract class Weapon 
{
	use Nameable, Enchantable;

    // abstract-like properties
    // public const NAME = self::NAME;
    // public const TYPE = self::TYPE; // any combination of weapon const bitmask joined by '|' 
    // public const DAMAGE_DICE = self::DAMAGE_DICE;
    // public const DAMAGE_DICE_COUNT = self::DAMAGE_DICE_COUNT;
    // public const MIN_CRIT = self::MIN_CRIT;
    // public const CRIT_MULTIPLIER = self::CRIT_MULTIPLIER;
    // public const RANGE = self::RANGE;

    const MAGIC_TRAITS = [

    ];

    public function checkType($flags = 0): bool
    {
        return ($flags & $this::TYPE) == $flags;
    }

    public function checkProficiency(Character $character): bool
    {
        $proficiencies = $character->getProficiencies();

        if ($this->checkType(SIMPLE) && in_array("SIMPLE_WEAPONS", $proficiencies)) 
            return true;

        if ($this->checkType(MARTIAL) && in_array("MARTIAL_WEAPONS", $proficiencies)) 
            return true;

        if (in_array($this->getName(), $proficiencies))
            return true;

        return false;
    }

    public function getBonus(Character $character): int
    {
        $bonus = $character->getBaseAttackBonus() - $character->getRace()->getSizeBonus();

        if ($this->checkType(FINESSE) && $character->hasFeat(new Pathfinder\Feat\Feats\WeaponFinesse))
            $bonus += $character->getAbilityScoreBonus('dexterity');
        elseif ($this->checkType(MELEE))
            $bonus += $character->getAbilityScoreBonus('strength');
        elseif ($this->checkType(THROWN) || $this->checkType(RANGED))
            $bonus += $character->getAbilityScoreBonus('dexterity');
        else 
            throw new \Exception("Weapon has no range type defined", 1);

        // Proficiencies check
        if (! $this->checkProficiency($character))
            $bonus -= 4;
        if ($character->getArmor() && ! $character->getArmor()->checkProficiency($character))
            $bonus += $character->getArmor()::PENALTY;

        if ($this->magicBonus > 0) 
            $bonus += $this->magicBonus;
        elseif ($this->greatQuality) 
            $bonus += 1;
        
        // todo soltura con un arma
        // todo arma magica

        return $bonus;
    }

    public function getDamage(Character $character): string
    {
        $bonus = $character->getAbilityScoreBonus("strength") + $this->magicBonus;

        // Todo Feats and other stuff

        return $this::DAMAGE_DICE_COUNT."d".$this::DAMAGE_DICE."+".$bonus;
    }

    public function getCritical(Character $character): string
    {
        $crit = "x".$this::CRIT_MULTIPLIER;

        // TODO Critico mejorado

        if ($this::MIN_CRIT < 20) {
            $crit = $this::MIN_CRIT . "-20" . $crit;
        }

        return $crit;
    }       
}