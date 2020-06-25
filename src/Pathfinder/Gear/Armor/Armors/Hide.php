<?php

namespace Pathfinder\Gear\Armor\Armors;

use \Pathfinder\Gear\Armor\Armor;

class Hide extends Armor
{
	public const NAME = "Hide";
    public const TYPE = "MEDIUM_ARMOR";
    public const BONUS = 4;
    public const MAX_DEX = 4;
    public const PENALTY = -3;
    public const SPELL_FAILURE = 20;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}