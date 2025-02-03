<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('submission')->nullable(); // Jawaban atau file yang dikumpulkan
            $table->integer('score')->nullable(); // Nilai yang diberikan oleh guru
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    Schema::disableForeignKeyConstraints();
    DB::table('task_user')->truncate(); // Hapus semua data
    Schema::dropIfExists('task_user');
    Schema::enableForeignKeyConstraints();
    }
}
