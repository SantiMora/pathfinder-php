<?php


namespace Pathfinder\Gear\Weapon\Weapons;

use \Pathfinder\Gear\Weapon\Weapon;


class Quarterstaff extends Weapon
{
    public const NAME = "Quarterstaff";
    public const TYPE = SIMPLE | BLUDGEONING | LIGHT | MELEE;
    public const DAMAGE_DICE = 6;
    public const DAMAGE_DICE_COUNT = 1;
    public const MIN_CRIT = 20;
    public const CRIT_MULTIPLIER = 2;
    public const RANGE = 5;
}