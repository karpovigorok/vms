<?php namespace Arcanedev\LaravelSeo\Models;

use Arcanedev\LaravelSeo\Seo;
use Illuminate\Support\Arr;

/**
 * Class     Meta
 *
 * @package  Arcanedev\LaravelSeo\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int                                  id
 * @property  int                                  seoable_id
 * @property  string                               seoable_type
 * @property  string                               title
 * @property  string                               description
 * @property  \Illuminate\Support\Collection       keywords
 * @property  boolean                              noindex
 * @property  \Illuminate\Support\Collection       extras
 * @property  \Carbon\Carbon                       created_at
 * @property  \Carbon\Carbon                       updated_at
 *
 * @property  \Illuminate\Database\Eloquent\Model  seoable
 */
class Meta extends AbstractModel
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Presenters\MetaPresenter;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'keywords', 'noindex', 'extras'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'seoable_id' => 'integer',
        'keywords'   => 'collection',
        'noindex'    => 'boolean',
        'extras'     => 'collection',
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

        $this->setTable(Seo::getConfig('metas.table', 'metas'));
    }

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seoable()
    {
        return $this->morphTo();
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Prepare the attributes.
     *
     * @param  array  $attributes
     *
     * @return array
     */
    public static function prepareAttributes(array $attributes)
    {
        return [
            'title'       => Arr::get($attributes, 'title'),
            'description' => Arr::get($attributes, 'description'),
            'keywords'    => Arr::get($attributes, 'keywords', []),
            'extras'      => Arr::get($attributes, 'extras', []),
            'noindex'     => Arr::get($attributes, 'noindex', false),
        ];
    }

    /**
     * Add an extra meta.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return $this
     */
    public function addExtra($key, $value)
    {
        return $this->setExtras(
            $this->extras->put($key, $value)->all()
        );
    }

    /**
     * Add extra metas.
     *
     * @param  mixed  $extras
     *
     * @return $this
     */
    public function addExtras($extras)
    {
        return $this->setExtras(
            $this->extras->merge($extras)->all()
        );
    }

    /**
     * Set the extras.
     *
     * @param  mixed  $extras
     *
     * @return $this
     */
    public function setExtras($extras)
    {
        $this->extras = collect($extras);

        return $this;
    }
}
