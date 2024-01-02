<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use Model
use App\Models\Decoration;
use App\Models\Location;
use App\Models\City;

#use other classes
use Exception;

class DecorationController extends Controller
{
    protected $decoration;
    protected $city;
    protected $location;

    public function __construct(
        city $city,
        Location $location,
        decoration $decoration,
    ) {
        $this->decoration  = $decoration;
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
            $search = request()->search;
            $place = request()->place;
            $relation = ['getCity', 'getLocation'];
            $decorations = $this->decoration->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = request()->orderedColumn;
            $orderBy = request()->orderBy;
            if ($search != '') {
                $decorations->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $decorations->where('location_id', $place);
            }
            ($order == '') ? $decorations->orderByDesc('id') : $decorations->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $decorations = $decorations->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $decorations = $decorations->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] = $decorations;
            $success['locations'] =  $locations;
            return view('admin.master.decoration.list', $success);
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
            $flag['citys'] = $this->city->where('status', 1)->get();
            return view('admin.master.decoration.create', $flag);
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
                'description'        => $request->description,
            ];
            $decorationCreated = $this->decoration->create($params);
            if ($decorationCreated) {
                return redirect('admin/master/decoration')->with('message', 'decoration Added Successfully');
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
            $details['decorationData'] = $this->decoration->with($relation)->whereId($id)->first();
            return view('admin.master.decoration.show', $details);
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
            $list = $this->decoration->whereId($id)->first();
            $cities = $this->city->where('status', 1)->get();
            $locations = $this->location->where('status', 1)->where('city_id', $list->city_id)->get();
            return view('admin.master.decoration.edit', compact('list', 'cities', 'locations'));
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
        $decorationData = $this->decoration->find($id);
        try {
            if (!empty($request->icon)) {
                $params = [
                    'city_id'       => $request->city_id,
                    'location_id'   => $request->location_id,
                    'icon'          => Helper::uploadsFile($request->icon, 'Upload-Image'),
                    'title'         => $request->title,
                    'price'         => $request->price,
                    'status'        => 1,
                    'priority'      => $request->priority,
                    'description'   => $request->description,
                ];
            } else {
                $params = [
                    'city_id'       => $request->city_id,
                    'location_id'   => $request->location_id,
                    'title'         => $request->title,
                    'price'         => $request->price,
                    'status'        => 1,
                    'priority'      => $request->priority,
                    'description'   => $request->description,
                ];
            }
            $decorationUpdated = $decorationData->update($params);
            return redirect('admin/master/decoration')->with('message', 'decoration Updated Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        try {
            $decorationData = $this->decoration->find($id);
            $decorationData->delete();
            return redirect('admin/master/decoration')->with('message', 'decoration Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function changeStatus($id)
    {
        try {
            $decorationData = $this->decoration->whereId($id)->first();
            if ($decorationData->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = [
                'status' => $status
            ];
            $this->decoration->whereId($id)->update($status);
            return redirect('admin/master/decoration')->with('message', 'Status has been changed');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Decoration::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Decoration::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
