<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('domain')->unique();
            $table->date('registered_on');
            $table->date('expires_on');
            $table->string('remarks')->nullable();
            $table->string('status')->default('active');
            $table->unsignedInteger('client_id');
            $table->timestamps();
            $$table->foreign('client_id')
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domains');
    }
}
