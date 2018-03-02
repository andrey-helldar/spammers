<?php

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySpammerAccessesChangeUrlColumnTypeTable extends Migration
{
    use DbConnections;

    /**
     * ModifySpammerAccessesChangeUrlColumnType constructor.
     */
    public function __construct()
    {
        $this->setConnectionName();
        $this->setTableAccessName();
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->table($this->table_access, function (Blueprint $table) {
                $table->dropColumn('url');
            });

        Schema::connection($this->connection)
            ->table($this->table_access, function (Blueprint $table) {
                $table->text('url')->after('ip');
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
            ->table($this->table_access, function (Blueprint $table) {
                $table->dropColumn('url');
            });

        Schema::connection($this->connection)
            ->table($this->table_access, function (Blueprint $table) {
                $table->string('url')->after('ip');
            });
    }
}
