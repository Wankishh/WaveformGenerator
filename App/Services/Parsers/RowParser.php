<?php

namespace App\Services\Parsers;

use App\Models\Row;

interface RowParser
{
	public function parse(string $row):? Row;
}
