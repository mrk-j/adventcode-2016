<?php

$instructions = explode(', ', file_get_contents('input.txt'));

$location = [0, 0]; // X, Y
$headings = [1, 2, 3, 4]; // North, East, South, West
$heading = 1;

// Part 2
$visited = [$location];
$visitedTwice = false;

function visitLocation($location)
{
	global $visited, $visitedTwice;

	if($visitedTwice) {
		return;
	}

	if(in_array($location, $visited)) {
		$visitedTwice = $location;
	}

	$visited[] = $location;
}

foreach($instructions as $instruction) {
	if(stripos($instruction, 'L') !== false) {
		$heading--;
	} else {
		$heading++;
	}

	if($heading == 0) {
		$heading = 4;
	} elseif($heading == 5) {
		$heading = 1;
	}

	$steps = preg_replace('/[^0-9]/', '', $instruction);

	switch ($heading) {
		case 1:
			foreach(range(1, $steps) as $step) {
				visitLocation([$location[0] + $step, $location[1]]);
			}

			$location[0] += $steps;

			break;

		case 2:
			foreach(range(1, $steps) as $step) {
				visitLocation([$location[0], $location[1] + $step]);
			}

			$location[1] += $steps;
			break;

		case 3:
			foreach(range(1, $steps) as $step) {
				visitLocation([$location[0] - $step, $location[1]]);
			}

			$location[0] -= $steps;
			break;

		case 4:
			foreach(range(1, $steps) as $step) {
				visitLocation([$location[0], $location[1] - $step]);
			}

			$location[1] -= $steps;
			break;
	}
}

echo 'Easter Bunny HQ is ' . (abs($location[0]) + abs($location[1])) . ' blocks away.' . PHP_EOL;
echo 'The first location visited twice is ' . (abs($visitedTwice[0]) + abs($visitedTwice[1])) . ' blocks away.' . PHP_EOL;
