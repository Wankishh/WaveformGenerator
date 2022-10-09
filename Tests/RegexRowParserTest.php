<?php

namespace Tests;

use App\Models\ChannelTypes;
use App\Services\Parsers\RegexRowParser;
use PHPUnit\Framework\TestCase;

class RegexRowParserTest extends TestCase
{
	private RegexRowParser $parser;

	public function __construct(?string $name = null, array $data = [], $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
		$this->parser = new RegexRowParser();
	}

	public function test_empty_row(): void
	{
		$row = $this->parser->parse("");
		$this->assertEmpty($row);
	}

	public function test_wrong_format(): void
	{
		$parseRow = "[silencedetect @ 0x7fbfbbc076a0] 3.504";
		$row = $this->parser->parse($parseRow);
		$this->assertEmpty($row);
	}

	public function test_with_int_seconds(): void
	{
		$parseRow = "[silencedetect @ 0x7fbfbbc076a0] silence_start: 3";
		$row = $this->parser->parse($parseRow);
		$this->assertSame(3.0, $row->getSeconds());
	}

	public function test_with_seconds_float(): void
	{
		$parseRow = "[silencedetect @ 0x7fbfbbc076a0] silence_start: 3.23";
		$row = $this->parser->parse($parseRow);
		$this->assertSame(3.23, $row->getSeconds());
	}

	public function test_correct_formatting_with_silence_start(): void
	{
		$parseRow = "[silencedetect @ 0x7fbfbbc076a0] silence_start: 3";
		$row = $this->parser->parse($parseRow);
		$this->assertSame(ChannelTypes::SilenceStart, $row->getType());
	}

	public function test_correct_formatting_with_silence_end(): void
	{
		$parseRow = "[silencedetect @ 0x7fbfbbc076a0] silence_end: 3";
		$row = $this->parser->parse($parseRow);
		$this->assertSame(ChannelTypes::SilenceEnd, $row->getType());
	}
}
