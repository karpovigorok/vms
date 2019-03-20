<?php namespace Arcanedev\LaravelSeo;

use Arcanedev\LaravelSeo\Contracts\RedirectorFactory;
use Illuminate\Support\Manager;

/**
 * Class     RedirectorManager
 *
 * @package  Arcanedev\LaravelSeo
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RedirectorManager extends Manager implements RedirectorFactory
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return Seo::getConfig('redirector.default', 'config');
    }

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
    public function driver($driver = null)
    {
        return parent::driver($driver);
    }

    /**
     * Build the config redirector driver.
     *
     * @return \Arcanedev\LaravelSeo\Redirectors\ConfigurationRedirector
     */
    public function createConfigDriver()
    {
        return $this->buildDriver('config');
    }

    /**
     * Build the eloquent redirector driver.
     *
     * @return \Arcanedev\LaravelSeo\Redirectors\EloquentRedirector
     */
    public function createEloquentDriver()
    {
        return $this->buildDriver('eloquent', [
            'model' => Seo::getConfig('redirects.model'),
        ]);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Build the redirector.
     *
     * @param  string  $driver
     * @param  array   $extra
     *
     * @return mixed
     */
    private function buildDriver($driver, array $extra = [])
    {
        $router  = $this->app->make(\Illuminate\Contracts\Routing\Registrar::class);
        $class   = Seo::getConfig("redirector.drivers.$driver.class");
        $options = Seo::getConfig("redirector.drivers.$driver.options", []);

        return new $class($router, array_merge($extra, $options));
    }
}
