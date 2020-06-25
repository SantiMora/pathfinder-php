<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Bard extends CharacterClass
{
	public const NAME = "Bard"; 
    public const HD = 8;
    public const BAB = 3/4;
    public const FORTITUDE = false;
    public const REFLEX = true;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 6;
    public const CLASS_SKILLS = [
        "acrobatics", "appraise", "bluff", "climb", "craft", "diplomacy", "disguise", "escape artist", "intimidate", "knowledge (arcana)", "knowledge (dungeoneering)", "knowledge (engineering)", "knowledge (geography)", "knowledge (history)", "knowledge (nature)", "knowledge (local)", "knowledge (nobility)", "knowledge (planes)", "knowledge (religion)", "linguistics", "perception", "perform", "profession", "sense motive", "sleight of hand", "spellcraft", "stealth", "use magic device"];
    public const PROFICIENCIES = ["SIMPLE_WEAPONS", "Longsword", "Rapier", "Sap", "Shortsword", "Shortbow", "Whip", "LIGHT_ARMOR", "LIGHT_SHIELDS", "HEAVY_SHIELDS"];
}