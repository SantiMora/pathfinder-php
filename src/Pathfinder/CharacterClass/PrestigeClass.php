<?php

namespace Pathfinder\CharacterClass;

use \Pathfinder\Character;

abstract class PrestigeClass extends CharacterClass
{
    public static abstract function matchRequirements(Pj $pj): bool;

    private function __construct() 
    {} // Se isntancia por self::apply

    public static function applyTo(Character $character): PrestigeClass
    {
        $class = get_called_class();

        if (! $class::matchRequirements($character)) 
            throw new Exception("Character does not meet the requirements of ". $this::NAME, 1);
            
        return new $class;
    }

    public function getSavingThrow($st): int
    {
        if (! in_array($st, ["FORTITUDE", "REFLEX", "WILL"])) 
            throw new \Exception("Not valid saving throw", 1);

        $className = get_called_class();
        $isHigh = constant("{$className}::{$st}");

        return floor(($this->getLevel() + 1) / ($isHigh ? 2 : 3));
    }
}