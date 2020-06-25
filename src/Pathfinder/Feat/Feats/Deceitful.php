<?php

namespace Pathfinder\Feat\Feats;

use \Pathfinder\Feat\Feat;

class Deceitful extends Feat
{
	public const NAME = "Deceitful";
	public const AFFECTED_SKILLS = ["bluff", "disguise"]; // See Pathfinder\Character::getSkillBonus
}