<?php

use Carbon\Carbon;
use App\Models\Billing\Priced;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDateUserPricedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('user_priceds')->truncate();
        DB::table('priceds')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('priceds')->insert([
            [
                'name' => 'Free',
                'default' => 1,
                'repeat' => 0,
                'period' => 1,
                'period_type' => 'month',
                'price' => 'Free',
                'note' => '30 day free trial. Monthly subscription for the product. $39 / Month',
                'type' => 'free',
            ],
            [
                'name' => 'Monthly subscription',
                'default' => 0,
                'repeat' => 1,
                'period' => 1,
                'period_type' => 'month',
                'price' => '$39 / Month',
                'note' => null,
                'type' => 'subscription',
            ],
        ]);

        $defaultPriced = DB::table('priceds')->whereDefault(1)->first();

        $users = DB::table('users')->get();

        foreach($users as $user)
        {
            if ($user->id == 1) continue;
            DB::table('user_priceds')->insert([
                [
                    'user_id' => $user->id,
                    'priced_id' => $defaultPriced->id,
                    'end_date' => $this->calcEndDate($defaultPriced),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('user_priceds')->truncate();
        DB::table('priceds')->truncate();
        Schema::enableForeignKeyConstraints();
    }

    private function calcEndDate($priced, $numberRepeat = 1) {
        switch ($priced->period_type) {
            case Priced::PERIOD_TYPE_DAY:
                return Carbon::now()->addDays($priced->period * $numberRepeat);
            case Priced::PERIOD_TYPE_WEEK:
                return Carbon::now()->addWeeks($priced->period * $numberRepeat);
            case Priced::PERIOD_TYPE_MONTH:
                return Carbon::now()->addMonths($priced->period * $numberRepeat);
            case Priced::PERIOD_TYPE_YEAR:
                return Carbon::now()->addYears($priced->period * $numberRepeat);
            default:
                return Carbon::now();
        }
    }
}
