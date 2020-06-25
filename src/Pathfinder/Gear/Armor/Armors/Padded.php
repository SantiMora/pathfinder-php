<?php

namespace Pathfinder\Gear\Armor\Armors;

use \Pathfinder\Gear\Armor\Armor;

class Padded extends Armor
{
	public const NAME = "Quilted cloth";
    public const TYPE = "LIGHT_ARMOR";
    public const BONUS = 1;
    public const MAX_DEX = 8;
    public const PENALTY = 0;
    public const SPELL_FAILURE = 5;
    public const SPEED_30 = 30;
    public const SPEED_20 = 20;
}