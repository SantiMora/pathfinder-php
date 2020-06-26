<?php

namespace Pathfinder\Feat\Feats;

use Pathfinder\Feat\Feat;

class MagicalAptitude extends Feat
{
	public const NAME = "Magical Aptitude";
	public const AFFECTED_SKILLS = ["spellcraft", "magic device"]; // See Pathfinder\Character::getSkillBonus
}