<?php

$lines = explode("\n", file_get_contents('input.txt'));

$position = [0, 0]; // X, Y
$keypad = [
	-1 => [-1 => 1, 0 => 2, 1 => 3],
	0 => [-1 => 4, 0 => 5, 1 => 6],
	1 => [-1 => 7, 0 => 8, 1 => 9],
];
$code = '';

foreach($lines as $line) {
	foreach(str_split($line) as $move) {
		$newPosition = $position;

		switch ($move) {
		 	case 'U':
		 		$newPosition[1]--;
		 		break;

		 	case 'R':
		 		$newPosition[0]++;
		 		break;

		 	case 'D':
		 		$newPosition[1]++;
		 		break;

		 	case 'L':
		 		$newPosition[0]--;
		 		break;
		 }

		 if(max($newPosition) <= 1 && min($newPosition) >= -1) {
		 	$position = $newPosition;
		 }
	}

	$code .= $keypad[$position[1]][$position[0]];
}

echo 'The bathroom code is ' . $code . PHP_EOL;

// Part 2
$position = [-2, 0]; // X, Y
$keypad = [
	-2 => [0 => 1],
	-1 => [-1 => 2, 0 => 3, 1 => 4],
	0 => [-2 => 5, -1 => 6, 0 => 7, 1 => 8, 2 => 9],
	1 => [-1 => 'A', 0 => 'B', 1 => 'C'],
	2 => [0 => 'D'],
];

$code = '';

foreach($lines as $line) {
	foreach(str_split($line) as $move) {
		$newPosition = $position;

		switch ($move) {
		 	case 'U':
		 		$newPosition[1]--;
		 		break;

		 	case 'R':
		 		$newPosition[0]++;
		 		break;

		 	case 'D':
		 		$newPosition[1]++;
		 		break;

		 	case 'L':
		 		$newPosition[0]--;
		 		break;
		 }

		 if(isset($keypad[$newPosition[1]], $keypad[$newPosition[1]][$newPosition[0]])) {
		 	$position = $newPosition;
		 }
	}

	$code .= $keypad[$position[1]][$position[0]];
}

echo 'The bathroom code with the new layout is ' . $code . PHP_EOL;