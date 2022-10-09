<?php

namespace App\Utils;

class Formatter
{
	public static function formatFloat(float $num, int $decimals = 2): string
	{
		return number_format($num, $decimals);
	}
}
