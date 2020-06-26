<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use Pathfinder\CharacterClass\CharacterClass;

class Barbarian extends CharacterClass
{
	public const NAME = "Barbarian"; 
    public const HD = 12;
    public const BAB = 1;
    public const FORTITUDE = true;
    public const REFLEX = false;
    public const WILL = false;
    public const SKILL_RANKS_PER_LEVEL = 4;
    public const CLASS_SKILLS = ["acrobatics", "climb", "craft", "handle animal", "intimidate", "knowledge (nature)", "perception", "ride", "survival", "swim"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "MARTIAL_WEAPONS", "LIGHT_ARMOR", "MEDIUM_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS"];
}