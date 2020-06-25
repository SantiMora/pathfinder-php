<?php

namespace Pathfinder\Gear\Armor\Armors;

use \Pathfinder\Gear\Armor\Armor;

class Leather extends Armor
{
	public const NAME = "Leather";
    public const TYPE = "LIGHT_ARMOR";
    public const BONUS = 2;
    public const MAX_DEX = 6;
    public const PENALTY = 0;
    public const SPELL_FAILURE = 10;
    public const SPEED_30 = 30;
    public const SPEED_20 = 20;
}