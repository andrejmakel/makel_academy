<?php
namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMessagesTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('appchat_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->unsignedBigInteger('sender_id'); // User who sent the message
            $table->text('text')->nullable();
            $table->string('file')->nullable(); // File uploads (optional)
            $table->unsignedBigInteger('parent_message_id')->nullable(); // For replies to other messages
            $table->timestamps();

            // Foreign keys
            $table->foreign('chat_id')->references('id')->on('appchat_chat_chats')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('appuser_user_users')->onDelete('cascade');
            $table->foreign('parent_message_id')->references('id')->on('appchat_chat_messages')->onDelete('cascade');
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('appchat_chat_messages');
    }
};
