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
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Arcanedev\LaravelSeo\Traits\Seoable;


class Video extends Eloquent implements LikeableContract {

    use Commentable;
    use Likeable;
    use Seoable;


    /**
     * Comments settings
     */
    protected $canBeRated = false;
    protected $mustBeApproved = false;

    protected $guarded = array();


	public static $rules = array(
        //'file' => 'mimetypes:video/h264,application/vnd.apple.mpegurl,application/x-mpegurl,video/3gpp,video/mp4,video/mpeg,video/ogg,video/quicktime,video/webm,video/x-m4v,video/ms-asf,video/x-ms-wmv,video/x-msvideo'
    );

	protected $fillable = array(
        'user_id', 'video_category_id', 'title', 'type', 'access', 'details',
        'description', 'active', 'featured', 'duration', 'image', 'embed_code',
        'created_at', 'original_name', 'path', 'mime_type', 'disk', 'video_id', 'process_status', 'max_height'
    );

	public function tags(){
		return $this->belongsToMany('App\Models\Tag');
	}
    public function user(){
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    public function favorite(){
        return $this->hasMany('App\Models\Favorite', 'video_id', 'id');
    }

//    public function comments(){
//        return $this->hasMany('Comment');
//    }

    public function category() {
        return $this->hasOne('App\Models\VideoCategory', 'id', 'video_category_id');
    }

    public function getTagsIds() {
        $k = 'id';
        $r = [];
        $a = $this->tags->toArray();
        array_walk_recursive ($a,
            function ($item, $key) use ($k, &$r) {if ($key == $k) $r[] = $item;}
        );
        return $r;
    }
    public function getTagsVal() {
        $tags_val_array = array();
        foreach($this->tags as $tag_val) {
            if($tag_val->name != '') {
                array_push($tags_val_array, $tag_val->name);
            }
        }
        if(sizeof($tags_val_array)) {
            return $tags_val_array;
        }
        else {
            return false;
        }
    }

    public function get_dir_path() {
        if(isset($this->id) && $this->id) {
            $id = $this->id;
            $array_path_elements = [
                $id % 100,
                floor($id % 100 / 10),
                $id % 10,
                $id
            ];
            return implode("/", $array_path_elements);
        }
        else {
            return false;
        }
    }

}