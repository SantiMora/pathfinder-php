<?php

namespace Pathfinder\CharacterClass\PrestigeClasses;

use Pathfinder\CharacterClass\PrestigeClass;

class EldritchKnight extends PrestigeClass
{
	public const DG = 10;
    public const BAB = 1;
    public const FORTITUDE = true;
    public const REFLEX = true;
    public const WILL = false;
    public const SKILL_RANKS_PER_LEVEL = 4;
    public const CLASS_SKILLS = [
        // TODO
    ];
    public const PROFICIENCIES = [];

    public static function matchRequirements(Character $character): bool
    {
    	// ToDo 
    }
}