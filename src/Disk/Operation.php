<?php

/**
 * Часть библиотеки для работы с сервисами Яндекса
 *
 * @package    Arhitector\Yandex\Disk
 * @version    2.2
 * @author     Arhitector
 * @license    MIT License
 * @copyright  2016 Arhitector
 * @link       https://github.com/jack-theripper
 */

namespace Arhitector\Yandex\Disk;

use Arhitector\Yandex\Disk;
use Psr\Http\Message\UriInterface;
use Laminas\Diactoros\Request;

/**
 * Получение информации об асинхронной операции.
 *
 * @package Arhitector\Yandex\Disk
 */
class Operation
{

	/**
	 * @const   успешно
	 */
	const SUCCESS = 'success';

	/**
	 * @const   выполняется
	 */
	const PENDING = 'in-progress';

	/**
	 * @const   неудача
	 */
	const FAILED = 'failed';

	/**
	 * @var \Psr\Http\Message\UriInterface
	 */
	protected $uri;

	/**
	 * @var \Arhitector\Yandex\Disk объект диска, породивший ресурс.
	 */
	protected $parent;

	/**
	 * @var string  идентификатор асинхронной операции.
	 */
	protected $identifier;


	/**
	 * Конструктор.
	 *
	 * @param string $identifier   идентификатор операции.
	 */
	public function __construct(string $identifier, Disk $disk, UriInterface $uri)
	{
		$this->uri = $uri;
		$this->parent = $disk;
		$this->identifier = $identifier;
	}

	/**
	 * Текстовый статус операции.
	 *
	 * @return  string|null NULL если не удалось получить статус.
	 * @throws \JsonException
	 */
	public function getStatus():?string
	{
		$response = $this->parent->send(new Request($this->uri->withPath($this->uri->getPath() . 'operations/'
			. $this->getIdentifier()), 'GET'));

		if ($response->getStatusCode() === 200) {
			$response = json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);

			if (isset($response['status'])) {
				return $response['status'];
			}
		}

		return null;
	}

	/**
	 * Получает используемый идентификатор.
	 *
	 * @return string
	 */
	public function getIdentifier():string
	{
		return $this->identifier;
	}

	/**
	 * Проверяет успешна ли операция.
	 *
	 * @return bool
	 * @throws \JsonException
	 */
	public function isSuccess():bool
	{
		return $this->getStatus() == self::SUCCESS;
	}

	/**
	 * Если операция завершилась неудачей.
	 *
	 * @return  bool
	 * @throws \JsonException
	 */
	public function isFailure():bool
	{
		return $this->getStatus() !== 'success';
	}

	/**
	 * Операция в процессе выполнения.
	 *
	 * @return bool
	 * @throws \JsonException
	 */
	public function isPending():bool
	{
		return $this->getStatus() === self::PENDING;
	}
}
