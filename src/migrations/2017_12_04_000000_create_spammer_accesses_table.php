<?php

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpammerAccessesTable extends Migration
{
    use DbConnections;

    /**
     * CreateSpammersTable constructor.
     */
    public function __construct()
    {
        $this->setConnectionName();
        $this->setTableAccessName();
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->create($this->table_access, function (Blueprint $table) {
                $table->increments('id');

                $table->ipAddress('ip');
                $table->string('url');

                $table->timestamps();
                $table->softDeletes();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->dropIfExists($this->table_access);
    }
}
