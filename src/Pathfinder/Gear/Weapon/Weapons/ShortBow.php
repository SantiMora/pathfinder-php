<?php

namespace Pathfinder\Gear\Weapon\Weapons;

use \Pathfinder\Gear\Weapon\Weapon;

class ShortBow extends Weapon
{
    public const NAME = "Shortbow";
    public const TYPE = MARTIAL | PIERCING | TWO_HANDED | RANGED;
    public const DAMAGE_DICE = 6;
    public const DAMAGE_DICE_COUNT = 1;
    public const MIN_CRIT = 20;
    public const CRIT_MULTIPLIER = 3;
    public const RANGE = 80;
}