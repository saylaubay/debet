<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('debets', function (Blueprint $table) {
            $table->id();
            $table->string("month_name")->nullable();
            $table->double("summa")->nullable();
            $table->foreignId("contract_id")->constrained();
            $table->boolean("paid")->default(false);
            $table->timestamp('pay_date')->nullable();
//            $table->timestamp('pay_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean("active")->default(false);
            $table->boolean("desc")->nullable();
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
        Schema::dropIfExists('debets');
    }
};
