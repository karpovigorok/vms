<?php namespace Arcanedev\LaravelSeo\Entities;

use Arcanedev\LaravelSeo\Seo;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class     RedirectStatuses
 *
 * @package  Arcanedev\LaravelSeo\Entities
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RedirectStatuses
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the all status codes.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function keys()
    {
        return collect([
            Response::HTTP_MOVED_PERMANENTLY,
            Response::HTTP_SEE_OTHER,
            Response::HTTP_TEMPORARY_REDIRECT,
            Response::HTTP_PERMANENTLY_REDIRECT,
        ]);
    }

    /**
     * Get the all status names.
     *
     * @param  string|null  $locale
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all($locale = null)
    {
        return static::keys()->mapWithKeys(function ($code) use ($locale) {
            return [$code => Seo::getTrans("redirections.statuses.{$code}", [], $locale)];
        });
    }

    /**
     * Get the status name.
     *
     * @param  int          $key
     * @param  string|null  $default
     * @param  string|null  $locale
     *
     * @return string
     */
    public static function get($key, $default = null, $locale = null)
    {
        return static::all($locale)->get($key, $default);
    }
}
