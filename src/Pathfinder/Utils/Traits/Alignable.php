<?php

namespace Pathfinder\Utils\Traits;

trait Alignable 
{
	public function getAlignment(): string
	{
		return str_replace("NN", "N", $this->alignment);
	}

	public function setAlignment(string $alignment): void 
	{
		// True neutral correction for admit just "N"
		if ($alignment === "N") {
			$alignment = "NN";
		}

		if (preg_match("/^[LNC][GNE]$/", $alignment)) {
			$this->alignment = $alignment;
		} else {
			throw new Exception("Not valid alignment", 1);
		}
	}

	public function checkAlignment(string $pattern): bool
	{
		return preg_match($pattern, $this->alignment) != false;
	}

	public function isLawful(): bool
	{
		return $this->checkAlignment("/^L.$/");
	}

	public function isChaotic(): bool
	{
		return $this->checkAlignment("/^C.$/");
	}

	public function isGood(): bool
	{
		return $this->checkAlignment("/^.G$/");
	}

	public function isEvil(): bool
	{
		return $this->checkAlignment("/^.E$/");
	}
}