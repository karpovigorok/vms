<?php namespace Arcanedev\LaravelSeo\Models;

use Arcanedev\LaravelSeo\Entities\RedirectStatuses;
use Arcanedev\LaravelSeo\Seo;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class     Redirect
 *
 * @package  Arcanedev\LaravelSeo\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int             id
 * @property  string          old_url
 * @property  string          new_url
 * @property  int             status
 * @property  string          status_name
 * @property  \Carbon\Carbon  created_at
 * @property  \Carbon\Carbon  updated_at
 */
class Redirect extends AbstractModel
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['old_url', 'new_url', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
    ];

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Meta constructor.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(Seo::getConfig('redirects.table', 'redirects'));
    }

    /**
     * The "booting" method of the model.
     */
    public static function boot()
    {
        parent::boot();

        // Extract these methods to Event/Listener Classes
        static::saved(function() {
            static::clearCache();
        });

        static::deleted(function() {
            static::clearCache();
        });
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the `status_name` attribute.
     *
     * @return string
     */
    public function getStatusNameAttribute()
    {
        return RedirectStatuses::get($this->status);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create a redirect url.
     *
     * @param  string  $oldUrl
     * @param  string  $newUrl
     * @param  int     $status
     *
     * @return \Arcanedev\LaravelSeo\Models\Redirect
     */
    public static function createOne($oldUrl, $newUrl, $status = Response::HTTP_MOVED_PERMANENTLY)
    {
        $redirect = new self([
            'old_url' => $oldUrl,
            'new_url' => $newUrl,
            'status'  => $status,
        ]);

        $redirect->save();

        return $redirect;
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Clear the cached data.
     */
    protected static function clearCache()
    {
        cache()->forget(
            Seo::getConfig('redirector.drivers.eloquent.options.cache.key', 'seo-redirects')
        );
    }
}
