<?php

$lines = explode(PHP_EOL, file_get_contents('input.txt'));

function isAbba($characters) {
	foreach(range(0, strlen($characters) - 4) as $i) {
		$testSequence = substr($characters, $i, 4);

		if($testSequence[0] == $testSequence[3] && $testSequence[1] == $testSequence[2] && $testSequence[0] != $testSequence[1])
		{
			return true;
		}
	}

	return false;
}

function getAba($characters) {
	$array = [];

	foreach(range(0, strlen($characters) - 3) as $i) {
		$testSequence = substr($characters, $i, 3);

		if($testSequence[0] == $testSequence[2])
		{

			$array[] = $testSequence;
		}
	}

	return $array;
}

$numberOfIPsSupportingTLS = 0;
$numberOfIPsSupportingSSL = 0;

foreach($lines as $line) {
	preg_match_all('(\[[a-z]+?\])', $line, $matches);

	$hypernets = array_map(function($hypernet) {
		return str_replace(['[', ']'], '', $hypernet);
	}, $matches[0]);

	$parts = explode('|', preg_replace('(\[[a-z]+\])', '|', $line));

	// Part 1
	$isAbba = false;

	foreach($parts as $part) {
		if(isAbba($part)) {
			$isAbba = true;

			break;
		}
	}

	foreach($hypernets as $hypernet) {
		if(isAbba($hypernet)) {
			$isAbba = false;

			break;
		}
	}

	if($isAbba) {
		$numberOfIPsSupportingTLS++;
	}

	// Part 2
	$isAba = false;

	$abaArray = [];
	$babArray = [];

	foreach($parts as $part) {
		$abaArray = array_merge($abaArray, getAba($part));
	}

	foreach($hypernets as $hypernet) {
		$babArray = array_merge($babArray, getAba($hypernet));
	}

	foreach($abaArray as $aba) {
		foreach ($babArray as $bab) {
			if($aba[0] == $bab[1] && $bab[0] == $aba[1]) {
				$isAba = true;

				break 2;
			}
		}
	}

	if($isAba) {
		$numberOfIPsSupportingSSL++;
	}
}

echo 'The number of IPs supporting TLS is ' . $numberOfIPsSupportingTLS . PHP_EOL;
echo 'The number of IPs supporting SSL is ' . $numberOfIPsSupportingSSL . PHP_EOL;

