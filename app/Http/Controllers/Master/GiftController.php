<?php

namespace App\Http\Controllers\Master;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use Models
use App\Models\Gift;
use App\Models\City;
use App\Models\Location;

#use other classes
use Exception;

class GiftController extends Controller
{
    protected $gift;
    protected $city;
    protected $location;

    public function __construct(
        gift $gift,
        city $city,
        Location $location
    ) {
        $this->gift  = $gift;
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
            $gifts = $this->gift->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            if ($search != '') {
                $gifts->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $gifts->where('location_id', $place);
            }
            ($order == '') ? $gifts->orderByDesc('id') : $gifts->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $gifts = $gifts->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $gifts = $gifts->orderBy('id', 'desc')->paginate(10);
            }
            $success['lists'] = $gifts;
            $success['locations'] =  $locations;
            return view('admin.master.gift.list', $success);
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
            $flag['locations'] = $this->location->where('status', 1)->get();
            return view('admin.master.gift.create', $flag);
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
            $giftCreated = $this->gift->create($params);
            if ($giftCreated) {
                return redirect('admin/master/gift')->with('message', 'gift Added Successfully');
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
            $details['giftData'] = $this->gift->with($relation)->whereId($id)->first();
            return view('admin.master.gift.show', $details);
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
            $details['citys'] = $this->city->where('status', 1)->get();
            $details['locations'] = $this->location->where('status', 1)->get();
            $details['list'] = $this->gift->whereId($id)->first();
            return view('admin.master.gift.edit', $details);
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
        $giftData = $this->gift->find($id);
        try {
            if (!empty($request->icon)) {
                $imagePath = public_path('/storage/' . $giftData->icon);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $params = [
                    'city_id'       => $request->city_id,
                    'location_id'   => $request->location_id,
                    'icon'          => Helper::uploadsFile($request->icon, 'Upload-Image'),
                    'title'         => $request->title,
                    'price'         => $request->price,
                    'status'        => 1,
                    'priority'        => $request->priority,
                ];
            } else {
                $params = [
                    'city_id'       => $request->city_id,
                    'location_id'   => $request->location_id,
                    'title'         => $request->title,
                    'price'         => $request->price,
                    'status'        => 1,
                    'priority'        => $request->priority,
                ];
            }
            $giftData->update($params);
            return redirect('admin/master/gift')->with('message', 'gift Updated Successfully');
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
            $giftData = $this->gift->find($id);
            $imagePath = public_path('/storage/' .  $giftData->icon);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $giftData->delete();
            return redirect('admin/master/gift')->with('message', 'gift Deleted Successfully');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function changeStatus($id)
    {
        try {
            $giftData = $this->gift->whereId($id)->first();
            if ($giftData->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = [
                'status' => $status
            ];
            $this->gift->whereId($id)->update($status);
            return redirect('admin/master/gift')->with('message', 'Status has been changed');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Gift::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Gift::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
