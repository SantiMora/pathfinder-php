<?php

namespace Pathfinder\Feat;

use Pathfinder\Character;
use Pathfinder\Utils\Traits\Nameable;

abstract class Feat
{
	use Nameable;

	// abstract-like properties
	public const NAME = self::NAME;

	public function checkRequirements(Character $character): bool
	{
		return true;
	}
}