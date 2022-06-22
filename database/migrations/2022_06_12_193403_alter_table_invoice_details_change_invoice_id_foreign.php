<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableInvoiceDetailsChangeInvoiceIdForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            // $table->dropIndex(['invoice_id']);
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $table->dropIndex(['invoice_id']);
            // $table->foreign('invoice_id')
            //     ->references('id')
            //     ->on('invoices')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
        });
    }
}
