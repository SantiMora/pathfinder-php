<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Rogue extends CharacterClass
{
	public const NAME = "Rogue";
    public const HD = 8;
    public const BAB = 3/4;
    public const FORTITUDE = false;
    public const REFLEX = true;
    public const WILL = false;
    public const SKILL_RANKS_PER_LEVEL = 8;
    public const CLASS_SKILLS = ["acrobatics", "appraise", "bluff", "climb", "craft", "diplomacy", "disable device", "disguise", "escape artist", "intimidate", "knowledge (dungeoneering)", "knowledge (local)", "linguistics", "perception", "perform", "profession", "sense motive", "sleigth of hand", "stealth", "swim", "use magic device"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "HandCrossbow", "Rapier",  "Sap", "Shortbow", "ShortSword", "LIGHT_ARMOR"];
}