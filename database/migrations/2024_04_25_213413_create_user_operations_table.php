<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();            
            $table->integer('operation_id')->unsigned();
            $table->integer('amount')->unsigned()->default(0);
            $table->integer('user_balance')->unsigned()->default(0);
            $table->text('operation_response');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('operation_id')->references('id')->on('operations');
        });


        // User balance (from users table) will be automatically deducted when inseting an operation
        DB::unprepared('
            CREATE TRIGGER after_user_operation_insert
            AFTER INSERT ON user_operations
            FOR EACH ROW
            BEGIN
                UPDATE users u
                SET u.balance = u.balance - NEW.amount 
                WHERE u.id = NEW.user_id;
            END;
        ');          
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_operations');
    }
};
