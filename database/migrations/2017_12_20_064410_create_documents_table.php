<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('title');
            $table->string('slug');
            $table->text('image');
            $table->text('description');
            $table->longText('content');
            $table->text('source');
            $table->string('file_type');
            $table->unsignedTinyInteger('document_status');
            $table->unsignedTinyInteger('comment_status');
            $table->unsignedInteger('coin');
            $table->unsignedInteger('page_count');
            $table->unsignedInteger('view_count')->default(config('setting.documents_default.view_count'));
            $table->unsignedInteger('download_count')->default(config('setting.documents_default.download_count'));
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
        Schema::dropIfExists('documents');
    }
}
