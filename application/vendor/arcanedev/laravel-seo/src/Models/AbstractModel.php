<?php namespace Arcanedev\LaravelSeo\Models;

use Arcanedev\LaravelSeo\Seo;
use Arcanedev\Support\Database\Model;

/**
 * Class     AbstractModel
 *
 * @package  Arcanedev\LaravelSeo\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class AbstractModel extends Model
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setConnection(Seo::getConfig('database.connection', null));
        $this->setPrefix(Seo::getConfig('database.prefix', 'seo_'));
    }
}
