<?php

namespace App\Services\Readers;

use App\Models\CallLog;
use App\Services\Parsers\RowParser;

interface ChannelReader
{
	public function __construct(RowParser $parser);
	public function read(string $readable, CallLog $callLog): void;
}
