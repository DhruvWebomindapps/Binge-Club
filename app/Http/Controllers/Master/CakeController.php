<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use Models
use App\Models\Cake;
use App\Models\City;
use App\Models\Location;

#use other classes
use Exception;

class CakeController extends Controller
{
    #Bind Model
    protected $cake;
    protected $city;
    protected $location;

    public function __construct(
        Cake $cake,
        city $city,
        Location $location
    ) {
        $this->cake  = $cake;
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
            $cakes = $this->cake->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            if ($search != '') {
                $cakes->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $cakes->where('location_id', $place);
            }
            ($order == '') ? $cakes->orderByDesc('id') : $cakes->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $cakes = $cakes->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $cakes = $cakes->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] =  $cakes;
            $success['locations'] =  $locations;
            return view('admin.master.cake.list', $success);
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
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->get();
            return view('admin.master.cake.create', compact('cities', 'locations'));
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
            $cakeCreated = $this->cake->create($params);
            if ($cakeCreated) {
                return redirect('admin/master/cake')->with('message', 'Cake Added Successfully');
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
        try {
            $relation = ['getCity', 'getLocation'];
            $details['citys'] = $this->city->where('status', 1)->get();
            $details['locations'] = $this->location->where('status', 1)->get();
            $details['cakeData'] = $this->cake->with($relation)->whereId($id)->first();
            return view('admin.master.cake.show', $details);
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
            $cake = $this->cake->whereId($id)->first();
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->where('city_id', $cake->city_id)->get();
            return view('admin.master.cake.edit', compact('cake', 'cities', 'locations'));
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
        $cakeData = $this->cake->find($id);
        try {
            if (!empty($request->icon)) {
                $imagePath = public_path('/storage/' . $cakeData->icon);
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
            $cakeData->update($params);
            return redirect('admin/master/cake')->with('message', 'Cake Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $cakeData = $this->cake->find($id);
            $imagePath = public_path('/storage/' . $cakeData->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $cakeData->delete();
            return redirect('admin/master/cake')->with('message', 'Cake Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function changeStatus($id)
    {
        try {
            $cakeData = $this->cake->whereId($id)->first();
            if ($cakeData->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = [
                'status' => $status
            ];
            $this->cake->whereId($id)->update($status);
            return redirect('admin/master/cake')->with('message', 'Status has been changed');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Cake::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Cake::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
