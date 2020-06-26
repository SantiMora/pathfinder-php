<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use Pathfinder\Character;
use Pathfinder\CharacterClass\CharacterClass;
use Pathfinder\Feat\Feat;

class Fighter extends CharacterClass
{
	public const NAME = "Fighter"; 
    public const HD = 10;
    public const BAB = 1;
    public const FORTITUDE = true;
    public const REFLEX = false;
    public const WILL = false;
    public const SKILL_RANKS_PER_LEVEL = 2;
    public const CLASS_SKILLS = ["climb", "craft", "handle animal", "intimidate", "knowledge (dungeoneering)", "knowledge (engineering)", "profession", "ride", "survival", "swim"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "MARTIAL_WEAPONS", "LIGHT_ARMOR", "MEDIUM_ARMOR", "HEAVY_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS", "TOWER_SHIELDS"];

    public function __lv1(Character $character, Feat $feat)
    {

    }
}