<?php

namespace Pathfinder\Gear\Shield\Shields;

use Pathfinder\Gear\Shield\Shield;

class HeavyMetalShield extends Shield
{
	public const NAME = "Heavy metal shield";
	public const TYPE = "HEAVY_SHIELDS";
    public const BONUS = 2;
    public const PENALTY = -2;
    public const SPELL_FAILURE = 10;
}