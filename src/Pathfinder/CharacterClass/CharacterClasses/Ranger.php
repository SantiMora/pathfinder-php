<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Ranger extends CharacterClass
{
	public const NAME = "Ranger";
    public const HD = 10;
    public const BAB = 1;
    public const FORTITUDE = true;
    public const REFLEX = true;
    public const WILL = false;
    public const SKILL_RANKS_PER_LEVEL = 6;
    public const CLASS_SKILLS = ["climb", "craft", "handle animal", "heal", "intimidate", "knowledge (dungeoneering)", "knowledge (geography)", "knowledge (nature)", "perception", "profession", "ride", "spellcraft", "stealth", "survival", "swim"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "MARTIAL_WEAPONS", "LIGHT_ARMOR", "MEDIUM_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS"];
}