<?php

namespace Pathfinder\Gear\Shield\Shields;

use Pathfinder\Gear\Shield\Shield;

class TowerShield extends Shield
{
	public const NAME = "Tower shield";
	public const TYPE = "TOWER_SHIELDS";
    public const BONUS = 2;
    public const PENALTY = -2;
    public const SPELL_FAILURE = 10;
    public const MAX_DEX = 4;
}