<?php

$lines = explode("\n", file_get_contents('input.txt'));

function isValidTriangle($sides)
{
	if($sides[0] + $sides[1] > $sides[2] && $sides[0] + $sides[2] > $sides[1] && $sides[1] + $sides[2] > $sides[0]) {
		return true;
	}

	return false;
}

$numberOfValidTriangles = 0;

foreach($lines as $line) {
	$sides = array_values(array_filter(explode(' ', $line), function($value) { return $value !== ''; }));

	if(isValidTriangle($sides)) {
		$numberOfValidTriangles++;
	}
}

echo 'The number of valid triangles is ' . $numberOfValidTriangles . PHP_EOL;

// Part 2
$groups = array_chunk($lines, 3);

$numberOfValidTriangles = 0;

foreach($groups as $group) {
	$possibleTriangles = [
		0 => [],
		1 => [],
		2 => [],
	];

	foreach($group as $line) {
		$sides = array_values(array_filter(explode(' ', $line), function($value) { return $value !== ''; }));

		foreach(range(0, 2) as $i) {
			$possibleTriangles[$i][] = $sides[$i];
		}
	}

	foreach($possibleTriangles as $possibleTriangle) {
		if(isValidTriangle($possibleTriangle)) {
			$numberOfValidTriangles++;
		}
	}
}


echo 'The number of valid triangles is ' . $numberOfValidTriangles . PHP_EOL;