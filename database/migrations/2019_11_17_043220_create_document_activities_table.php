<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('document_status_id');
            $table->unsignedBigInteger('action_by');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('document_status_id')->references('id')->on('document_statuses');
            $table->foreign('action_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_activities');
    }
}
