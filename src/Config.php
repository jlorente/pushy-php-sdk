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

namespace Jlorente\Pushy;

class Config implements ConfigInterface
{

    /**
     * The current package version.
     *
     * @var string
     */
    protected $version;

    /**
     * The Pushy API key.
     *
     * @var string
     */
    protected $apiKey;

    /**
     * The Pushy API token.
     *
     * @var string
     */
    protected $requestRetries;

    /**
     * Constructor.
     *
     * @param  string  $version
     * @param  string  $apiKey
     * @param  string  $requestRetries
     * @return void
     * @throws \RuntimeException
     */
    public function __construct($version, $apiKey, $requestRetries = 0)
    {
        $this->setVersion($version);

        $this->setApiKey($apiKey ?: getenv('PUSHY_API_KEY'));

        $this->setRequestRetries($requestRetries ?? getenv('PUSHY_REQUEST_RETRIES') ?? 0);

        if (!$this->apiKey) {
            throw new \RuntimeException('The Pushy api_key is not defined!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * {@inheritdoc}
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestRetries()
    {
        return $this->requestRetries;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequestRetries($retries)
    {
        $this->requestRetries = $retries;
        return $this;
    }

}
