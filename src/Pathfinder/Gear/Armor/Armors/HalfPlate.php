<?php

namespace Pathfinder\Gear\Armor\Armors;

use Pathfinder\Gear\Armor\Armor;

class HalfPlate extends Armor
{
	public const NAME = "Half-plate";
    public const TYPE = "HEAVY_ARMOR";
    public const BONUS = 8;
    public const MAX_DEX = 0;
    public const PENALTY = -7;
    public const SPELL_FAILURE = 40;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}