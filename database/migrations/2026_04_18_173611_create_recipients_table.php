<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipients', function (Blueprint $row) {
            $row->id();
            $row->string('name');
            $row->string('address')->nullable();
            $row->string('contact_person')->nullable();
            $row->string('phone')->nullable();
            $row->text('description')->nullable();
            $row->enum('need_level', ['low', 'medium', 'high'])->default('medium');
            $row->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipients');
    }
};
