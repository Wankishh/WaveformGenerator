<?php

namespace App\Services\Parsers;

use App\Models\Row;

class RegexRowParser implements RowParser
{
	private string $regex = '/^(?<id>\[.*?\])\s(?<type>\w+):\s(?<sec>[0-9.]{0,})/m';

	public function parse(string $row):? Row
	{
		$matches = [];
		preg_match($this->regex, $row, $matches, PREG_UNMATCHED_AS_NULL);

		if (!count($matches)) {
			return null;
		}

		$id = $matches['id'];
		$type = $matches['type'];
		$sec = $matches['sec'];

		return new Row($id, $type, $sec);
	}
}
