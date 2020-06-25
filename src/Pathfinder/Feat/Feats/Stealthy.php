<?php

namespace Pathfinder\Feat\Feats;

use \Pathfinder\Feat\Feat;

class Stealthy extends Feat
{
	public const NAME = "Stealthy";
	public const AFFECTED_SKILLS = ["escape artist", "stealth"]; // See Pathfinder\Character::getSkillBonus
}