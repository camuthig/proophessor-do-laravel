<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventStoreTables extends Migration
{
    private const EVENT_STREAMS_TABLE = 'event_streams';
    private const PROJECTIONS_TABLE   = 'projections';
    private const SNAPSHOTS_TABLE     = 'snapshots';

    public function up()
    {
        Schema::create(self::EVENT_STREAMS_TABLE, function (Blueprint $table) {
            $table->bigInteger('no', true);
            $table->string('real_stream_name', 150);
            $table->string('stream_name', 41);
            $table->json('metadata');
            $table->string('category', 150);

            $table->unique('real_stream_name', 'ix_rsn');
            $table->index('category', 'ix_cat');
        });

        Schema::create(self::PROJECTIONS_TABLE, function (Blueprint $table) {
            $table->bigInteger('no', true);
            $table->string('name', 150);
            $table->json('position')->nullable();
            $table->json('state')->nullable();
            $table->string('status', 28);
            $table->string('locked_until', 26)->nullable();

            $table->unique('name', 'ix_name');
        });

        Schema::create(self::SNAPSHOTS_TABLE, function (Blueprint $table) {
            $table->string('aggregate_id', 150);
            $table->string('aggregate_type', 150);
            $table->integer('last_version');
            $table->string('created_at', 26);
            $table->binary('aggregate_root')->nullable();

            $table->unique('aggregate_id', 'ix_aggregate_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists(self::EVENT_STREAMS_TABLE);
        Schema::dropIfExists(self::PROJECTIONS_TABLE);
        Schema::dropIfExists(self::SNAPSHOTS_TABLE);
    }
}
