<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 255)->primary(); // id varchar(255)
            $table->unsignedBigInteger('user_id')->nullable(); // user_id bigint(20) unsigned
            $table->string('ip_address', 45); // ip_address varchar(45)
            $table->text('user_agent'); // user_agent text
            $table->text('payload'); // payload text
            $table->unsignedInteger('last_activity'); // last_activity int(10) unsigned

            $table->index('user_id'); // Create index on user_id
            $table->index('last_activity'); // Create index on last_activity
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
