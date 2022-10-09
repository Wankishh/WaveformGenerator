<?php

namespace Tests;

use App\DTO\Response;
use App\Services\Parsers\RegexRowParser;
use App\Services\Readers\FileChannelReader;
use App\WaveformGenerator;
use JsonException;
use PHPUnit\Framework\TestCase;

class WaveformGeneratorTest extends TestCase
{
	public const BASE_PATH = __DIR__."/assets/";

	public function test_verify_its_working(): void
	{
		$this->assertTrue(true);
	}

	public function test_waveform_generator_exists(): void
	{
		$this->assertNotEmpty(WaveformGenerator::class);
	}

	/**
	 * @throws JsonException
	 */
	public function test_waveform_generate_empty(): void
	{
		$reader = $this->getReader();
		$waveform = new WaveformGenerator($reader);
		$generate = $waveform->generate("1", "2");
		$this->assertEquals((new Response())->toJSON(), $generate);
	}

	/**
	 * @throws JsonException
	 */
	public function test_waveform_generate_with_file_reader(): void
	{
		$reader = $this->getReader();

		$base = self::BASE_PATH;
		$user = $base . "user_channel.txt";
		$customer = $base . "customer_channel.txt";
		$waveform = new WaveformGenerator($reader);

		$generate = $waveform->generate($user, $customer);

		$response = new Response();
		$response->setLongestUserMonologue(3.50);
		$response->setLongestCustomerMonologue(1.84);
		$response->setUserTalkPercentage(65.57);
		$response->setUser([[0,3.504],[6.656,6.656]]);
		$response->setCustomer([[0,1.84],[4.48,4.48]]);

		$this->assertEquals($response->toJSON(), $generate);
	}

	/**
	 * @throws JsonException
	 */
	public function test_waveform_generate_with_file_reader_bad_data(): void
	{
		$reader = $this->getReader();

		$base = self::BASE_PATH;
		$user = $base . "user_channel_1.txt";
		$customer = $base . "customer_channel_1.txt";
		$waveform = new WaveformGenerator($reader);

		$generate = $waveform->generate($user, $customer);

		$response = new Response();
		$response->setLongestUserMonologue(3.504);
		$response->setLongestCustomerMonologue(1.84);
		$response->setUserTalkPercentage(65.57);
		$response->setUser([[0,3.504]]);
		$response->setCustomer([[0,1.84]]);

		$this->assertEquals($response->toJSON(), $generate);
	}

	/**
	 * @throws JsonException
	 */
	public function test_waveform_generate_with_file_reader_empty_data(): void
	{
		$reader = $this->getReader();

		$base = self::BASE_PATH;
		$user = $base . "user_channel_empty.txt";
		$customer = $base . "customer_channel_empty.txt";

		$waveform = new WaveformGenerator($reader);

		$generate = $waveform->generate($user, $customer);
		$response = $this->getEmptyResponse();
		$this->assertEquals($response->toJSON(), $generate);
	}

	/**
	 * @throws JsonException
	 */
	public function test_waveform_generate_with_file_reader_bad_format(): void
	{
		$reader = $this->getReader();
		$base = self::BASE_PATH;
		$user = $base . "user_channel_bad_format.txt";
		$customer = $base . "customer_channel_bad_format.txt";

		$waveform = new WaveformGenerator($reader);

		$generate = $waveform->generate($user, $customer);
		$response = $this->getEmptyResponse();
		$this->assertEquals($response->toJSON(), $generate);
	}

	/**
	 * @return FileChannelReader
	 */
	private function getReader(): FileChannelReader
	{
		$parser = new RegexRowParser();
		return new FileChannelReader($parser);
	}

	/**
	 * @return Response
	 */
	private function getEmptyResponse(): Response
	{
		$response = new Response();
		$response->setLongestUserMonologue(0);
		$response->setLongestCustomerMonologue(0);
		$response->setUserTalkPercentage(0);
		$response->setUser([]);
		$response->setCustomer([]);

		return $response;
	}
}
