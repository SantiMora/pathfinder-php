<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use Pathfinder\CharacterClass\CharacterClass;

class Druid extends CharacterClass
{
	public const NAME = "Druid"; 
    public const HD = 8;
    public const BAB = 3/4;
    public const FORTITUDE = true;
    public const REFLEX = false;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 4;
    public const CLASS_SKILLS = ["climb", "craft", "fly", "handle animal", "heal", "knowledge (geography)", "knowledge (nature)", "perception", "profession", "ride", "spellcraft", "survival", "swim"];
    public const PROFICIENCIES = ["Club", "Dagger", "Dart", "Quarterstaff", "Scimitar", "Scythe", "Sickle", "Shortspear", "Sling", "Spear", "LIGHT_ARMOR", "MEDIUM_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS"]; // TODO check metal armor or shields
}