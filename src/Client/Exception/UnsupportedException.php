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
 * Исключение некорректные данные.
 */
class UnsupportedException extends \RuntimeException implements Exception
{

}