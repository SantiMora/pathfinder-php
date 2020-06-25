<?php

namespace Pathfinder\Gear\Armor\Armors;

use \Pathfinder\Gear\Armor\Armor;

class ChainShirt extends Armor
{
	public const NAME = "Chain shirt";
    public const TYPE = "LIGHT_ARMOR";
    public const BONUS = 4;
    public const MAX_DEX = 4;
    public const PENALTY = -2;
    public const SPELL_FAILURE = 20;
    public const SPEED_30 = 30;
    public const SPEED_20 = 20;
}