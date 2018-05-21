<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserWidgetsTableToUseWidgetId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_widgets', function (Blueprint $table) {
            $table->renameColumn('widget_name', 'widget_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_widgets', function (Blueprint $table) {
            $table->renameColumn('widget_id', 'widget_name');
        });
    }
}
