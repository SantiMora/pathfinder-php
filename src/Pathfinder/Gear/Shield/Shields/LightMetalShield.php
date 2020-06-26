<?php

namespace Pathfinder\Gear\Shield\Shields;

use Pathfinder\Gear\Shield\Shield;

class LightMetalShield extends Shield
{
	public const NAME = "Light metal shield";
	public const TYPE = "LIGHT_SHIELDS";
    public const BONUS = 1;
    public const PENALTY = -1;
    public const SPELL_FAILURE = 5;
}