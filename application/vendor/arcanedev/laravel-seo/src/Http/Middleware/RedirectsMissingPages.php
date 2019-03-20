<?php namespace Arcanedev\LaravelSeo\Http\Middleware;

use Arcanedev\LaravelSeo\Contracts\RedirectorFactory;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class     RedirectsMissingPages
 *
 * @package  Arcanedev\LaravelSeo\Http\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RedirectsMissingPages
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanedev\LaravelSeo\Contracts\Redirector */
    protected $redirector;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * RedirectsMissingPages constructor.
     *
     * @param  \Arcanedev\LaravelSeo\Contracts\RedirectorFactory  $redirectorManager
     */
    public function __construct(RedirectorFactory $redirectorManager)
    {
        $this->redirector = $redirectorManager->driver();
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Handle the missing pages redirection.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->getStatusCode() !== Response::HTTP_NOT_FOUND)
            return $response;

        return $this->redirector->getRedirectFor($request) ?: $response;
    }
}
