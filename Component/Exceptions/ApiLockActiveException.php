<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 16.01.2018
 * Time: 10:06
 */

namespace PM\PlentyMarketsBundle\Component\Exceptions;

use Exception;
use PM\PlentyMarketsBundle\Component\Helper\ErrorHelper;
use PM\PlentyMarketsBundle\Component\Interfaces\ApiException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;


/**
 * Class ApiLockActiveException
 *
 * @package PM\PlentyMarketsBundle\Component\Exceptions
 */
class ApiLockActiveException extends Exception implements Throwable, ApiException
{

    /**
     * ApiLockActiveException constructor.
     *
     * @param string    $message
     * @param int       $code
     */
    public function __construct($message = 'The api is locked', $code = Response::HTTP_LOCKED, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getInternalCode(): int
    {
        return ErrorHelper::CODE_LIMIT_LOCK;
    }
}