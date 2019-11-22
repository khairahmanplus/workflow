<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('workflow_id');
            $table->unsignedBigInteger('from_document_status_id');
            $table->unsignedBigInteger('to_document_status_id');
            $table->unsignedBigInteger('step_action_by');
            $table->timestamps();

            $table->foreign('workflow_id')->references('id')->on('workflows');
            $table->foreign('from_document_status_id')->references('id')->on('document_statuses');
            $table->foreign('to_document_status_id')->references('id')->on('document_statuses');
            $table->foreign('step_action_by')->references('id')->on('roles');

            $table->unique(['workflow_id', 'from_document_status_id', 'to_document_status_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_steps');
    }
}
