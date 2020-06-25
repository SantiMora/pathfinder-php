<?php

namespace Pathfinder\CharacterClass\CharacterClasses;

use \Pathfinder\CharacterClass\CharacterClass;

class Wizard extends CharacterClass
{
	public const NAME = "Wizard";
    public const HD = 6;
    public const BAB = 1/2;
    public const FORTITUDE = false;
    public const REFLEX = false;
    public const WILL = true;
    public const SKILL_RANKS_PER_LEVEL = 2;
    public const CLASS_SKILLS = ["appraise", "craft", "fly", "knowledge (arcana)", "knowledge (dungeoneering)", "knowledge (engineering)", "knowledge (geography)", "knowledge (history)", "knowledge (nature)", "knowledge (nobility)", "knowledge (planes)", "knowledge (religion)", "knowledge (local)", "linguistics", "profession", "spellcraft"];
    public const PROFICIENCIES = ["Club", "Dagger", "HeavyCrossbow", "LightCrossbow", "Quarterstaff"];
}