<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::create('class_student', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained()->onDelete('cascade');
        $table->foreignId('class_id')->constrained('class_models')->onDelete('cascade');
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('class_student');
    }

};
