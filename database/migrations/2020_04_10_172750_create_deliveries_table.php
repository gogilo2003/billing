<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Invoice;
use App\Models\Delivery;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('invoice_id');
            $table->foreign('invoice_id')->references("id")->on("invoices");
            $table->date("delivery_date")->default(now());
            $table->timestamps();
        });

        $invoices = Invoice::all();
        foreach ($invoices as $key => $invoice) {
            $delivery = new Delivery();
            $delivery->delivery_date = $invoice->created_at;
            $delivery->invoice_id = $invoice->id;
            $delivery->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
