<?php

namespace Tests;

use App\Utils\Formatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{

	public function test_format_float(): void
	{
		$res = Formatter::formatFloat(0);
		$this->assertSame("0.00", $res);
	}

	public function test_format_float_3_decimals(): void
	{
		$res = Formatter::formatFloat(0, 3);
		$this->assertSame("0.000", $res);
	}

	public function test_format_float_2_digits(): void
	{
		$res = Formatter::formatFloat(10);
		$this->assertSame("10.00", $res);
	}
}
