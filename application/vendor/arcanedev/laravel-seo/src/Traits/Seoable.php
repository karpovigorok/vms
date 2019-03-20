<?php namespace Arcanedev\LaravelSeo\Traits;

use Arcanedev\LaravelSeo\Models\Meta;

/**
 * Trait     Seoable
 *
 * @package  Arcanedev\LaravelSeo\Traits
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  \Arcanedev\LaravelSeo\Models\Meta  seo
 *
 * @method  \Illuminate\Database\Eloquent\Relations\MorphOne  morphOne(string $related, string $name, string $type = null, string $id = null, string $localKey = null)
 */
trait Seoable
{
    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * SEO relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne(Meta::class, 'seoable');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Create a SEO Meta.
     *
     * @param  array  $attributes
     *
     * @return \Arcanedev\LaravelSeo\Models\Meta|mixed
     */
    public function createSeo(array $attributes)
    {
        return $this->seo()->create(
            Meta::prepareAttributes($attributes)
        );
    }

    /**
     * Update a SEO Meta.
     *
     * @param  array  $attributes
     *
     * @return bool
     */
    public function updateSeo(array $attributes)
    {
        return $this->seo->update($attributes);
    }

    /**
     * Delete a seo.
     *
     * @return bool|null
     */
    public function deleteSeo()
    {
        return $this->seo->delete();
    }

    /**
     * Check if it has seo.
     *
     * @return bool
     */
    public function hasSeo()
    {
        return ! is_null($this->seo);
    }
}
