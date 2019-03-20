<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php

namespace App\Models;

use Actuallymab\LaravelComment\Models\Comment as CommentLaravel;
use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;

class Comment extends CommentLaravel implements LikeableContract {

    use Likeable;


    public function user(){
        return $this->hasOne('App\User', 'id', 'commented_id');
    }

    public function replies() {
        return $this->hasMany('App\Models\Comment', 'parent_id', 'id');
    }

}

