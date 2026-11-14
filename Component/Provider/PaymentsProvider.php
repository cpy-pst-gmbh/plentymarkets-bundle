<?php
/**
 * Created by PhpStorm.
 * User: sjoder
 * Date: 13.07.2017
 * Time: 10:43
 */

namespace PM\PlentyMarketsBundle\Component\Provider;

use Exception;
use PM\PlentyMarketsBundle\Component\Model\Payment\PaymentMethod;
use PM\PlentyMarketsBundle\Component\RestfulUrl;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class PaymentsProvider
 *
 * @package PM\PlentyMarketsBundle\Component\Provider
 */
class PaymentsProvider extends BaseProvider
{
    /**
     * Get Methods
     *
     * @return Exception|PaymentMethod[]
     */
    public function getMethods()
    {
        $response = $this->getResponse(Request::METHOD_GET, RestfulUrl::PAYMENTS_METHODS);
        if ($response instanceof Exception) {
            return $response;
        }

        return $this->getService()->getSerializer()->deserialize($response->getBody()->getContents(), PaymentMethod::class.'[]', 'json');
    }

}