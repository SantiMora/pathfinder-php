<?php

namespace Pathfinder\Utils\Traits;

use \Pathfinder\Gear\Armor\Armor;
use \Pathfinder\Gear\Weapon\Weapon;
use \Pathfinder\Gear\Shield\Shield;

trait Equippable
{
	private $armor;
	private $mainHandSlot;
	private $offHandSlot; // for shield or secondary weapon if primary weapon permits it

	public function getArmor(): ?Armor
	{
		return $this->armor;
	}

	public function equipArmor(Armor $armor): void
	{
		$this->armor = $armor;
	}

	public function unequipArmor(): void
	{
		$this->armor = null;
	}

	public function getShield(): ?Shield
	{
		return $this->offHandSlot instanceof Shield ? $this->offHandSlot : null;
	}

	public function getMainWeapon(): ?Weapon
	{
		return $this->mainHandSlot;
	}

	public function getOffHandWeapon(): ?Weapon
	{
		return $this->offHandSlot instanceof Weapon ? $this->offHandSlot : null;
	}

	public function equipMainWeapon(Weapon $weapon): void
	{
		if (($this->offHandSlot instanceof Weapon || $this->offHandSlot instanceof Shield) && $weapon->checkType(TWO_HANDED)) 
			throw new \Exception("You can't equip a two-handed weapon when wielding a secondary one or a shield", 1);

		$this->mainHandSlot = $weapon;
	}

	public function equipOffHandWeapon(Weapon $weapon): void
	{
		if ($this->mainHandSlot instanceof Weapon && $this->mainHandSlot->checkType(TWO_HANDED)) 
			throw new \Exception("You can't equip a secondary weapon while wielding a two-handed weapon", 1);

		$this->offHandSlot = $weapon;
	}

	public function equipShield(Shield $shield): void
	{
		if ($this->mainHandSlot instanceof Weapon && $this->mainHandSlot->checkType(TWO_HANDED))
			throw new \Exception("You can't equip a shield while wielding a two-handed weapon", 1);

		$this->offHandSlot = $shield;
	}

	public function unequipMainHand(): void
	{
		$this->mainHandSlot = null;
	}

	public function unequipOffHand(): void
	{
		$this->offHandSlot = null;
	}
}