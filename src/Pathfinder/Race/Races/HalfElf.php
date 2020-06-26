<?php 

namespace Pathfinder\Race\Races;

use Pathfinder\Race\Race;
use Pathfinder\Character;
use Pathfinder\CharacterClass\CharacterClass;
use Pathfinder\Feats\Feat\SkillFocus

class HalfElf extends Race
{
	public const NAME = "Half-elf";
	public const SIZE = "M";
	public const SIZE_BONUS = 0;
	public const SPEED = 30;
	public const ADULT_AGE = 20;
	public const RACE_TRAITS = [
		"LOW_LIGHT_VISION",
		"ADAPTABLE",
		"ELVEN_BLOOD",
		"ELVEN_INMUNITIES",
		"KEEN_SENSES"
	];

	public function applyBonusesTo(Character $character, string $statBonus, string $skillToFocus, CharacterClass $secondFavouriteClass): void
	{
		$character->increaseAbilityScore($statBonus, 2);
		$character->addFeat(new SkillFocus($skillToFocus));
		$character->addFavouriteClass($secondFavouriteClass);
	}
}