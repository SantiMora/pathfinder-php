<?php

namespace Pathfinder\Feat\Feats;

use Pathfinder\Feat\Feat;

class SkillFocus extends Feat
{
	public const NAME = "Skill Focus";
	private $skillToFocus;

	public function __construct(string $skillToFocus)
	{
		$this->skillToFocus = $skillToFocus;
	}

	public function getSkill(): string
	{
		return $this->skillToFocus;
	}
}