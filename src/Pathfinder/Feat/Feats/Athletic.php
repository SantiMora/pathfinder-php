<?php

namespace Pathfinder\Feat\Feats;

use Pathfinder\Feat\Feat;

class Athletic extends Feat
{
	public const NAME = "Athletic";
	public const AFFECTED_SKILLS = ["climb", "swim"]; // See Pathfinder\Character::getSkillBonus
}