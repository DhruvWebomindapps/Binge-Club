<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Timeslot;
use Illuminate\Http\Request;

#use models
use App\Models\User;
use App\Models\City;
use App\Models\State;
use App\Models\Screen;
use App\Models\Location;
use App\Models\ScreenFeature;
use App\Models\ScreenImage;

#use other classes
use Illuminate\Support\Facades\Hash;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Carbon;
use App\Helpers\Helper;
use App\Models\ScreenConstrain;
use App\Models\ScreenDay;
use App\Models\Slot;
use Validator;
use Exception;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
{
    #bind model
    protected $user;
    protected $city;
    protected $state;
    protected $screen;
    protected $location;
    protected $timeSlot;
    protected $screenFeature;
    protected $screenImage;

    function __construct(
        User        $user,
        City        $city,
        State       $state,
        Screen      $screen,
        Location    $location,
        Timeslot    $timeSlot,
        ScreenFeature    $screenFeature,
        ScreenImage $screenImage
    ) {
        $this->user         = $user;
        $this->city         = $city;
        $this->state        = $state;
        $this->screen       = $screen;
        $this->location     = $location;
        $this->timeSlot     = $timeSlot;
        $this->screenFeature     = $screenFeature;
        $this->screenImage  = $screenImage;
    }

    public function index(Request $request)
    {
        $searchColumns = ['id', 'screen_name'];
        $search = request()->search;
        $place = request()->place;
        $relation = ['getLocation'];
        $screens = $this->screen->with($relation);
        $locations = $this->location->where('status', 1)->get();
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        if ($search != '') {
            $screens->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });
            $screens->orWhereHas('getLocation', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }
        if ($place != '') {
            $screens->where('location_id', $place);
        }
        // sorting
        ($order == '') ? $screens->orderByDesc('id') : $screens->orderBy($order, $orderBy);
        if (auth()->user()->hasRole('admin')) {
            $location = Location::where('user_id', auth()->user()->id)->first();
            $screens = $screens->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
        } else {
            $screens = $screens->orderBy('id', 'desc')->paginate(10);
        }
        $success['screen_lists']    = $screens;
        $success['locations']   = $this->location->where('status', 1)->get();
        return view('admin.master.screen.list', $success);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $success['state_lists'] = $this->state->where('status', 1)->get();
        return view('admin.master.screen.create', $success);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'state_id'          => 'required',
            'city_id'           => 'required',
            'location_id'       => 'required',
            'screen_name'       => 'required',
            'capacity'          => 'required',
            'max_people'          => 'required',
            'address'           => 'required',
        ]);
        DB::beginTransaction();
        try {
            $inputData = [
                'user_id'       => auth()->user()->id,
                'state_id'      => $request->state_id,
                'city_id'       => $request->city_id,
                'location_id'   => $request->location_id,
                'screen_name'   => $request->screen_name,
                'capacity'      => $request->capacity,
                'max_people'      => $request->max_people,
                'address'       => $request->address,
                'description'   => $request->description,
                'calendar_id'   => $request->calendar_id,
                'status'        => 1
            ];

            $screen = $this->screen->create($inputData);

            // inserting Screen Image
            $this->uploadImage($screen, $request);

            // inserting time slot
            $this->uploadTimeSlots($screen, $request);

            //insert constrained slots
            $this->uploadConstrainedSlots($screen, $request);


            //insert features
            $this->uploadFeatures($screen, $request);

            DB::commit();
            if ($screen) {
                return redirect('admin/master/screen')->with('message', 'Screen created successfully');
            } else {
                return redirect()->back()->withInput();
            }
        } catch (Exception $ex) {
            DB::rollBack();
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function uploadImage($screen, $request)
    {
        foreach ($request->file_image as $s_image) {
            $screenImg = [
                'screen_id'       => $screen->id,
                'screen_icon'     => Helper::uploadsFile($s_image, 'Upload-Image')
            ];
            $screenImg = $this->screenImage->create($screenImg);
        }
    }


    public function uploadTimeSlots($screen, $request)
    {
        $ids = $request->id;
        $start_times = $request->start_time;
        $end_times = $request->end_time;
        $amount = $request->amount;
        $additional_amount = $request->addition_amount;

        //delete slots if exist 
        $deletedIds = json_decode($request->deleted_slots);
        if ($deletedIds && count($deletedIds) > 0) {
            foreach ($deletedIds as $id) {
                $slot = Slot::find($id);
                if ($slot) {
                    $slot->delete();
                }
            }
        }


        if ($start_times && count($start_times) > 0) {
            foreach ($start_times as $key => $values) {

                $checkDayExist = ScreenDay::where('screen_id', $screen->id)
                    ->where('day', $key)
                    ->first();

                if (is_null($checkDayExist)) {
                    $day = $screen->days()->create(['day' => $key]);
                } else {
                    $day = $checkDayExist;
                }

                foreach ($values as $index => $value) {
                    if (is_null($ids[$key][$index]) || $ids[$key][$index] == "null") {
                        $day->slots()->create([
                            'start_time' => $value,
                            'end_time' => $end_times[$key][$index],
                            'amount' => $amount[$key][$index],
                            'additional_amount' => $additional_amount[$key][$index]
                        ]);
                    } else {
                        Slot::find($ids[$key][$index])->update([
                            'start_time' => $value,
                            'end_time' => $end_times[$key][$index],
                            'amount' => $amount[$key][$index],
                            'additional_amount' => $additional_amount[$key][$index]
                        ]);
                    }
                }
            }
        }
    }

    public function uploadConstrainedSlots($screen, $request)
    {
        $ids = $request->const_id;
        $start_times = $request->const_start_time;
        $end_times = $request->const_end_time;
        $amount = $request->const_amount;
        $additional_amount = $request->const_additional_amount;

        //delete slots if exist 
        $deletedIds = json_decode($request->deleted_constraint);
        if ($deletedIds && count($deletedIds) > 0) {
            foreach ($deletedIds as $id) {
                $slot = ScreenConstrain::where('screen_id', $screen->id)
                    ->where('date', $id)
                    ->first();
                if ($slot) {
                    $slot->delete();
                }
            }
        }


        if ($start_times && count($start_times) > 0) {
            foreach ($start_times as $key => $values) {

                $checkDateExist = ScreenConstrain::where('screen_id', $screen->id)
                    ->where('date', $key)
                    ->first();
                if (is_null($checkDateExist)) {
                    $day = $screen->constraints()->create(['date' => $key]);
                } else {
                    $day = $checkDateExist;
                }

                foreach ($values as $index => $value) {
                    if (is_null($ids[$key][$index]) || $ids[$key][$index] == "null") {
                        $day->slots()->create([
                            'start_time' => $value,
                            'end_time' => $end_times[$key][$index],
                            'amount' => $amount[$key][$index],
                            'additional_amount' => $additional_amount[$key][$index]
                        ]);
                    } else {
                        Slot::find($ids[$key][$index])->update([
                            'start_time' => $value,
                            'end_time' => $end_times[$key][$index],
                            'amount' => $amount[$key][$index],
                            'additional_amount' => $additional_amount[$key][$index]
                        ]);
                    }
                }
            }
        }
    }


    public function uploadFeatures($screen, $request)
    {
        if (!empty($request->title)) {
            foreach ($request->title as $key => $title) {
                $params = [
                    'screen_id' => $screen->id,
                    'title'      => $title,
                    'status'      => $request->status[$key],
                ];
                $this->screenFeature->create($params);
            }
        }
    }


    public function addMoreFeaturesField()
    {
        return view('include.screen.features_option');
    }
    public function addMoreFeature(Request $request)
    {
        ScreenFeature::create($request->all());
        return back()->with('message', 'Feature added successfully');
    }
    public function removefeature($id)
    {
        $deleted = $this->screenFeature->whereId($id)->delete();
        if ($deleted) {
            return redirect()->back()->with('message', 'Screen feature deleted');
        } else {
            return redirect()->back()->with('error', 'Internal server error');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return $id;
        $relation = ['getTimeSlot',  'getScreenImages', 'getFeatures'];
        $screen = $this->screen->with($relation)->where('id', $id)->first();
        $location_lists  = $this->location->where('status', 1)->where('city_id', $screen->city_id)->get();
        $city_lists  = $this->city->where('status', 1)->where('state_id', $screen->state_id)->get();
        $state_lists = $this->state->where('status', 1)->get();

        return view('admin.master.screen.edit', compact('location_lists', 'city_lists', 'state_lists', 'screen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $validate = $request->validate([
            'state_id'      => 'required',
            'city_id'       => 'required',
            'location_id'   => 'required',
            'screen_name'   => 'required',
            'capacity'      => 'required',
            'max_people'      => 'required',
            'address'       => 'required',
        ]);
        DB::beginTransaction();
        try {

            $inputData = [
                'state_id'      => $request->state_id,
                'city_id'       => $request->city_id,
                'location_id'   => $request->location_id,
                'screen_name'   => $request->screen_name,
                'capacity'      => $request->capacity,
                'max_people'      => $request->max_people,
                'address'       => $request->address,
                'description'   => $request->description,
                'calendar_id'   => $request->calendar_id,
                'status'        => 1
            ];
            $screen = $this->screen->find($id);
            $screen->getFeatures()->delete();

            //insert features
            $this->uploadFeatures($screen, $request);
            $updated = $screen->update($inputData);

            // inserting Screen Image
            if ($request->file_image) {
                $this->uploadImage($screen, $request);
            }
            // inserting time slot
            $this->uploadTimeSlots($screen, $request);

            //insert constrained slots
            $this->uploadConstrainedSlots($screen, $request);
            DB::commit();
            if ($updated) {
                return redirect('admin/master/screen')->with('message', 'Screen updated successfully');
            } else {
                return redirect()->back()->with('error', 'something went wrong');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // return $id;
        $relation = ['getTimeSlot',];
        $data = $this->screen->with($relation)->whereId($id)->first();
        $dataDeleted = $data->delete();
        if ($dataDeleted) {
            return redirect('admin/master/screen')->with('message', 'Screen deleted successfully');
        } else {
            return redirect()->back()->with('error', '!!sorry !!Something went wrong');
        }
    }
    public function AddDynamicField()
    {
        // return "hello";
        return view('include.screen.option');
    }

    public function AddMoreTimeSlot(Request $request)
    {

        $parameter = [
            'screen_id' => $request->screen_id,
            's_time'    => $request->s_time,
            'e_time'    => $request->e_time,
            'amount'    => $request->amount
        ];
        // dd($request->all());
        $timeSlot = $this->timeSlot->create($parameter);
        if ($timeSlot) {
            return redirect('admin/master/screen')->with('message', 'Successfully added');
        } else {
            return redirect()->back()->with('error', '!! Something went wrong');
        }
    }

    public function deleteTimeSlot($id)
    {
        $flg = $this->timeSlot->where('id', $id)->first();
        $dtFlg = $flg->delete();
        if ($dtFlg) {
            return redirect()->back()->with('message', 'Selected Time Slot deleted');
        } else {
            return redirect()->back()->with('error', '!! something went wrong');
        }
    }

    public function getScreen(Request $request)
    {
        $screen_list = $this->screen->where('location_id', $request->location_id)->get();
        return response()->json($screen_list);
    }
    public function changeStatus($id)
    {
        try {
            $screen = $this->screen->where('id', $id)->first();
            if ($screen['status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $statusData = [
                'status' => $status
            ];
            $updated = $this->screen->whereId($id)->update($statusData);
            if ($updated) {
                return redirect('admin/master/screen')->with('message', 'Status changed successfully');
            } else {
                return redirect()->back()->with('error', 'internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function deleteMultiScreenImg($id)
    {
        // return $id;
        try {
            $deleted = $this->screenImage->whereId($id)->delete();
            if ($deleted) {
                return redirect()->back()->with('message', 'Image deleted successfully');
            } else {
                return redirect()->back()->with('error', 'internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function countImgAddRole(Request $request)
    {
        $count = $this->screenImage->where('screen_id', $request->screen_id)->count();
        if ($count > 0) {
            return view('include.screen.img_option1');
        } else {
            return view('include.screen.img_option');
        }
    }

    public function locationByScreen(Request $request)
    {
        $relation = ['getLocation'];
        $screens = $this->screen->with($relation)->where('location_id', $request->location_id);
        $success['screen_lists']    = $screens->latest()->get();
        return view('include.screen.screenByLocation', $success);
    }
    public function updatePriority(Request $request)
    {
        Screen::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
}
