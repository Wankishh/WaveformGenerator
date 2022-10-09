<?php

namespace App\Models;

class Row
{
	private string $id;
	private ChannelTypes $type;
	private float $seconds;

	public function __construct(string $id, string $type, float $seconds)
	{
		$this->id = $id;
		$this->type = match ($type) {
			"silence_start" => ChannelTypes::SilenceStart,
			"silence_end" => ChannelTypes::SilenceEnd,
			default => throw new \Error("Unknown Channel type")
		};
		$this->seconds = $seconds;
	}

	/**
	 * @return ChannelTypes
	 */
	public function getType(): ChannelTypes
	{
		return $this->type;
	}

	/**
	 * @return float
	 */
	public function getSeconds(): float
	{
		return $this->seconds;
	}
}
