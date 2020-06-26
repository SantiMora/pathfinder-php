<?php 

namespace Pathfinder\CharacterClass;

use Pathfinder\Character;
use Pathfinder\Utils\Traits\Nameable;

abstract class CharacterClass
{
    use Nameable;

	// abstract-like properties
	public const NAME = self::NAME;	
	public const HD = self::HD;
	public const BAB = self::BAB;
	public const FORTITUDE = self::FORTITUDE;
	public const REFLEX = self::REFLEX;
	public const WILL = self::WILL;
	public const SKILL_RANKS_PER_LEVEL = self::SKILL_RANKS_PER_LEVEL;
	public const CLASS_SKILLS = self::CLASS_SKILLS;
	public const PROFICIENCIES = self::PROFICIENCIES;

    private $level = 0;

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getBaseAttackBonus(): int
    {
        return floor($this->level * $this::BAB);
    }

    public function getSavingThrow(string $st): int
    {
        if (!in_array($st, ["FORTITUDE", "REFLEX", "WILL"])) 
            throw new \Exception("Not valid saving throw", 1);

        $className = get_called_class();
        $isHigh = constant("{$className}::{$st}");

        return floor(($isHigh ? 2 : 0) + (($isHigh ? (1/2) : (1/3)) * $this->level));    
    }

    public function levelUp(Character $character, ... $arguments): void
    {
    	$this->level++; 
    	$levelMethod = "__lv{$this->level}";

    	if (method_exists($this, $levelMethod)) 
    		$this->{$levelMethod}($character, ...$arguments);
    }

    /* 
	*	Level function Sample
	*
	*	protected function __lv1($argument1, ...)
    *	{
    *		// 	Code
    *	}
	*
    */
}