<?php

namespace Pathfinder\Gear\Armor\Armors;

use Pathfinder\Gear\Armor\Armor;

class StuddedLeather extends Armor
{
	public const NAME = "Studded leather";
    public const TYPE = "LIGHT_ARMOR";
    public const BONUS = 3;
    public const MAX_DEX = 5;
    public const PENALTY = -1;
    public const SPELL_FAILURE = 15;
    public const SPEED_30 = 30;
    public const SPEED_20 = 20;
}