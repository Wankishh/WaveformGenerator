<?php

namespace App;

use App\DTO\Response;
use App\Models\CallLog;
use App\Services\Readers\ChannelReader;
use JsonException;

class WaveformGenerator
{
	private ChannelReader $reader;

	public function __construct(ChannelReader $reader)
	{
		$this->reader = $reader;
	}

	/**
	 * @throws JsonException
	 */
	public function generate(string $userChannelFile, string $customerChannelFile): string
	{
		$userCallLog = new CallLog();
		$customerCallLog = new CallLog();

		$this->reader->read($userChannelFile, $userCallLog);
		$this->reader->read($customerChannelFile, $customerCallLog);

		$response = new Response();
		$response->setLongestUserMonologue($userCallLog->getLongestMonologue());
		$response->setUserTalkPercentage($userCallLog->calculateTotalPercentageOfSpeaking($customerCallLog));
		$response->setUser($userCallLog->getChannel());

		$response->setLongestCustomerMonologue($customerCallLog->getLongestMonologue());
		$response->setCustomer($customerCallLog->getChannel());

		return $response->toJSON();
	}
}

