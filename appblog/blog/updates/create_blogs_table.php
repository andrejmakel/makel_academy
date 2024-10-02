<?php
namespace AppBlog\Blog\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateBlogsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appblog_blog_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('text');
            $table->boolean('is_premium')->default(0)->nullable();
            $table->timestamps('published_at');
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appblog_blog_blogs');
    }
};
