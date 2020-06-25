<?php

namespace Pathfinder\Feat\Feats;

use \Pathfinder\Feat\Feat;

class AnimalAffinity extends Feat
{
	public const NAME = "Animal Affinity";
	public const AFFECTED_SKILLS = ["handle animal", "ride"]; // See Pathfinder\Character::getSkillBonus
}