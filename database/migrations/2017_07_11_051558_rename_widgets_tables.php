<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameWidgetsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("widgets", "user_widgets");
        Schema::rename("widget_settings", "user_widget_settings");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename("user_widgets", "widgets");
        Schema::rename("user_widget_settings", "widget_settings");
    }
}
