<?php

namespace App\DTO;

use App\Utils\Formatter;
use JsonException;

class Response
{
	public function __construct(
		private float $longestUserMonologue = 0,
		private float $longestCustomerMonologue = 0,
		private float $userTalkPercentage = 0,
		private array $user = [],
		private array $customer = []
	) {
	}

	/**
	 * @param  float  $longestUserMonologue
	 */
	public function setLongestUserMonologue(float $longestUserMonologue): void
	{
		$this->longestUserMonologue = $longestUserMonologue;
	}

	/**
	 * @param  float  $longestCustomerMonologue
	 */
	public function setLongestCustomerMonologue(float $longestCustomerMonologue): void
	{
		$this->longestCustomerMonologue = $longestCustomerMonologue;
	}

	/**
	 * @param  float  $userTalkPercentage
	 */
	public function setUserTalkPercentage(float $userTalkPercentage): void
	{
		$this->userTalkPercentage = $userTalkPercentage;
	}

	/**
	 * @param  array  $user
	 */
	public function setUser(array $user): void
	{
		$this->user = $user;
	}

	/**
	 * @param  array  $customer
	 */
	public function setCustomer(array $customer): void
	{
		$this->customer = $customer;
	}

	public function toArray(): array
	{
		return [
			'longest_user_monologue' => Formatter::formatFloat($this->longestUserMonologue),
			'longest_customer_monologue' => Formatter::formatFloat($this->longestCustomerMonologue),
			'user_talk_percentage' => Formatter::formatFloat($this->userTalkPercentage),
			'user' => $this->user,
			"customer" => $this->customer
		];
	}

	/**
	 * @throws JsonException
	 */
	public function toJSON(): string
	{
		return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
	}
}
