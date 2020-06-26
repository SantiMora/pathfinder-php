<?php

namespace Pathfinder\Gear\Armor\Armors;

use Pathfinder\Gear\Armor\Armor;

class Chainmail extends Armor
{
	public const NAME = "Chainmail";
    public const TYPE = "MEDIUM_ARMOR";
    public const BONUS = 6;
    public const MAX_DEX = 2;
    public const PENALTY = -5;
    public const SPELL_FAILURE = 30;
    public const SPEED_30 = 20;
    public const SPEED_20 = 15;
}