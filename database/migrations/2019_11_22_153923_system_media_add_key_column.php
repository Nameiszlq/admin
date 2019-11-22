<?php

use App\Models\SystemMedia;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SystemMediaAddKeyColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_media', function (Blueprint $table) {
            $table->string('key', SystemMedia::MAX_FILENAME_LENGTH)->index()->after('filename');
            $table->dropIndex('system_media_filename_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_media', function (Blueprint $table) {
            $table->dropColumn('key');
            $table->index('filename');
        });
    }
}
