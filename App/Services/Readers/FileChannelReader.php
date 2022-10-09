<?php

namespace App\Services\Readers;

use App\Models\CallLog;
use App\Models\ChannelTypes;
use App\Models\LogPoint;
use App\Services\Parsers\RowParser;

class FileChannelReader implements ChannelReader
{
	private RowParser $rowParser;

	public function __construct(RowParser $rowParser)
	{
		$this->rowParser = $rowParser;
	}

	/**
	 * Sacrificing a bit of readability in order to improve performance
	 * @param  string  $readable
	 * @param  CallLog  $callLog
	 * @return void
	 */
	public function read(string $readable, CallLog $callLog): void
	{
		if (!file_exists($readable)) {
			return;
		}

		$myFile = fopen($readable, "rb") or die("Unable to open file!");

		$builderSilencePoint = new LogPoint();
		while (!feof($myFile)) {
			$fileRow = fgets($myFile);

			// end of file
			if (!$fileRow) {
				if ($builderSilencePoint->getStart()) {
					$builderSilencePoint->setEnd($builderSilencePoint->start);
					$callLog->addLog($builderSilencePoint);
				}

				break;
			}

			$row = $this->rowParser->parse($fileRow);

			if (!$row) {
				break;
			}

			if ($row->getType() === ChannelTypes::SilenceStart) {
				$builderSilencePoint->setEnd($row->getSeconds());
				$callLog->addLog($builderSilencePoint);
				$builderSilencePoint = new LogPoint();
			} elseif ($row->getType() === ChannelTypes::SilenceEnd) {
				$builderSilencePoint->setStart($row->getSeconds());
			}
		}

		fclose($myFile);
	}
}
