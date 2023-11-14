<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'post_title', 'post_desc', 'post_content','post_meta_desc','post_meta_keywords','post_status','post_image','cate_post_id','post_slug'
    ];
    protected $primaryKey = 'post_id';
 	protected $table = 'tbl_posts';
}
