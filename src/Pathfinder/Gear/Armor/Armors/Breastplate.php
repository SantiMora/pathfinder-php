<?php

namespace Pathfinder\Gear\Armor\Armors;

use Pathfinder\Gear\Armor\Armor;

class Breastplate extends Armor
{
	public const NAME = "Breastplate";
    public const TYPE = "MEDIUM_ARMOR";
    public const BONUS = 6;
    public const MAX_DEX = 3;
    public const PENALTY = -4;
    public const SPELL_FAILURE = 25;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}