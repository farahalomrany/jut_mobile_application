<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributorObserversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distributor_observers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disrtibutor_id');
            $table->foreign('disrtibutor_id')->references('id')->on('distributors')->onDelete('cascade');
            $table->unsignedBigInteger('observer_id');
            $table->foreign('observer_id')->references('id')->on('observers')->onDelete('cascade');
        
            $table->softDeletes();
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
        Schema::dropIfExists('distributor_observers');
    }
}
