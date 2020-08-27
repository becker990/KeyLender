<?php

function rndlower() {
	return chr(rand(97,122));
}

function rndbyte() {
	return chr(rand(0,255));
}

function gen_rand_vec($size, callable $func) {
	$s = "";
	for ($i = 0; $i < $size; $i++) {
		$s .= $func();
	}
	return $s;
}