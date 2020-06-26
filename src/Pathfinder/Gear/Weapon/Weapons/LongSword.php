<?php

namespace Pathfinder\Gear\Weapon\Weapons;

use Pathfinder\Gear\Weapon\Weapon;

class LongSword extends Weapon
{
    public const NAME = "Longsword";
    public const TYPE = MARTIAL | SLASHING | ONE_HANDED | MELEE;
    public const DAMAGE_DICE = 8;
    public const DAMAGE_DICE_COUNT = 1;
    public const MIN_CRIT = 19;
    public const CRIT_MULTIPLIER = 2;
    public const RANGE = 5;
}