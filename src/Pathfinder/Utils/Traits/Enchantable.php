<?php

namespace Pathfinder\Utils\Traits;

trait Enchantable
{
	private $greatQuality;
    private $magicBonus;
    private $magicTraits;

	public function __construct(bool $greatQuality = false, int $magicBonus = 0, array $magicTraits = [], string $name = null)
    {
        if (count($magicTraits) > 0 && $magicBonus < 1) {
            throw new \Exception("You can't create an equipment with magic traits unless it has over 1 magic bonus.", 1);
        }

        foreach ($magicTraits as $magicTrait) {
            if (! is_string($magicTrait) || ! in_array($magicTrait, $this::MAGIC_TRAITS))
                throw new \Exception("Invalid magic trait, or does not exists", 1);
        }

        $this->greatQuality = $greatQuality;
        $this->magicBonus = $magicBonus;
        $this->magicTraits = $magicTraits;

        if (isset($name))
            $this->name = $name;
    }
}