<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use models
use App\Models\State;
use App\Models\City;
use Exception;

class CityController extends Controller
{
    #bind model
    protected $state;
    protected $city;

    function __construct(
        State $state,
        City  $city
    ) {
        $this->state    = $state;
        $this->city     = $city;
    }

    public function index(Request $request)
    {
        try {
            $searchColumns = ['id', 'name'];
            $search = request()->search;
            $relation = ['getState'];
            $cities = $this->city->with($relation);
            $order = request()->orderedColumn;
            $orderBy = request()->orderBy;
            if ($search != '') {
                $cities->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
                $cities->orWhereHas('getState', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            }
            // sorting
            ($order == '') ? $cities->orderByDesc('id') : $cities->orderBy($order, $orderBy);
            $cities = $cities->orderBy('id', 'desc')->paginate(10);
            $success['lists'] = $cities;
            $success['state_lists'] = $this->state->where('status', 1)->get();
            return view('admin.master.city.list', $success);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $success['lists']   = $this->state->where('status',true)->get();
        return view('admin.master.city.create', $success);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'state_id'      => 'required',
            'city'          => 'required | unique:cities,name'
        ]);
        try {
            $requestedData = [
                'state_id'    => $request->state_id,
                'name'  => $request->city,
                'status'    => 1
            ];
            $city = $this->city->create($requestedData);
            if ($city) {
                return redirect('admin/master/city')->with('message', 'City created');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // return $id;
        $relation = ['getState'];
        $details['state_lists'] = $this->state->where('status', 1)->get();
        $details['list'] = $this->city->whereId($id)->with($relation)->first();
        return view('admin.master.city.edit', $details);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $data = $this->city->find($id);
        $validate = $request->validate([
            'state_id'      => 'required',
            'city'          => 'required'
        ]);
        try {
            $requested_Data = [
                'state_id'   => $request->state_id,
                'name'  => $request->city,
                'status' => $data ? $data->status : ''
            ];
            $stateUpdate = $this->city->whereId($id)->update($requested_Data);
            if ($stateUpdate) {
                return redirect('admin/master/city/')->with('message', 'City updated');
            } else {
                return redirect()->back()->with('error', 'validation error');
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
        $this->city->whereId($id)->delete();
        return redirect('admin/master/city')->with('message', 'City deleted');
    }

    public function getCity(Request $request)
    {
        $city_lists = $this->city->where('state_id', $request->state_id)->where('status',1)->get();
        return response()->json($city_lists);
    }

    public function changeStatus($id)
    {
        try {
            $state = $this->city->where('id', $id)->first();
            if ($state['status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $statusData = [
                'status' => $status
            ];
            $updated = $this->city->whereId($id)->update($statusData);
            if ($updated) {
                return redirect('admin/master/city')->with('message', 'Status changed successfully');
            } else {
                return redirect()->back()->with('error', 'internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function searchCityBYState(Request $request)
    {
        // return "hello";
        try {
            $relation = ['getState'];
            $citys = $this->city->with($relation);
            if (!empty($request->state_id)) {
                $citys->where('state_id', $request->state_id);
            }
            $flag['lists'] = $citys->get();
            return view('admin.master.city.stateWiseSearch', $flag);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function updatePriority(Request $request){
        City::find($request->id)->update(['priority'=> $request->value]);
        return response('success',200);
    }
}
