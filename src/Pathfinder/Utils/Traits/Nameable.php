<?php

namespace Pathfinder\Utils\Traits;

trait Nameable 
{
	public function getName(): string
	{
		return $this->name ?? $this::NAME ?? null;
	}

	public function setName(string $name): void 
	{
		$this->name = $name;
	}
}