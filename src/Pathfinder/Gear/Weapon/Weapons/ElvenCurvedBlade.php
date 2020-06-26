<?php

namespace Pathfinder\Gear\Weapon\Weapons;

use Pathfinder\Gear\Weapon\Weapon;

class ElvenCurvedBlade extends Weapon
{
    public const NAME = "Elven curved blade";
    public const TYPE = EXOTIC | SLASHING | TWO_HANDED | MELEE | FINESSE;
    public const DAMAGE_DICE = 10;
    public const DAMAGE_DICE_COUNT = 1;
    public const MIN_CRIT = 18;
    public const CRIT_MULTIPLIER = 2;
    public const RANGE = 5;
}