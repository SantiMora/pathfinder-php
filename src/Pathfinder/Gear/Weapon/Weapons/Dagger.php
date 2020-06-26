<?php

namespace Pathfinder\Gear\Weapon\Weapons;

use Pathfinder\Gear\Weapon\Weapon;

class Dagger extends Weapon
{
    public const NAME = "Dagger";
    public const TYPE = SIMPLE | PIERCING | SLASHING | LIGHT | MELEE;
    public const DAMAGE_DICE = 4;
    public const DAMAGE_DICE_COUNT = 1;
    public const MIN_CRIT = 19;
    public const CRIT_MULTIPLIER = 2;
    public const RANGE = 5;
}