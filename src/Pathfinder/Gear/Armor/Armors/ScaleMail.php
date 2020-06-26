<?php

namespace Pathfinder\Gear\Armor\Armors;

use Pathfinder\Gear\Armor\Armor;

class ScaleMail extends Armor
{
	public const NAME = "Scale mail";
    public const TYPE = "MEDIUM_ARMOR";
    public const BONUS = 5;
    public const MAX_DEX = 3;
    public const PENALTY = -4;
    public const SPELL_FAILURE = 25;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}