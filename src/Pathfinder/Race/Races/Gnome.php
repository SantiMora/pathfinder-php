<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;

class Gnome extends Race
{
	public const NAME = "Gnome";
	public const SIZE = "S";
	public const SIZE_BONUS = -1;
	public const SPEED = 20;
	public const ADULT_AGE = 80;
	public const RACE_TRAITS = [
		"LOW_LIGHT_VISION",
		"DEFENSE_TRAINING",
		"GNOME_MAGIC",
		"GNOME_HATE",
		"ILUSSION_RESISTANCE",
		"KEEN_SENSES",
		"OBSESSIVE"
	];

	private $obsessiveSkillTarget;

	public function applyBonusesTo(Character $character, string $obsessiveSkillTarget): void
	{
		$character->increaseAbilityScore("constitution", 2);
		$character->increaseAbilityScore("charisma", 2);
		$character->increaseAbilityScore("strength", -2);

		$this->obsessiveSkillTarget = $obsessiveSkillTarget;
	}

	public function getObsessiveSkillTarget(): string
	{
		return $this->obsessiveSkillTarget;
	}
}