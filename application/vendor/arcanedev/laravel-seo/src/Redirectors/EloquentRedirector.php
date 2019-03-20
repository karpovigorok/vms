<?php namespace Arcanedev\LaravelSeo\Redirectors;

use Arcanedev\LaravelSeo\Contracts\Redirector;
use Arcanedev\LaravelSeo\Models\Redirect;

/**
 * Class     EloquentRedirector
 *
 * @package  Arcanedev\LaravelSeo\Redirectors
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class EloquentRedirector extends AbstractRedirector implements Redirector
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
        return $this->getCachedRedirects()
            ->keyBy('old_url')
            ->transform(function (Redirect $item) {
                return [$item->new_url, $item->status];
            })
            ->toArray();
    }

    /**
     * Get the cached redirection urls.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getCachedRedirects()
    {
        return cache()->remember($this->getOption('cache.key'), $this->getOption('cache.duration'), function () {
            return $this->getRedirectModel()->get();
        });
    }

    /**
     * Get the redirect model.
     *
     * @return \Arcanedev\LaravelSeo\Models\Redirect
     */
    private function getRedirectModel()
    {
        return app(
            $this->getOption('model', \Arcanedev\LaravelSeo\Models\Redirect::class)
        );
    }
}
