<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;

class HalfOrc extends Race
{
	public const NAME = "Half-orc";
	public const SIZE = "M";
	public const SIZE_BONUS = 0;
	public const SPEED = 30;
	public const ADULT_AGE = 20;
	public const RACE_TRAITS = [
		"DARKVISION",
		"INITIMIDATING",
		"ORC_BLOOD",
		"ORC_FEROCITY"
	];

	public function applyBonusesTo(Character $character, string $statBonus): void
	{
		$character->increaseAbilityScore($statBonus, 2);
	}
}