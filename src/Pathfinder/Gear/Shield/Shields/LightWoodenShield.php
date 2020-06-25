<?php

namespace Pathfinder\Gear\Shield\Shields;

use \Pathfinder\Gear\Shield\Shield;

class LightWoodenShield extends Shield
{
	public const NAME = "Light wooden shield";
	public const TYPE = "LIGHT_SHIELDS";
    public const BONUS = 1;
    public const PENALTY = -1;
    public const SPELL_FAILURE = 5;
}