<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Location;
use App\Models\Snack;
use Exception;
use Illuminate\Http\Request;

class SnackController extends Controller
{
    #Bind Model
    protected $snack;
    protected $city;
    protected $location;

    public function __construct(
        Snack $snack,
        City $city,
        Location $location
    ) {
        $this->snack  = $snack;
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
            $snacks = $this->snack->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            if ($search != '') {
                $snacks->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $snacks->where('location_id', $place);
            }
            ($order == '') ? $snacks->orderByDesc('id') : $snacks->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $snacks = $snacks->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $snacks = $snacks->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] =  $snacks;
            $success['locations'] =  $locations;
            return view('admin.master.snacks.list', $success);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function create()
    {
        try {
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->get();
            return view('admin.master.snacks.create', compact('cities', 'locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
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
            $snackCreated = $this->snack->create($params);
            if ($snackCreated) {
                return redirect('admin/master/snacks')->with('message', 'Snacks Added Successfully');
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
            $details['snacksData'] = $this->snack->with($relation)->whereId($id)->first();
            return view('admin.master.snacks.show', $details);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function edit($id)
    {
        try {
            $snacks = $this->snack->whereId($id)->first();
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->where('city_id', $snacks->city_id)->get();
            return view('admin.master.snacks.edit', compact('snacks', 'cities', 'locations'));
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
        $snacksData = $this->snack->find($id);
        try {
            if (!empty($request->icon)) {
                $imagePath = public_path('/storage/' . $snacksData->icon);
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
            $snacksData->update($params);
            return redirect('admin/master/snacks')->with('message', 'snacks Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $cakeData = $this->snack->find($id);
            $imagePath = public_path('/storage/' . $cakeData->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $cakeData->delete();
            return redirect('admin/master/snacks')->with('message', 'snacks Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function changeStatus($id)
    {
        try {
            $cakeData = $this->snack->whereId($id)->first();
            if ($cakeData->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = [
                'status' => $status
            ];
            $this->snack->whereId($id)->update($status);
            return redirect('admin/master/snacks')->with('message', 'Status has been changed');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Snack::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Snack::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
