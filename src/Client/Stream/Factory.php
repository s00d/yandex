<?php

/**
 * Часть библиотеки для работы с сервисами Яндекса
 *
 * @package    Arhitector\Yandex\Client\Stream
 * @version    2.2
 * @author     Arhitector
 * @license    MIT License
 * @copyright  2016 Arhitector
 * @link       https://github.com/jack-theripper
 */

namespace Arhitector\Yandex\Client\Stream;

use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use Laminas\Diactoros\Stream;

/**
 * Интерфейс для более эффективного управления потоками, нежели то, что предлагает http-php
 *
 * @package Arhitector\Yandex\Client\Stream
 */
class Factory implements StreamFactoryInterface
{
	/**
	 * Create a new stream instance.
	 *
	 * @param string $content
	 */
	public function createStream(string $content = ''): StreamInterface
	{
		$stream = new Stream('php://temp', 'rb+');

		if ($content !== '') {
			$stream->write($content);
			$stream->rewind();
		}

		return $stream;
	}

	public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
	{
		return new Stream($filename, $mode);
	}

	public function createStreamFromResource($resource): StreamInterface
	{
		return new Stream($resource);
	}
}
