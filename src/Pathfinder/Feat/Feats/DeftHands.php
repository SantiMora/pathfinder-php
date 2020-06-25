<?php

namespace Pathfinder\Feat\Feats;

use \Pathfinder\Feat\Feat;

class DeftHands extends Feat
{
	public const NAME = "Deft Hands";
	public const AFFECTED_SKILLS = ["disable device", "sleight of hand"]; // See Pathfinder\Character::getSkillBonus
}