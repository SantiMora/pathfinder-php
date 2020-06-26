<?php

namespace Pathfinder\Feat\Feats;

use Pathfinder\Feat\Feat;

class Alertness extends Feat
{
	public const NAME = "Alertness";
	public const AFFECTED_SKILLS = ["perception", "sense motive"]; // See Pathfinder\Character::getSkillBonus
}