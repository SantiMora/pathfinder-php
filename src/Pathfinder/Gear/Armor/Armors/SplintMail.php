<?php

namespace Pathfinder\Gear\Armor\Armors;

use \Pathfinder\Gear\Armor\Armor;

class SplintMail extends Armor
{
	public const NAME = "Splint mail";
    public const TYPE = "HEAVY_ARMOR";
    public const BONUS = 7;
    public const MAX_DEX = 0;
    public const PENALTY = -7;
    public const SPELL_FAILURE = 40;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}