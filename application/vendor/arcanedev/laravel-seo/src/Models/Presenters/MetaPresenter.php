<?php namespace Arcanedev\LaravelSeo\Models\Presenters;

/**
 * Class     MetaPresenter
 *
 * @package  Arcanedev\LaravelSeo\Models\Presenters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string                          title
 * @property  int                             title_length
 * @property  string                          description
 * @property  int                             description_length
 * @property  \Illuminate\Support\Collection  keywords
 * @property  string                          keywords_string
 * @property  int                             keywords_length
 */
trait MetaPresenter
{
    /* -----------------------------------------------------------------
     |  Accessors
     | -----------------------------------------------------------------
     */

    /**
     * Get the `title_length` attribute.
     *
     * @return int
     */
    public function getTitleLengthAttribute()
    {
        return strlen($this->title);
    }

    /**
     * Get the `description_length` attribute.
     *
     * @return int
     */
    public function getDescriptionLengthAttribute()
    {
        return strlen($this->description);
    }

    /**
     * Get the `keywords_string` attribute.
     *
     * @return string
     */
    public function getKeywordsStringAttribute()
    {
        return $this->keywords->implode(', ');
    }

    /**
     * Get the `keywords_length` attribute.
     *
     * @return int
     */
    public function getKeywordsLengthAttribute()
    {
        return strlen($this->keywords_string);
    }
}
