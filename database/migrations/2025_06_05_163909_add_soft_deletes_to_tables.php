<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToTables extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('batches', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('saleitems', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('medicines', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('batches', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('saleitems', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
