<?php

namespace Pathfinder\Utils;

class Dice {

	static public function roll($diceRegex)
	{
		if (preg_match("/^(\d*)?d(2|3|4|6|8|10|12|20|100)$/", $diceRegex, $matches)) {

			list($expr, $diceNumber, $diceValue) = $matches; 
			
			$results = array_map(function () use ($diceValue) {
				return rand(1, $diceValue);
			}, array_fill(0, (empty($diceNumber) ? 1 : $diceNumber), null));

			return (object) [
				"result" => array_sum($results),
				"result_explained" => $results
			];

		} else {
			throw new \Exception("Not valid dice roll", 1);
		}
	}

	static public function multipleRoll(... $diceRegexes) {

		$totalValue = 0;

		$results = array_map(function ($diceRegex) use (&$totalValue) {

			$roll = self::roll($diceRegex);
			$totalValue += $roll->result;

			return $roll->result_explained;
		}, $diceRegexes);

		return [
			"result" => $totalValue,
			"result_explained" => array_combine($diceRegexes, $results)
		];

	}
}