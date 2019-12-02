<?php

/**
 * Part of the Pushy package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Pushy
 * @version    1.0.0
 * @author     Jose Lorente
 * @license    BSD License (3-clause)
 * @copyright  (c) 2019, Jose Lorente

 */

namespace Jlorente\Pushy\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use Jlorente\Pushy\ConfigInterface;
use Jlorente\Pushy\Exception\Handler;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Api implements ApiInterface
{

    /**
     * The Config repository instance.
     *
     * @var \Jlorente\Pushy\ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param \Jlorente\Pushy\ConfigInterface $config
     * @return void
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function baseUrl()
    {
        return 'https://api.pushy.me';
    }

    /**
     * {@inheritdoc}
     */
    public function _get($url = null, $parameters = [])
    {
        return $this->execute('get', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _head($url = null, array $parameters = [])
    {
        return $this->execute('head', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function _options($url = null, array $parameters = [])
    {
        return $this->execute('options', $url, $parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        try {
            $response = $this->getClient()->{$httpMethod}('/' . $url, $parameters);

            return json_decode((string) $response->getBody(), true);
        } catch (ClientException $e) {
            new Handler($e);
        }
    }

    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client([
            'base_uri' => $this->baseUrl(), 'handler' => $this->createHandler()
        ]);
    }

    /**
     * Create the client handler.
     *
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler()
    {
        $stack = HandlerStack::create();

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) {
                    $uri = $request->getUri();
                    $query = $uri->getQuery();
                    $query .= ( $query ? '&' : '' ) . http_build_query([
                                'api_key' => $this->config->getApiKey()
                    ]);

                    return new Request(
                            $request->getMethod(),
                            $uri->withQuery($query),
                            $request->getHeaders(),
                            $request->getBody(),
                            $request->getProtocolVersion()
                    );
                }));

        $stack->push(Middleware::retry(function ($retries, RequestInterface $request, ResponseInterface $response = null, TransferException $exception = null) {
                    return $retries < $this->config->getRequestRetries() && ($exception instanceof ConnectException || ($response && $response->getStatusCode() >= 500));
                }, function ($retries) {
                    return (int) pow(2, $retries) * 1000;
                }));

        return $stack;
    }

}
