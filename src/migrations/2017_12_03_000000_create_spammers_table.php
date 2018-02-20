<?php

use Helldar\Spammers\Traits\DbConnections;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpammersTable extends Migration
{
    use DbConnections;

    /**
     * CreateSpammersTable constructor.
     */
    public function __construct()
    {
        $this->setConnectionName();
        $this->setTableName();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->connection)
            ->dropIfExists($this->table);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->connection)
            ->create($this->table, function (Blueprint $table) {
                $table->increments('id');

                $table->ipAddress('ip');
                $table->timestamp('expired_at')->nullable();

                $table->timestamps();
                $table->softDeletes();
            });
    }
}
