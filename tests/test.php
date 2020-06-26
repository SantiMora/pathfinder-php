<?php 

require __DIR__."/../vendor/autoload.php";

echo "\n\n\n";


//print_r(Pathfinder\Utils\Dice::multipleRoll("4d6", "5d4"));


//die();


$race = new Pathfinder\Race\Races\Elf("M", 68);

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
	new Pathfinder\CharacterClass\CharacterClasses\Fighter,
	new Pathfinder\CharacterClass\CharacterClasses\Fighter,
	"HP",
	new Pathfinder\Feat\Feats\ImprovedInitiative,
	[
		"ride" => 1,
		"swim" => 1,
		"intimidate" => 1,
		"craft" => 1
	],  
    null,
    new \Pathfinder\Feat\Feats\Endurance
);

$pj->addLevel(
	new Pathfinder\CharacterClass\CharacterClasses\Fighter,
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

$pj->equipArmor(new Pathfinder\Gear\Armor\Armors\BandedMail);
$pj->equipMainWeapon(new Pathfinder\Gear\Weapon\Weapons\LongSword);
$pj->equipShield(new Pathfinder\Gear\Shield\Shields\LightWoodenShield);

$pj->prettyPrint();