<?php

namespace App\Models;

class LogPoint
{

	public float $start;

	public float $end;

	public function __construct(float $start = 0, float $end = 0)
	{
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @param  float  $start
	 */
	public function setStart(float $start): void
	{
		$this->start = $start;
	}

	/**
	 * @param  float  $end
	 */
	public function setEnd(float $end): void
	{
		$this->end = $end;
	}

	/**
	 * @return float
	 */
	public function getStart(): float
	{
		return $this->start;
	}

	/**
	 * @return float
	 */
	public function getEnd(): float
	{
		return $this->end;
	}
}
