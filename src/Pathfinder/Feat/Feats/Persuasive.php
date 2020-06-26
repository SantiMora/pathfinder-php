<?php

namespace Pathfinder\Feat\Feats;

use Pathfinder\Feat\Feat;

class Persuasive extends Feat
{
	public const NAME = "Persuasive";
	public const AFFECTED_SKILLS = ["diplomacy", "intimidate"]; // See Pathfinder\Character::getSkillBonus
}