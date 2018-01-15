<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetDefaultValueDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('title')->default(config('setting.none'))->change();
            $table->string('slug')->default(config('setting.none'))->change();
            $table->string('image')->default(config('setting.none'))->change();
            $table->string('description')->default(config('setting.none'))->change();
            $table->longText('content')->nullable(true)->change();
            DB::statement('ALTER TABLE documents MODIFY document_status SMALLINT UNSIGNED NOT NULL DEFAULT ' . config('setting.documents_default.document_status'));
            DB::statement('ALTER TABLE documents MODIFY comment_status SMALLINT UNSIGNED NOT NULL DEFAULT ' . config('setting.documents_default.comment_status'));
            $table->unsignedInteger('coin')->default(config('setting.documents_default.coin'))->change();
            $table->unsignedInteger('page_count')->default(config('setting.documents_default.page_count'))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->text('title')->default(null)->change();
            $table->string('slug')->default(null)->change();
            $table->text('image')->default(null)->change();
            $table->text('description')->default(null)->change();
            $table->longText('content')->default(null)->change();
            DB::statement('ALTER TABLE documents MODIFY document_status TINYINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE documents MODIFY comment_status TINYINT UNSIGNED NOT NULL');
            $table->unsignedInteger('coin')->default(null)->change();
            $table->unsignedInteger('page_count')->default(null)->change();
        });
    }
}
