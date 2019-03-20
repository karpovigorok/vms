<?php namespace Arcanedev\LaravelSeo\Redirectors;

use Arcanedev\LaravelSeo\Contracts\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Routing\Registrar as Router;

/**
 * Class     AbstractRedirector
 *
 * @package  Arcanedev\LaravelSeo\Redirectors
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractRedirector implements Redirector
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var \Illuminate\Contracts\Routing\Registrar */
    protected $router;

    /** @var  \Illuminate\Http\Request */
    protected $request;

    /** @var  array */
    protected $options = [];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AbstractRedirector constructor.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @param  array                                    $options
     */
    public function __construct(Router $router, array $options)
    {
        $this->router  = $router;
        $this->options = $options;
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get an option.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return Arr::get($this->options, $key, $default);
    }

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
    public function getRedirectFor(Request $request)
    {
        $this->request = $request;

        collect($this->getRedirectedUrls())->each(function ($redirects, $missingUrl) {
            $this->router->get($missingUrl, function () use ($redirects) {
                return redirect()->to(
                    $this->determineRedirectUrl($redirects),
                    $this->determineRedirectStatusCode($redirects)
                );
            });
        });

        try {
            return $this->router->dispatch($request);
        }
        catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param  array|string  $redirects
     *
     * @return string
     */
    protected function determineRedirectUrl($redirects)
    {
        return $this->resolveRouterParameters(
            is_array($redirects) ? reset($redirects) : $redirects
        );
    }

    /**
     * @param  mixed  $redirects
     *
     * @return int
     */
    protected function determineRedirectStatusCode($redirects)
    {
        return is_array($redirects) ? end($redirects) : Response::HTTP_MOVED_PERMANENTLY;
    }

    /**
     * @param  string  $redirectUrl
     *
     * @return string
     */
    protected function resolveRouterParameters($redirectUrl)
    {
        foreach ($this->router->getCurrentRoute()->parameters() as $key => $value) {
            $redirectUrl = str_replace("{{$key}}", $value, $redirectUrl);
        }

        return $redirectUrl;
    }
}
