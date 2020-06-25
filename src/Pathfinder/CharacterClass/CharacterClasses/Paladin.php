<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Paladin extends CharacterClass
{
	public const NAME = "Paladin"; 
    public const HD = 10;
    public const BAB = 1;
    public const FORTITUDE = true;
    public const REFLEX = false;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 2;
    public const CLASS_SKILLS = ["craft", "diplomacy", "handle animal", "heal", "knowledge (nobility)", "knowledge (religion)", "profession", "ride", "sense motive", "spellcraft"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "MARTIAL_WEAPONS", "LIGHT_ARMOR", "MEDIUM_ARMOR", "HEAVY_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS"];
}