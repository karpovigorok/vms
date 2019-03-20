<?php namespace Arcanedev\LaravelSeo\Bases;

use Arcanedev\LaravelSeo\Seo;
use Arcanedev\Support\Bases\Migration as BaseMigration;

/**
 * Class     Migration
 *
 * @package  Arcanedev\LaravelSeo\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Migration extends BaseMigration
{
    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Migration constructor.
     */
    public function __construct()
    {
        $this->setConnection(Seo::getConfig('database.connection', null));
        $this->setPrefix(Seo::getConfig('database.prefix', 'seo_'));
    }
}
