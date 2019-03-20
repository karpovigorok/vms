<?php namespace Arcanedev\LaravelSeo\Contracts;

use Illuminate\Http\Request;

/**
 * Interface  Redirector
 *
 * @package   Arcanedev\LaravelSeo\Contracts
 * @author    ARCANEDEV <arcanedev.maroc@gmail.com>
 */
interface Redirector
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the redirect url.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response|null
     */
    public function getRedirectFor(Request $request);

    /**
     * Get the redirected URLs.
     *
     * @return array
     */
    public function getRedirectedUrls();
}
