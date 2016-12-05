<?php

$input = 'uqwqemis';
$i = 1;
$password = [];
$passwordPart2 = [];

while(count($password) != 8 || count($passwordPart2) != 8) {
	$hash = md5($input . $i);

	if(substr($hash, 0, 5) === '00000') {
		// Part 1
		if(count($password) != 8) {
			$password[] = substr($hash, 5, 1);

			echo '1) Character ' . count($password) . ' is ' . substr($hash, 5, 1) . ' [' . $hash . ']' . PHP_EOL;
		}	

		// Part 2
		if(count($passwordPart2) != 8) {
			$position = substr($hash, 5, 1);
			$character = substr($hash, 6, 1);

			if(is_numeric($position) && in_array($position, range(0, 7)) && !isset($passwordPart2[$position])) {
				$passwordPart2[$position] = $character;

				echo '2) Character ' . ($position + 1) . ' is ' . $character . ' [' . $hash . ']' . PHP_EOL;
			}
		}
	}

	$i++;
}

ksort($passwordPart2);

echo '1) The complete password is ' . implode('', $password) . PHP_EOL;
echo '2) The complete password is ' . implode('', $passwordPart2) . PHP_EOL;