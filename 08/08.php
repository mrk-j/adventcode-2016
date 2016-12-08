<?php

$lines = explode(PHP_EOL, file_get_contents('input.txt'));

$display = [];
$displayWidth = 50;
$displayHeight = 6;

foreach(range(0, $displayHeight - 1) as $i) {
	foreach(range(0, $displayWidth - 1) as $j) {
		$display[$i][$j] = false;
	}
}

foreach($lines as $instruction) {
	$parts = explode(' ', $instruction);

	if($parts[0] === 'rect') {
		$size = explode('x', $parts[1]);

		foreach(range(0, $size[1] - 1) as $i) {
			foreach(range(0, $size[0] - 1) as $j) {
				$display[$i][$j] = true;
			}
		}
	} elseif($parts[0] === 'rotate') {
		if($parts[1] === 'column') { 
			$column = array_pop(explode('=', $parts[2]));
			$count = $parts[4];
			
			$state = [];
			$newState = [];

			foreach(range(0, $displayHeight - 1) as $i) {
				$state[$i] = $display[$i][$column];
				$newState[$i] = false;
			}

			foreach($state as $key => $value) {
				if($value) {
					$newColumn = ($key + $count) % $displayHeight;

					$newState[$newColumn] = true;
				}
			}

			foreach(range(0, $displayHeight - 1) as $i) {
				$display[$i][$column] = $newState[$i];
			}
		} elseif($parts[1] === 'row') {
			$row = array_pop(explode('=', $parts[2]));
			$count = $parts[4];
			
			$state = [];
			$newState = [];

			foreach(range(0, $displayWidth - 1) as $j) {
				$state[$j] = $display[$row][$j];
				$newState[$j] = false;
			}

			foreach($state as $key => $value) {
				if($value) {
					$newColumn = ($key + $count) % $displayWidth;

					$newState[$newColumn] = true;
				}
			}

			foreach(range(0, $displayWidth - 1) as $j) {
				$display[$row][$j] = $newState[$j];
			}
		}
	}
}

function outputDisplay($display)
{
	foreach($display as $row) {
		foreach($row as $pixel) {
			echo $pixel ? '#' : '.';
		}

		echo PHP_EOL;
	}

	echo PHP_EOL;
}

function countLitPixels($display) 
{
	$litPixels = 0;

	foreach($display as $row) {
		foreach($row as $pixel) {
			$litPixels += $pixel ? 1 : 0;
		}
	}

	return $litPixels;
}

echo 'The number of lit pixels is ' . countLitPixels($display) . PHP_EOL;
echo 'The display output is ' . PHP_EOL;

outputDisplay($display);