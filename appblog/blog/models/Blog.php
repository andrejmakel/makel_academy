<?php namespace AppBlog\Blog\Models;

use Model;

/**
 * Blog Model
 *
 * @link https://docs.octobercms.com/3.x/extend/system/models.html
 */
class Blog extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string table name
     */
    public $table = 'appblog_blog_blogs';

    /**
     * @var array rules for validation
     */
    public $rules = [];
}
