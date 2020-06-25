<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;

class Elf extends Race
{
	public const NAME = "Elf";
	public const SIZE = "M";
	public const SIZE_BONUS = 0;
	public const SPEED = 30;
	public const ADULT_AGE = 80;
	public const RACE_TRAITS = [
		"LOW_LIGHT_VISION",
		"ELVEN_INMUNITIES",
		"ELVEN_MAGIC",
		"KEEN_SENSES"
	];

	public function applyBonusesTo(Character $character): void
	{
		$character->increaseAbilityScore("dexterity", 2);
		$character->increaseAbilityScore("intelligence", 2);
		$character->increaseAbilityScore("constitution", -2);
	}
}