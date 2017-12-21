<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermTaxonomyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('term_taxonomy', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('term_id')->default(config('setting.term_taxonomy_default.term_id'))->index();
            $table->string('taxonomy', 50)->default(config('setting.term_taxonomy_default.taxonomy'))->index();
            $table->longText('description');
            $table->unsignedInteger('parent')->default(config('setting.term_taxonomy_default.parent'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_taxonomy');
    }
}
