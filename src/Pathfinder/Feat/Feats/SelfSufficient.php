<?php

namespace Pathfinder\Feat\Feats;

use Pathfinder\Feat\Feat;

class SelfSufficient extends Feat
{
	public const NAME = "Self-sufficient";
	public const AFFECTED_SKILLS = ["heal", "survival"]; // See Pathfinder\Character::getSkillBonus
}