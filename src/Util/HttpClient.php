<?php

namespace BlueMedia\OnlinePayments\Util;

use GuzzleHttp;

/**
 * HttpClient.
 *
 * @author    Piotr Żuralski <piotr@zuralski.net>
 * @copyright 2017 Blue Media
 * @package   BlueMedia\OnlinePayments\Util
 * @since     2017-09-30
 * @version   2.4.1
 */
class HttpClient
{
    /** @var GuzzleHttp\Client */
    private $guzzleClient = null;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleHttp\Client(array(
            GuzzleHttp\RequestOptions::ALLOW_REDIRECTS => false,
            GuzzleHttp\RequestOptions::HTTP_ERRORS => false,
            GuzzleHttp\RequestOptions::VERIFY => true,
            'exceptions' => false,
        ));
    }

    /**
     * Perform POST request.
     *
     * @param  string                              $url
     * @param  array                               $headers
     * @param  null                                $data
     * @param  array                               $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post($url, array $headers = array(), $data = null, array $options = array())
    {
        $options = array_merge($options, array(
            GuzzleHttp\RequestOptions::HEADERS => $headers,
            GuzzleHttp\RequestOptions::FORM_PARAMS => $data,
        ));

        return $this->guzzleClient->post($url, $options);
    }
}
