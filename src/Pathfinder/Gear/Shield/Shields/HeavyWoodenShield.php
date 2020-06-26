<?php

namespace Pathfinder\Gear\Shield\Shields;

use Pathfinder\Gear\Shield\Shield;

class HeavyWoodenShield extends Shield
{
	public const NAME = "Heavy wooden shield";
	public const TYPE = "HEAVY_SHIELDS";
    public const BONUS = 2;
    public const PENALTY = -2;
    public const SPELL_FAILURE = 10;
}