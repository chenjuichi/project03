<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsertypeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('userType')->default('User')->after('password');
            $table->boolean('isActivated')->default(0)->after('userType');
            $table->string('passwordResetCode')->nullable()->after('isActivated');
            $table->string('activationCode')->nullable()->after('passwordResetCode');
            $table->string('socialType')->nullable()->after('activationCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['userType', 'isActivated', 'activationCode', 'socialType']);
        });
    }
}
