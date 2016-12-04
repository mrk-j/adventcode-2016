<?php

$lines = explode(PHP_EOL, file_get_contents('input.txt'));

class Room
{
	public $encryptedName, $sectorId, $checksum;

	public static function parseInput($room) {
		preg_match('/(.*?)-([0-9]*)\[(.*)\]/i', $room, $matches);

		$room = new self();
		$room->encryptedName = $matches[1];
		$room->sectorId = (int) $matches[2];
		$room->checksum = $matches[3];

		$room->getName();

		return $room;
	}

	public function isValid()
	{
		// Get all character counts
		$characters = array_count_values(str_split(preg_replace('/[^a-z]/i', '', $this->encryptedName)));

		// Sort array
		array_multisort(array_values($characters), SORT_DESC, array_keys($characters), SORT_ASC, $characters);

		// Calculated checksum
		$checksum = implode('', array_slice(array_keys($characters), 0, 5));

		return $checksum === $this->checksum;
	}

	public function getName()
	{
		$characters = str_split(str_replace('-', ' ', $this->encryptedName));

		$alfabet = range('a', 'z');

		return implode('', array_map(function($character) use ($alfabet) {
			if($character !== ' ') {
				return $alfabet[(((array_search($character, $alfabet) + 1) + $this->sectorId) % 26) - 1];
			}

			return $character;
		}, $characters));
	}
}

$rooms = [];

foreach($lines as $line) {
	$rooms[] = Room::parseInput($line);
}

$sumOfSectorIds = array_sum(array_map(function($room) {
	return $room->sectorId;
}, array_filter($rooms, function($room) {
	if(stripos($room->getName(), 'north') !== false) {
		echo 'The sector ID for the room where "north pole objects" are stored is ' . $room->sectorId . PHP_EOL;
	}

	return $room->isValid();
})));

echo 'The sum of the sector IDs of the real rooms is ' . $sumOfSectorIds . PHP_EOL;