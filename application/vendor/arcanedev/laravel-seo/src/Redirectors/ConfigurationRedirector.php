<?php namespace Arcanedev\LaravelSeo\Redirectors;

use Arcanedev\LaravelSeo\Contracts\Redirector;

/**
 * Class     ConfigurationRedirector
 *
 * @package  Arcanedev\LaravelSeo\Redirectors
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ConfigurationRedirector extends AbstractRedirector implements Redirector
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the redirected URLs.
     *
     * @return array
     */
    public function getRedirectedUrls()
    {
        return $this->getOption('redirects', []);
    }
}
