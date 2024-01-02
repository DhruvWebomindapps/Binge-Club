<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Bouquet;
use App\Models\City;
use App\Models\Location;
use Exception;
use Illuminate\Http\Request;

class BouquetController extends Controller
{
    #Bind Model
    protected $bouquet;
    protected $city;
    protected $location;

    public function __construct(
        Bouquet $bouquet,
        City $city,
        Location $location
    ) {
        $this->bouquet  = $bouquet;
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
            $bouquets = $this->bouquet->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            if ($search != '') {
                $bouquets->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $bouquets->where('location_id', $place);
            }
            ($order == '') ? $bouquets->orderByDesc('id') : $bouquets->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $bouquets = $bouquets->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $bouquets = $bouquets->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] =  $bouquets;
            $success['locations'] =  $locations;
            return view('admin.master.bouquet.list', $success);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function create()
    {
        try {
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->get();
            return view('admin.master.bouquet.create', compact('cities', 'locations'));
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
            $bouquetCreated = $this->bouquet->create($params);
            if ($bouquetCreated) {
                return redirect('admin/master/bouquet')->with('message', 'Bouquet Added Successfully');
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
            $details['bouquetData'] = $this->bouquet->with($relation)->whereId($id)->first();
            return view('admin.master.bouquet.show', $details);
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
            $bouquet = $this->bouquet->whereId($id)->first();
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->where('city_id', $bouquet->city_id)->get();
            return view('admin.master.bouquet.edit', compact('bouquet', 'cities', 'locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function update(Request $request,  $id)
    {
        $request->validate([
            'city_id'       => 'required',
            'location_id'   => 'required',
            'price'         => 'required',
            'title'         => 'required'
        ]);
        $bouquetData = $this->bouquet->find($id);
        try {
            if (!empty($request->icon)) {
                $imagePath = public_path('/storage/' . $bouquetData->icon);
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
            $bouquetData->update($params);
            return redirect('admin/master/bouquet')->with('message', 'Bouquet Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $bouquetData = $this->bouquet->find($id);
            $imagePath = public_path('/storage/' . $bouquetData->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $bouquetData->delete();
            return redirect('admin/master/bouquet')->with('message', 'Bouquet Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function changeStatus($id)
    {
        try {
            $bouquetData = $this->bouquet->whereId($id)->first();
            if ($bouquetData->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = [
                'status' => $status
            ];
            $this->bouquet->whereId($id)->update($status);
            return redirect('admin/master/bouquet')->with('message', 'Status has been changed');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Bouquet::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Bouquet::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
