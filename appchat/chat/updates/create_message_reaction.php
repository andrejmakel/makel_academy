<?php
namespace AppChat\Chat\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateMessageReactionUser Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('message_reaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id'); // ID of the message
            $table->unsignedBigInteger('reaction_id'); // ID of the reaction (emoji)
            $table->timestamps();

            // Foreign keys
            $table->foreign('message_id')->references('id')->on('appchat_chat_messages')->onDelete('cascade');
            $table->foreign('reaction_id')->references('id')->on('appchat_chat_reactions')->onDelete('cascade');

        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('message_reaction');
    }
};
