<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Monk extends CharacterClass
{
	public const NAME = "Monk"; 
    public const HD = 8;
    public const BAB = 3/4;
    public const FORTITUDE = true;
    public const REFLEX = true;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 4;
    public const CLASS_SKILLS = ["acrobatics", "climb", "craft", "escape artist", "intimidate", "knowledge (history)", "knowledge (religion)", "perception", "perform", "profession", "ride", "sense motive", "stealth", "swim"];
    public const PROFICIENCIES = ["BrassKnuckles", "Cestus", "Club", "LightCrossbow", "HeavyCrossbow", "Dagger", "Handaxe", "Javelin", "Kama", "Nunchaku", "Quarterstaff", "Sai", "Shortspear", "ShortSword", "Shuriken", "Siangham", "Sling", "Spear", "TempleSword"];
}