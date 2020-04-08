<?php

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpammersAddIndexesTable extends Migration
{
    use DbConnections;

    /**
     * ModifySpammersTableAddIndexes constructor.
     */
    public function __construct()
    {
        $this->setConnectionName();
        $this->setTableName();
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->table($this->table, function (Blueprint $table) {
                $table->index('ip', 'ip_index');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->table($this->table, function (Blueprint $table) {
                $table->dropIndex('ip_index');
            });
    }
}
