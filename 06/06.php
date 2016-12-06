<?php

$lines = explode(PHP_EOL, file_get_contents('input.txt'));
$characters = [];

foreach($lines as $line) {
	foreach(str_split($line) as $i => $character) {
		$characters[$i][] = $character;
	}
}

$message = '';
$messagePart2 = '';

foreach($characters as $charactersOnPosition) {
	$counts = array_count_values($charactersOnPosition);

	arsort($counts);

	$message .= array_shift(array_keys($counts));

	asort($counts);

	$messagePart2 .= array_shift(array_keys($counts));
}

echo 'The error corrected message is ' . $message . PHP_EOL;
echo 'The error corrected message with the new methodoloy is ' . $messagePart2 . PHP_EOL;
