<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use models
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Location;
#use other classes
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Helper;
use Illuminate\Validation\Rule;

class LocationController extends Controller
{
    #bind models
    protected $user;
    protected $state;
    protected $city;
    protected $location;

    function __construct(
        User  $user,
        State $state,
        City  $city,
        Location $location
    ) {
        $this->user     = $user;
        $this->state    = $state;
        $this->city     = $city;
        $this->location = $location;
        
        // $this->middleware('permission:itemlist', ['only' => ['index']]);
        // $this->middleware('permission:additem', ['only' => ['create','store']]);
        // $this->middleware('permission:updateitem', ['only' => ['edit','update']]);
        // $this->middleware('permission:deleteitem', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        try {
            $searchColumns = ['id', 'name', 'admin_name', 'admin_phone', 'admin_email'];
            $search = $request->search;
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            $relation = ['getState', 'getCity', 'getUser'];
            $locations = $this->location->with($relation);
            if ($search != '') {
                $locations->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            // sorting
            ($order == '') ? $locations->orderByDesc('id') : $locations->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $locations = $locations->where('user_id', auth()->user()->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $locations = $locations->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] = $locations;
            $success['state_lists'] = $this->state->where('status', 1)->get();
            return view('admin.master.location.list', $success);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $state_lists = $this->state->where('status', 1)->get();
            return view('admin.master.location.create', compact('state_lists'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'state_id'           => 'required',
            'city_id'            => 'required',
            'admin_name'         => 'required',
            'admin_email'        => 'required | unique:users,email',
            'admin_phone'        => 'required | unique:users,phone',
            'locationName'       => 'required | unique:locations,name',
            'file_image'         => 'required | image | mimes:jpeg,png,jpg,gif,svg',
            'password'           => 'required | min:6',
            'pincode'            => 'required',
            'landmark'           => 'required',
            'address'            => 'required'
        ]);
        try {
            // store in user table
            $params = [
                'name'      => $request->admin_name,
                'email'     => $request->admin_email,
                'phone'     => $request->admin_phone,
                'password'  => Hash::make($request->password)
            ];
            $users = $this->user->create($params)->assignRole('admin');

            $input_Data = [
                'user_id'       => $users->id,
                'state_id'      => $request->state_id,
                'city_id'       => $request->city_id,
                'name'          => $request->locationName,
                'admin_name'    => $request->admin_name,
                'admin_phone'   => $request->admin_phone,
                'admin_email'   => $request->admin_email,
                'pincode'       => $request->pincode,
                'landmark'      => $request->landmark,
                'address'       => $request->address,
                'icon_img'      =>  Helper::uploadsFile($request->file_image, 'Upload-Image'),
                'status'        => 1
            ];
            $location = $this->location->create($input_Data);
            if ($location) {
                return redirect('admin/master/location')->with('message', 'Location created');
            } else {
                return redirect()->back()->withInput();
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $location = $this->location->whereId($id)->first();
            $state_lists = $this->state->where('status', 1)->get();
            $city_lists  = $this->city->where('status', 1)->where('state_id', $location->state_id)->get();
            return view('admin.master.location.edit', compact('location', 'state_lists', 'city_lists'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = $this->location->find($id);
        $validate = $request->validate([
            'state_id'           => 'required',
            'city_id'            => 'required',
            'locationName'       => 'required',
            'admin_name'         => 'required',
            'admin_phone'        => ['required',$this->uniqueExcept('users', 'phone', $request->user_id)],
            'admin_email'        => [
                'required',
                $this->uniqueExcept('users', 'email', $request->user_id),
            ],
            'pincode'            => 'required | integer',
            'landmark'           => 'required',
            'address'            => 'required'
            // 'file_image'         => 'required | image | mimes:jpeg,png,jpg,gif,svg'
        ]);
        try {
            $usersData = $this->user->find($request->user_id);
            if (!empty($usersData)) {
                if (!empty($request->password)) {
                    $userParams = [
                        'name'  => $request->admin_name,
                        'email' => $request->admin_email,
                        // 'phone' => $request->admin_phone,
                        'password' => Hash::make($request->password),
                    ];
                } else {
                    $userParams = [
                        'name'  => $request->admin_name,
                        'email' => $request->admin_email,
                        // 'phone' => $request->admin_phone
                    ];
                }
                $updatedUser = $usersData->update($userParams);
            } else {
                $usersData = User::create([
                    'name'  => $request->admin_name,
                    'email' => $request->admin_email,
                    // 'phone' => $request->admin_phone,
                    'password' => Hash::make($request->password)
                ]);
                $usersData->assignRole('admin');
            }
            $locationData = $this->location->where('id', $id)->first();
            if (!$request->file_image) {
                $requested_Data = [
                    'user_id' => $usersData->id,
                    'state_id'      => $request->state_id,
                    'city_id'       => $request->city_id,
                    'name'          => $request->locationName,
                    'admin_name'    => $request->admin_name,
                    'admin_phone'   => $request->admin_phone,
                    'admin_email'   => $request->admin_email,
                    'pincode'       => $request->pincode,
                    'landmark'      => $request->landmark,
                    'address'       => $request->address,
                    'status'        => $data ? $data->status : '1'
                ];
            } else {
                $imagePath = public_path('/storage/' . $data->icon_img);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $requested_Data = [
                    'user_id' => $usersData->id,
                    'state_id'  => $request->state_id,
                    'city_id'   => $request->city_id,
                    'name'      => $request->locationName,
                    'admin_name'    => $request->admin_name,
                    'admin_phone'   => $request->admin_phone,
                    'admin_email'   => $request->admin_email,
                    'pincode'       => $request->pincode,
                    'landmark'      => $request->landmark,
                    'address'       => $request->address,
                    'icon_img'  => Helper::uploadsFile($request->file_image, 'Upload-Image'),
                    'status'    => $data ? $data->status : '1'
                ];
            }

            $updated = $this->location->where('id', $id)->update($requested_Data);
            if ($updated) {
                return redirect('admin/master/location')->with('message', 'Location updated successfully ');
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
        $deleted = $this->location->whereId($id)->delete();
        if ($deleted) {
            return redirect('admin/master/location')->with('message', 'Location deleted successfully');
        } else {
            return redirect()->back()->with('failed', 'Sorry !! Something went wrong');
        }
    }

    public function getLocation(Request $request)
    {
        $location_list = $this->location->where('status', 1)->where('city_id', $request->city_id)->get();
        return response()->json($location_list);
    }

    public function changeStatus($id)
    {
        try {
            $location = $this->location->where('id', $id)->first();
            if ($location['status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $statusData = [
                'status' => $status
            ];
            $updated = $this->location->whereId($id)->update($statusData);
            if ($updated) {
                return redirect('admin/master/location')->with('message', 'Status changed successfully');
            } else {
                return redirect()->back()->with('error', 'internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function searchLocationByState(Request $request)
    {
        // return "hello from controller";
        try {
            $relation = ['getCity', 'getState'];
            $locations = $this->location->with($relation);
            if (!empty($request->state_id)) {
                $locations->where('state_id', $request->state_id);
            }
            $flag['lists'] =  $locations->get();
            return view('admin.master.location.searchLocationByState', $flag);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function cityGetByState(Request $request)
    {
        // return "hello";
        try {
            $flag['city_lists'] = $this->city->where('state_id', $request->state_id)->get();
            return view('admin.master.location.cityGetBySate', $flag);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function searchLocationByCity(Request $request)
    {
        // return "hello";
        try {
            $relation = ['getState', 'getCity'];
            $locations = $this->location->with($relation);
            if (!empty($request->city_id)) {
                $locations->where('city_id', $request->city_id);
            }
            $flag['lists'] = $locations->get();
            return view('admin.master.location.searchLocationByCity', $flag);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function getLoactionByCity(Request $request)
    {
        try {
            $relation = ['getState', 'getCity'];
            $locations = $this->location->with($relation);
            if (!empty($request->city_id)) {
                $locations->where('city_id', $request->city_id);
            }
            $locations = $locations->get();
            $option = '';
            foreach ($locations as $key => $location) {
                $option .= '<option value="' . $location->id . '">' . $location->name . '</option>';
            }
            return $option;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function updatePriority(Request $request)
    {
        Location::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    protected function uniqueExcept($table, $column, $id)
    {
        return Rule::unique($table, $column)->ignore($id);
    }
}
