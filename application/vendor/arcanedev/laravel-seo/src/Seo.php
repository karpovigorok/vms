<?php namespace Arcanedev\LaravelSeo;

/**
 * Class     Seo
 *
 * @package  Arcanedev\LaravelSeo
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Seo
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const KEY = 'laravel-seo';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the seo config.
     *
     * @param  string|null  $key
     * @param  mixed|null   $default
     *
     * @return mixed
     */
    public static function getConfig($key = null, $default = null)
    {
        $key = self::KEY.(is_null($key) ? '' : '.'.$key);

        return config()->get($key, $default);
    }

    /**
     * Set the seo config.
     *
     * @param  string      $key
     * @param  mixed|null  $value
     */
    public static function setConfig($key, $value = null)
    {
        config()->set(self::KEY.'.'.$key, $value);
    }

    /**
     * Get the seo translation.
     *
     * @param  string  $key
     * @param  array   $replace
     * @param  string  $locale
     *
     * @return string
     */
    public static function getTrans($key = null, $replace = [], $locale = null)
    {
        return trans(self::KEY.'::'.$key, $replace, $locale);
    }
}
