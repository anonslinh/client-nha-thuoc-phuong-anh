<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalBranchTable extends Migration
{
    public function up()
    {
        Schema::create('local_branch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('branch_id'); // id của branch_shop (không khóa ngoại)
            $table->decimal('lat', 10, 7);           // Vĩ độ
            $table->decimal('lng', 10, 7);           // Kinh độ
            $table->string('google_map_link')->nullable(); // Link google map, có thể null
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('local_branch');
    }
}
