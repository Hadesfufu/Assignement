<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('old')->default(false);
            $table->boolean('isStudent')->default(false);
            $table->boolean('administrator')->default(false);
            $table->integer('supervisor_id');
            $table->string('photo')->default("img/default.png");
            $table->rememberToken();
            $table->timestamps();
        });

        $admin = new \App\User();
        $admin->name = "admin";
        $admin->email = "yohan.masson@neuf.fr";
        $admin->administrator = true;
        $admin->password = bcrypt("admin");
        $admin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
