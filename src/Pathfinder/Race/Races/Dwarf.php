<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;

class Dwarf extends Race
{
	public const NAME = "Dwarf";
	public const SIZE = "M";
	public const SIZE_BONUS = 0;
	public const SPEED = 20;
	public const ADULT_AGE = 80;
	public const RACE_TRAITS = [
		"SLOW",
		"DARKVISION",
		"DEFENSE_TRAINING",
		"GREED",
		"DWARVEN_HATE",
		"RESISTANCE",
		"STABLE",
		"STONE_AFFINITY"
	];

	public function applyBonusesTo(Character $character): void
	{
		$character->increaseAbilityScore("constitution", 2);
		$character->increaseAbilityScore("wisdom", 2);
		$character->increaseAbilityScore("charisma", -2);
	}
}