<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Location;
use App\Models\Other;
use Exception;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    #Bind Model
    protected $other;
    protected $city;
    protected $location;

    public function __construct(
        Other $other,
        City $city,
        Location $location
    ) {
        $this->other  = $other;
        $this->city  = $city;
        $this->location = $location;
        
        // $this->middleware('permission:itemlist', ['only' => ['index']]);
        // $this->middleware('permission:additem', ['only' => ['create','store']]);
        // $this->middleware('permission:updateitem', ['only' => ['edit','update']]);
        // $this->middleware('permission:deleteitem', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        try {
            $searchColumns = ['id', 'title', 'price'];
            $search = $request->search;
            $place = $request->place;
            $relation = ['getCity', 'getLocation'];
            $others = $this->other->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            if ($search != '') {
                $others->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $others->where('location_id', $place);
            }
            ($order == '') ? $others->orderByDesc('id') : $others->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $others = $others->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $others = $others->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] =  $others;
            $success['locations'] =  $locations;
            return view('admin.master.other.list', $success);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function create()
    {
        try {
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->get();
            return view('admin.master.other.create', compact('cities', 'locations'));
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
            'city_id'       => 'required',
            'location_id'   => 'required',
            'icon'          => 'required | image ',
            'price'         => 'required',
            'title'         => 'required'
        ]);
        try {
            $params = [
                'city_id'       => $request->city_id,
                'location_id'   => $request->location_id,
                'icon'          => Helper::uploadsFile($request->icon, 'Upload-Image'),
                'title'         => $request->title,
                'price'         => $request->price,
                'status'        => 1,
                'priority'        => $request->priority,
            ];
            $otherCreated = $this->other->create($params);
            if ($otherCreated) {
                return redirect('admin/master/other')->with('message', 'other Added Successfully');
            } else {
                return redirect()->back()->withInput();
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function show($id)
    {
        try {
            $relation = ['getCity', 'getLocation'];
            $details['citys'] = $this->city->where('status', 1)->get();
            $details['locations'] = $this->location->where('status', 1)->get();
            $details['otherData'] = $this->other->with($relation)->whereId($id)->first();
            return view('admin.master.other.show', $details);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $other = $this->other->whereId($id)->first();
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->where('city_id', $other->city_id)->get();
            return view('admin.master.other.edit', compact('other', 'cities', 'locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'city_id'       => 'required',
            'location_id'   => 'required',
            'price'         => 'required',
            'title'         => 'required'
        ]);
        $otherData = $this->other->find($id);
        try {
            if (!empty($request->icon)) {
                $imagePath = public_path('/storage/' . $otherData->icon);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $params = [
                    'city_id'       => $request->city_id,
                    'location_id'   => $request->location_id,
                    'icon'          => Helper::uploadsFile($request->icon, 'Upload-Image'),
                    'title'         => $request->title,
                    'price'         => $request->price,
                    'priority'        => $request->priority,
                    'status'        => 1
                ];
            } else {
                $params = [
                    'city_id'       => $request->city_id,
                    'location_id'   => $request->location_id,
                    'title'         => $request->title,
                    'price'         => $request->price,
                    'priority'        => $request->priority,
                    'status'        => 1
                ];
            }
            $otherData->update($params);
            return redirect('admin/master/other')->with('message', 'other Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $otherData = $this->other->find($id);
            $imagePath = public_path('/storage/' . $otherData->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $otherData->delete();
            return redirect('admin/master/other')->with('message', 'other Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function changeStatus($id)
    {
        try {
            $otherData = $this->other->whereId($id)->first();
            if ($otherData->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = [
                'status' => $status
            ];
            $this->other->whereId($id)->update($status);
            return redirect('admin/master/other')->with('message', 'Status has been changed');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Other::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Other::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
