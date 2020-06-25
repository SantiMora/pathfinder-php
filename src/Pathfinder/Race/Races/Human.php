<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;
use Pathfinder\Feat\Feat;

class Human extends Race
{
	public const NAME = "Human";
	public const SIZE = "M";
	public const SIZE_BONUS = 0;
	public const SPEED = 30;
	public const ADULT_AGE = 20;
	public const RACE_TRAITS = [
		"SKILLED"
	];

	public function applyBonusesTo(Character $character, string $statBonus, Feat $additionalFeat): void
	{
		$character->increaseAbilityScore($statBonus, 2);
		$character->addFeat($additionalFeat);
	}
}