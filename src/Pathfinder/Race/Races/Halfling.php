<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;

class Halfling extends Race
{
	public const NAME = "Halfling";
	public const SIZE = "S";
	public const SIZE_BONUS = -1;
	public const SPEED = 20;
	public const ADULT_AGE = 20;
	public const RACE_TRAITS = [
		"FEARLESS",
		"HALFING_LUCK",
		"FIRM_FEET"
	];

	public function applyBonusesTo(Character $character): void
	{
		$character->increaseAbilityScore("dexterity", 2);
		$character->increaseAbilityScore("charisma", 2);
		$character->increaseAbilityScore("strength", -2);
	}
}