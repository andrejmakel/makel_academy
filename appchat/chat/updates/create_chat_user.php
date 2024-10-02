<?php
namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateReactionsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('chat_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id'); // ID of the message
            $table->unsignedBigInteger('user_id'); // ID of the reaction (emoji)
            $table->timestamps();

            // Foreign keys
            $table->foreign('chat_id')->references('id')->on('appchat_chat_chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('appuser_user_users')->onDelete('cascade');

        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('chat_user');
    }
};
