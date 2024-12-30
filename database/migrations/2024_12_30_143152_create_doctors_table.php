<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('MobileNumber');
            $table->foreignId('specialization_id')->constrained('specializations'); // Assuming you have a `specializations` table
            $table->string('password');
            $table->enum('status', ['1', '0'])->default('1'); // 1 is active, 0 is inactive
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
