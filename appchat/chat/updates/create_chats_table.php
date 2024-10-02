<?php
namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateChatsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appchat_chat_chats', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Optional name for the chat
            $table->unsignedBigInteger('user_one_id');
            $table->unsignedBigInteger('user_two_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_one_id')->references('id')->on('appuser_user_users')->onDelete('cascade');
            $table->foreign('user_two_id')->references('id')->on('appuser_user_users')->onDelete('cascade');
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_chats');
    }
};
