<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use Pathfinder\CharacterClass\CharacterClass;

class Sorcerer extends CharacterClass
{
	public const NAME = "Sorcerer";
    public const HD = 6;
    public const BAB = 1/2;
    public const FORTITUDE = false;
    public const REFLEX = false;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 2;
    public const CLASS_SKILLS = ["appraise", "bluff", "craft", "fly", "intimidate", "knowledge (arcana)", "profession", "spellcraft", "use magic device"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS"];
}