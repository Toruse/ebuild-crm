<?php

namespace App\Repositories\Billing;

use Carbon\Carbon;
use App\Models\User\User;
use App\Models\Billing\Priced;
use App\Models\User\UserPriced;

class PricedRepository
{
    public function getPricedsPaginate($paginate = 25)
    {
        return Priced::paginate($paginate);
    }

    public function createPriced($fields)
    {
        return Priced::create([
            'name' => $fields['name'],
            'type' => $fields['type'],
            'default' => $fields['default'],
            'repeat' => $fields['repeat'],
            'period' => $fields['period'],
            'period_type' => $fields['period_type'],
            'price' => $fields['price'],
            'end_date' => $fields['end_date']?(new Carbon($fields['end_date']))->format('Y-m-d'):null,
            'note' => $fields['note'],
        ]);
    }

    public function updatePriced(Priced $priced, $fields)
    {
        $priced->name = $fields['name'];
        $priced->type = $fields['type'];
        $priced->default = $fields['default'];
        $priced->repeat = $fields['repeat'];
        $priced->period = $fields['period'];
        $priced->period_type = $fields['period_type'];
        $priced->end_date = $fields['end_date']?(new Carbon($fields['end_date']))->format('Y-m-d'):null;
        $priced->note = $fields['note'];
        return $priced->save();
    }

    public function getDefault() {
        return Priced::whereDefault(1)
        ->whereType(Priced::TYPE_FREE)
        ->first();
    }

    public function createSubscribe(User $user, Priced $priced) {
        return UserPriced::create([
            'user_id' => $user->id,
            'priced_id' => $priced->id,
            'end_date' => $this->calcEndDate($priced),
        ]);
    }

    public function calcEndDate(Priced $priced, $numberRepeat = 1) {
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

    public function pluckListPriced($key = 'id', $value = 'name')
    {
        $listPriced = Priced::getListType();
        return Priced::orderBy('name')
            ->pluck($value, $key)
            ->all();
    }

    public function setPricedUser(User $user, $request) {
        if ($request->priced) {
            $userPriced = UserPriced::whereUserId($user->id)
                ->orderBy('updated_at', 'DESC')
                ->first();

            if (!$userPriced) {
                $userPriced = new UserPriced();
                $userPriced->user_id = $user->id;
                $userPriced->end_date = Carbon::now();
            }

            $userPriced->priced_id = $request->priced;

            if ($request->number) {
                $userPriced->end_date = $this->calcEndDate($userPriced->priced, $request->number);
            }    

            $userPriced->save();
        } else {
            UserPriced::whereUserId($user->id)->delete();
        }

    }

    public function isSendUserNotifyEmail(User $user) {
        $userPriced = $user->userPriceds()
            ->orderBy('updated_at', 'DESC')
            ->first();

        if ($userPriced) {
            $is_notify = !$userPriced->is_notify;
            $userPriced->is_notify = true;
            $userPriced->save();
            return $is_notify;
        }

        return false;
    }
}