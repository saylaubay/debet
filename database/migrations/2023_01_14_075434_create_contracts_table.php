<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained();
            $table->string("product_name")->nullable();
            $table->foreignId("user_id")->constrained();
            $table->double("price")->nullable();
            $table->foreignId("client_id")->constrained();
            $table->double("percent")->nullable();
//            $table->boolean("enabled")->default(false);
            $table->integer("part")->nullable();
            $table->boolean("active")->default(false);
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
        Schema::dropIfExists('contracts');
    }
};
