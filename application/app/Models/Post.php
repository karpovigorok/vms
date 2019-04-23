<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php
namespace App\Models;
use Eloquent;
use Actuallymab\LaravelComment\Commentable;
use Arcanedev\LaravelSeo\Traits\Seoable;

class Post extends Eloquent {

    use Commentable;
    use Seoable;

    /**
     * Comments settings
     */
    protected $canBeRated = false;
    protected $mustBeApproved = false;

	protected $guarded = array();


	public static $rules = array();

	protected $table = 'posts';

	protected $fillable = array('post_category_id', 'user_id', 'title', 'slug', 'image', 'body', 'body_guest', 'access', 'active', 'created_at');

	public function category(){
		return $this->belongsTo('App\Models\PostCategory', 'post_category_id');
	}
}