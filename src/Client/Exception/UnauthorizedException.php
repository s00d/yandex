<?php

/**
 * Часть библиотеки для работы с сервисами Яндекса
 *
 * @package    Arhitector\Yandex\Client\Exception
 * @version    2.2
 * @author     Arhitector
 * @license    MIT License
 * @copyright  2016 Arhitector
 * @link       https://github.com/jack-theripper
 */
namespace Arhitector\Yandex\Client\Exception;

use Http\Client\Exception;

/**
 * Исключение не авторизован.
 */
class UnauthorizedException extends \RuntimeException implements Exception
{
	/**
	 * Конструктор.
	 *
	 * @access  public
	 *
	 * @param string $message Сообщение исключения
	 * @param int $code Код исключения
	 * @param \Exception|null $previous Предыдущее исключение
	 */
	public function __construct($message, $code = 401, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}