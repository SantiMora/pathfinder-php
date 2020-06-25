<?php

namespace Pathfinder\Gear\Shield;

use \Pathfinder\Character;
use \Pathfinder\Utils\Traits\Nameable;
use \Pathfinder\Utils\Traits\Enchantable;

abstract class Shield 
{
    use Nameable, Enchantable;   

    // abstract-like properties
	public const NAME = self::NAME;
	public const TYPE = self::TYPE; // [LIGHT_SHIELDS | HEAVY_SHIELDS | TOWER_SHIELDS]
    public const BONUS = self::BONUS;
    public const PENALTY = self::PENALTY;
    public const SPELL_FAILURE = self::SPELL_FAILURE;
    public const MAX_DES = null; // Only for tower shields

    public function checkProficiency(Character $character): bool
    {
        return in_array($shield::TYPE, $character->getProficiencies());
    }
}