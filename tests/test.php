<?php 

require __DIR__."/../vendor/autoload.php";

use Pathfinder\{Race\Races, CharacterClass\CharacterClasses as Classes, Feat\Feats};
use Pathfinder\Gear\{Armor\Armors, Weapon\Weapons, Shield\Shields};

$race = new Races\Elf("M", 68);

$pj = new \Pathfinder\Character(
	"Pepe",
	"LN",
	[
		'strength' => 14, 
        'dexterity' => 17, 
        'constitution' => 12, 
        'intelligence' => 13, 
        'wisdom' => 11, 
        'charisma' => 9
	],
	$race,
	new Classes\Fighter,
	new Classes\Fighter,
	"HP",
	new Feats\ImprovedInitiative,
	[
		"ride" => 1,
		"swim" => 1,
		"intimidate" => 1,
		"craft" => 1
	],  
    null,
    new Feats\Endurance
);

$pj->addLevel(
	new Classes\Fighter,
	"HP",
	null,
	[
		"ride" => 1,
		"swim" => 1,
		"intimidate" => 1,
		"craft" => 1
	],  
    null
);

$pj->equipArmor(new Armors\BandedMail);
$pj->equipMainWeapon(new Weapons\LongSword);
$pj->equipShield(new Shields\LightWoodenShield);

$pj->prettyPrint();