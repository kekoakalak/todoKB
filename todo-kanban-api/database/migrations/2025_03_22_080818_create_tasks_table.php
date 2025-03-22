<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{

    public function up()
    {
        //Create Scheme for table columns
        Schema::create('tasks', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links task to user
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('todo'); // 'todo', 'in_progress', 'done'
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
