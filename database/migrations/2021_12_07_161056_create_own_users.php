<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('surname');
            $table->integer("redmine_id")->unique();
            $table->index(['redmine_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('own_users');
    }
}
