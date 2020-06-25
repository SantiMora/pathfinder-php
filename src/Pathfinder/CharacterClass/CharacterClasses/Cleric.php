<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Cleric extends CharacterClass
{
	public const NAME = "Cleric"; 
    public const HD = 8;
    public const BAB = 3/4;
    public const FORTITUDE = true;
    public const REFLEX = false;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 2;
    public const CLASS_SKILLS = ["appraise", "craft", "diplomacy", "heal", "knowledge (arcana)", "knowledge (history)", "knowledge (nobility)", "knowledge (planes)", "knowledge (religion)", "linguistics", "profession", "sense motive", "spellcraft"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "LIGHT_ARMOR", "MEDIUM_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS"];
}