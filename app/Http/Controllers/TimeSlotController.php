<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ScreenConstrain;
use App\Models\ScreenDay;
use Carbon\Carbon;

class TimeSlotController extends Controller
{
    public function getSlots()
    {
        $city_id = request()->city_id;
        $location_id = request()->location_id;

        $screen_id = request()->screen_id;
        $date = request()->date;

        $dateObject = Carbon::parse($date);

        $day = $dateObject->format('l');


        $slots = [];


        //check if constraint slots exists 
        $query = ScreenConstrain::where('date', $date);
        if ($screen_id) {
            $query->where('screen_id', $screen_id);
        }

        $checkConstrainExist = $query->first();

        //get days slots 
        $query_1 = ScreenDay::where('day', $day);
        if ($screen_id) {
            $query_1->where('screen_id', $screen_id);
        }
        $checkSlotExist = $query_1->first();

        if ($checkConstrainExist) {
            $slots =  $checkConstrainExist->slots;
        } else if ($checkSlotExist) {
            $slots =  $checkSlotExist->slots;
        }

        $newSlots = collect($slots)->map(function ($item) use ($date,$screen_id) {
            return [
                'id' => $item->id,
                'slot' => $item->start_time . ' - ' . $item->end_time,
                'isActive' => $this->getSlotActive($date,$screen_id, $item->start_time, $item->start_time . ' - ' . $item->end_time),
                'amount' => $item->amount,
                'additional_amount' => $item->additional_amount,
                'isSelected' => false
            ];
        });

        return response()->json($newSlots);
    }


    public function getSlotActive($date,$screen_id, $time_slot, $slot)
    {
        $now = Carbon::now()->format('Y-m-d');
        $selectedDate = Carbon::parse($date)->format('Y-m-d');

        $checkIfAlreadyBooked = Booking::whereHas('slots', function ($q) use ($slot) {
            $q->where('slot_name', $slot);
        })
            ->where('book_date', $date)
            ->where('screen_id', $screen_id)
            ->where('status', 'success')
            ->first();

        if ($checkIfAlreadyBooked) {
            return false;
        }


        if (strtotime($selectedDate) >= strtotime($now)) {
            if (strtotime($selectedDate) == strtotime($now)) {
                $current_time = Carbon::now()->format('g:i A');
                $slot_time = Carbon::parse($time_slot)->format('g:i A');
                if (strtotime($slot_time) > strtotime($current_time)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
        return false;
    }
    public function getSlotsCount($param)
    {

        $screen_id = $param['screen_id'];
        $date = $param['date'];

        $dateObject = Carbon::parse($date);

        $day = $dateObject->format('D');


        $slots = [];


        //check if constraint slots exists 
        $query = ScreenConstrain::where('date', $date);
        if ($screen_id) {
            $query->where('screen_id', $screen_id);
        }

        $checkConstrainExist = $query->first();

        //get days slots 
        $query_1 = ScreenDay::where('day', $day);
        if ($screen_id) {
            $query_1->where('screen_id', $screen_id);
        }
        $checkSlotExist = $query_1->first();

        if ($checkConstrainExist) {
            $slots =  $checkConstrainExist->slots;
        } else if ($checkSlotExist) {
            $slots =  $checkSlotExist->slots;
        }
        $count=0;
        foreach ($slots as $slot) {
            if($this->getSlotActive($date,$screen_id, $slot->start_time, $slot->start_time . ' - ' . $slot->end_time)){
                ++$count;
            }
        }
        return $count;
    }
}
