<?php 

namespace Pathfinder\Race;

use Pathfinder\Character;
use Pathfinder\Utils\Traits\Nameable;

abstract class Race 
{
	use Nameable;

	// abstract-like properties
	public const NAME = self::NAME;
	public const SIZE = self::SIZE;
	public const SIZE_BONUS = self::SIZE_BONUS;
	public const SPEED = self::SPEED;
	public const ADULT_AGE = self::ADULT_AGE;

	public const RACE_TRAITS = [];
	public const NATURAL_ARMOR = 0;

	private $gender; // M | F | U
	private $age;
	private $raceParameters;

	public function __construct(string $gender, int $age, ... $raceParameters)
	{
		if (! in_array($gender, ["M", "F", "U"])) 
			throw new \Exception("Not valid gender; valid values are M, F or U", 1);

		$this->gender = $gender;
		$this->age = $age;
		$this->raceParameters = $raceParameters;
	}

	abstract public function applyBonusesTo(Character $character);

	public function applyOn(Character $character): void
	{
		$this->applyBonusesTo($character, ... $this->raceParameters);
		unset($this->raceParameters);
	}

	public function getGender(): string
	{
		return $this->gender;
	}

	public function getAge(): int
	{
		return $this->age;
	}

	public function getSize(): string
	{
		return $this::SIZE;
	}

	public function getSizeBonus(): string
	{
		return $this::SIZE_BONUS;
	}
}