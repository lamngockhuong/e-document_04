<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'username');
            $table->unique('username');
            $table->string('firstname')->after('remember_token');
            $table->string('lastname')->after('firstname');
            $table->string('avatar')->after('lastname');
            $table->unsignedInteger('free_download')->default(config('setting.users_default.free_download'))->after('avatar');
            $table->unsignedInteger('uploaded_count')->default(config('setting.users_default.uploaded_count'))->after('free_download');
            $table->unsignedInteger('wallet')->default(config('setting.users_default.wallet'))->after('uploaded_count');
            $table->tinyInteger('status')->default(config('setting.users_default.status'))->after('wallet');
            $table->text('role')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('username', 'name');
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            $table->dropColumn('avatar');
            $table->dropColumn('free_download');
            $table->dropColumn('uploaded_count');
            $table->dropColumn('wallet');
            $table->dropColumn('status');
            $table->dropColumn('role');
        });
    }
}
