<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 10.07.2017
 * Time: 12:09
 */

namespace PM\PlentyMarketsBundle\Component\Helper;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\BadResponseException;
use JsonException;
use Throwable;


/**
 * Class ResponseHelper
 *
 * @package PM\PlentyMarketsBundle\Component\Helper
 */
class ResponseHelper
{
    /**
     * Get error as string
     *
     *
     */
    public static function getErrorString(Throwable $input): string
    {
        /* Guzzle 8 has getResponse() only on exceptions that came with a response */
        if ($input instanceof BadResponseException) {
            try {
                $json = json_decode($input->getResponse()->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            } catch (JsonException) {
                return 'No valid API response';
            }

            if (false === isset($json['error'])) {
                return $input->getMessage();
            }

            /* API Error */
            if (true === is_string($json['error'])) {
                return $json['error'];
            }

            /* API Exception */
            if (true === isset($json['error']['code'])) {
                return sprintf('Error Code %s', $json['error']['code']);
            }
        }

        return $input->getMessage();
    }

    /**
     * Resource not found exception?
     *
     *
     */
    public static function isResourceNotFoundException(Throwable $throwable): bool
    {
        if (false === ($throwable instanceof ClientException)) {
            return false;
        }

        $body = json_decode($throwable->getResponse()->getBody()->getContents(), true);

        if (true === isset($body['error']['message']) && 'Resource not found.' === $body['error']['message']) {
            return true;
        }

        return false;
    }
}