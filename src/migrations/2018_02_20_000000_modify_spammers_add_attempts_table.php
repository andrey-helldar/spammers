<?php

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpammersAddAttemptsTable extends Migration
{
    use DbConnections;

    /**
     * ModifySpammersTableAddIncrement constructor.
     */
    public function __construct()
    {
        $this->setConnectionName();
        $this->setTableName();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->table($this->table, function (Blueprint $table) {
                $table
                    ->integer('attempts')
                    ->default(0)
                    ->after('ip');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->table($this->table, function (Blueprint $table) {
                $table->dropColumn('attempts');
            });
    }
}
