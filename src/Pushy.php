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

class Pushy
{

    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The Config repository instance.
     *
     * @var \Jlorente\Pushy\ConfigInterface
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param string $apiKey
     * @param int $requestRetries
     * @return void
     */
    public function __construct($apiKey = null, $requestRetries = null)
    {
        $this->config = new Config(self::VERSION, $apiKey, $requestRetries);
    }

    /**
     * Create a new Pushy API instance.
     *
     * @param string $apiKey
     * @param int $requestRetries
     * @return \Jlorente\Pushy\Pushy
     */
    public static function make($apiKey = null, $requestRetries = null)
    {
        return new static($apiKey, $requestRetries);
    }

    /**
     * Returns the current package version.
     *
     * @return string
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the Config repository instance.
     *
     * @return \Jlorente\Pushy\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Sets the Config repository instance.
     *
     * @param  \Jlorente\Pushy\ConfigInterface  $config
     * @return $this
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Returns the Pushy API key.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->config->getApiKey();
    }

    /**
     * Sets the Pushy API key.
     *
     * @param string $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->config->setApiKey($apiKey);

        return $this;
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return \Jlorente\Pushy\Core\ApiInterface
     */
    public function api()
    {
        return new Api($this->config);
    }

}
