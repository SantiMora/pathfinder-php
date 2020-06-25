<?php

namespace Pathfinder\Gear\Armor\Armors;

use \Pathfinder\Gear\Armor\Armor;

class FullPlate extends Armor
{
	public const NAME = "Full plate";
    public const TYPE = "HEAVY_ARMOR";
    public const BONUS = 9;
    public const MAX_DEX = 1;
    public const PENALTY = -6;
    public const SPELL_FAILURE = 35;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}