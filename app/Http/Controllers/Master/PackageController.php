<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#use Models
use App\Models\City;
use App\Models\Screen;
use App\Models\Location;
use App\Models\Package;
use App\Models\PackageImage;

#use other classes
use Exception;
use App\Helpers\Helper;

class PackageController extends Controller
{
    #Bind model
    protected $city;
    protected $screen;
    protected $package;
    protected $location;
    protected $occasions;
    protected $packageImg;
    protected $packageFeatures;
    protected $package_highlight;
    protected $package_decoration;

    function __construct(
        City                  $city,
        Screen                $screen,
        Package               $package,
        Location              $location,
        PackageImage          $packageImg,
    ) {
        $this->city                     = $city;
        $this->screen                   = $screen;
        $this->package                  = $package;
        $this->location                 = $location;
        $this->packageImg               = $packageImg;
        
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
            $relation = ['getCity', 'getLocation', 'getScreen', 'getPackageImage'];
            $packages = $this->package->with($relation);
            $locations = $this->location->where('status', 1)->get();
            $order = $request->orderedColumn;
            $orderBy = $request->orderBy;
            if ($search != '') {
                $packages->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
            }
            if ($place != '') {
                $packages->where('location_id', $place);
            }
            ($order == '') ? $packages->orderByDesc('id') : $packages->orderBy($order, $orderBy);
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $packages = $packages->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(10);
            } else {
                $packages = $packages->orderBy('id', 'desc')->paginate(10);
            }
            $flag['package_lists']  = $packages;
            $flag['locations'] =  $locations;
            return view('admin.master.package.list', $flag);
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
            $city_lists  = $this->city->where('status', 1)->get();
            return view('admin.master.package.create', compact('city_lists'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            // 'city_id'       => 'required',
            // 'location_id'   => 'required',
            // 'screen_id'     => 'required',
            'title'         => 'required',
            'price'         => 'required',
            'slug'          => 'required | unique:packages,slug',
            'image_file'    => 'required'
        ]);
        try {
            $inputParameter = [
                'city_id'            => $request->city_id,
                'location_id'        => $request->location_id,
                'screen_id'          => $request->screen_id,
                'title'              => $request->title,
                'slug'               => $request->slug,
                'description'        => $request->description,
                'price'              => $request->price,
                'discount_percent'   => $request->discount_percentage,
                'discount_price'     => $request->discount_amount,
                'grand_total'        => $request->grand_total,
                'discount_s_date'    => $request->discount_s_date,
                'discount_e_date'    => $request->discount_e_date,
                'status'             => 1,
                'priority'        => $request->priority,
            ];
            $package = $this->package->create($inputParameter);

            // package image will create
            foreach ($request->image_file as $key => $packageImage) {
                $inputData = [
                    'package_id'    => $package->id,
                    'package_image' => Helper::uploadsFile($packageImage, 'Upload-Image')
                ];
                $this->packageImg->create($inputData);
            }
            if ($package) {
                return redirect('admin/master/package')->with('message', 'Package created successfully');
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
    public function show(Request $request, $id)
    {
        // return $id;
        try {
            $relation = ['getCity', 'getLocation', 'getScreen', 'getPackageImage'];
            $flag['package_list']  = $this->package->with($relation)->whereId($id)->first();
            return view('admin.master.package.show', $flag);
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
            $relation = ['getCity', 'getLocation', 'getScreen', 'getPackageImage'];
            $package = $this->package->with($relation)->whereId($id)->first();
            $city_lists = $this->city->where('status', 1)->get();
            $location_list = $this->location->where('status', 1)->where('city_id', $package->city_id)->get();
            $screen_list = $this->screen->where('status', 1)->where('location_id', $package->location_id)->get();
            return view('admin.master.package.edit', compact('package','city_lists','location_list','screen_list'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        // dd($request->all());
        $data = $this->package->find($id);
        $validate = $request->validate([
            // 'city_id'              => 'required',
            // 'location_id'          => 'required',
            // 'screen_id'            => 'required',
            'title'                => 'required',
            'slug'                 => 'required',
            'price'                => 'required'
        ]);
        // try {
        $requestedParameter = [
            'city_id'               => $request->city_id,
            'location_id'           => $request->location_id,
            'screen_id'             => $request->screen_id,
            'title'                 => $request->title,
            'slug'                  => $request->slug,
            'description'           => $request->description,
            'price'                 => $request->price,
            'discount_percent'      => $request->discount_percentage,
            'discount_price'        => $request->discount_amount,
            'grand_total'           => $request->grand_total,
            'discount_s_date'       => $request->discount_s_date,
            'discount_e_date'       => $request->discount_e_date,
            'status'                => $data ? $data->status : '1',
            'priority'        => $request->priority,
        ];
        $updated = $this->package->whereId($id)->update($requestedParameter);
        if ($request->image_file) {
            foreach ($request->image_file as $m_img) {
                $imgModel = new PackageImage();
                $imgModel->package_id = $id;
                $imgModel->package_image = Helper::uploadsFile($m_img, 'Upload-Image');
                $imgModel->save();
            }
        }

        if ($updated) {
            return redirect('admin/master/package')->with('message', 'Package updated successfully');
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deleted = $this->package->whereId($id)->delete();
            if ($deleted) {
                return redirect('admin/master/package')->with('message', 'Package deleted');
            } else {
                return redirect()->back()->with('error', 'Internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function packgeImgDelete($id)
    {
        try {
            $deletedImg = $this->packageImg->whereId($id)->delete();
            if ($deletedImg) {
                return redirect()->back()->with('message', 'Image deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function changeStatus($id)
    {
        try {
            $state = $this->package->where('id', $id)->first();
            if ($state['status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $statusData = [
                'status' => $status
            ];
            $updated = $this->package->whereId($id)->update($statusData);
            if ($updated) {
                return redirect('admin/master/package')->with('message', 'Status changed successfully');
            } else {
                return redirect()->back()->with('error', 'Internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    public function addMoreFeaturesField()
    {
        return view('admin.master.package.features_option');
    }
    public function countImgAddFieldRole(Request $request)
    {
        $count = $this->packageImg->where('package_id', $request->pkg_id)->count();
        if ($count > 0) {
            return view('admin.master.package.imgField_option2');
        } else {
            return view('admin.master.package.imgField_option');
        }
    }

    public function getPackagesByOccasion(Request $request)
    {
        // return "hello";
        try {
            $relation = ['getCity', 'getLocation', 'getScreen', 'getPackageImage', 'getOccasion'];
            $packagess = $this->package->with($relation);
            if (!is_null($request->occasion_id)) {
                $packagess->where('occasion_id', $request->occasion_id);
            }
            $flag['package_lists']  = $packagess->latest()->get();
            return view('admin.master.package.searchPackageByOccasion', $flag);
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function updatePriority(Request $request)
    {
        Package::find($request->id)->update(['priority' => $request->value]);
        return response('success', 200);
    }
    public function updatePrice(Request $request)
    {
        Package::find($request->id)->update(['price' => $request->value]);
        return response('success', 200);
    }
}
