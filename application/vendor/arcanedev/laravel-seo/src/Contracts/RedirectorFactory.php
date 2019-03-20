<?php namespace Arcanedev\LaravelSeo\Contracts;

/**
 * Interface  RedirectorFactory
 *
 * @package   Arcanedev\LaravelSeo\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface RedirectorFactory
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     *
     * @return \Arcanedev\LaravelSeo\Contracts\Redirector
     */
    public function driver($driver = null);
}
