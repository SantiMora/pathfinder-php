<?php

namespace Pathfinder\Gear\Armor;

use Pathfinder\Character;
use Pathfinder\Utils\Traits\Nameable;
use Pathfinder\Utils\Traits\Enchantable;

abstract class Armor 
{
    use Nameable, Enchantable;

    // abstract-like properties
	public const NAME = self::NAME;
	public const TYPE = self::TYPE; // [LIGHT_ARMOR | MEDIUM_ARMOR | HEAVY_ARMOR]
    public const BONUS = self::BONUS;
    public const MAX_DEX = self::MAX_DEX;
    public const PENALTY = self::PENALTY;
    public const SPELL_FAILURE = self::SPELL_FAILURE;
    public const SPEED_30 = self::SPEED_30;
    public const SPEED_20 = self::SPEED_20;

    public function checkProficiency(Character $character): bool
    {
        return in_array($this::TYPE, $character->getProficiencies());
    }
}