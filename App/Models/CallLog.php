<?php

namespace App\Models;

class CallLog
{
	private array $getChannel = [];
	private float $totalSpeakingTime = 0;
	private float $longestMonologue = 0;

	public function addLog(LogPoint $point): void
	{
		$sum = $point->getEnd() - $point->getStart();
		$this->totalSpeakingTime += $sum;
		$this->longestMonologue = max($sum, $this->longestMonologue);
		$this->getChannel[] = [$point->getStart(), $point->getEnd()];
	}

	public function calculateTotalPercentageOfSpeaking(CallLog $otherCallLog): float
	{
		try {
			$totalSpeakingTime = $this->totalSpeakingTime + $otherCallLog->getTotalSpeakingTime();
			return (100 * $this->totalSpeakingTime) / $totalSpeakingTime;
		} catch (\DivisionByZeroError|\Exception $e) {
			return 0;
		}
	}

	/**
	 * @return array
	 */
	public function getChannel(): array
	{
		return $this->getChannel;
	}

	/**
	 * @return float
	 */
	public function getTotalSpeakingTime(): float
	{
		return $this->totalSpeakingTime;
	}

	/**
	 * @return float
	 */
	public function getLongestMonologue(): float
	{
		return $this->longestMonologue;
	}
}
