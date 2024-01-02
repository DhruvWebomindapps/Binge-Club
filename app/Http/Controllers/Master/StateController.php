<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
#use models
use App\Models\State;
use Exception;

class StateController extends Controller
{
    #bind model
    protected $state;

    function __construct(
        State $state
    ) {
        $this->state    = $state;
    }

    public function index(Request $request)
    {
        // get all states
        $searchColumns = ['id', 'name'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $states = $this->state->query();
        if ($search != '') {
            $states->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });
        }
        // sorting
        ($order == '') ? $states->orderByDesc('id') : $states->orderBy($order, $orderBy);
        $states = $states->orderBy('id', 'desc')->paginate(10);
        $success['lists'] = $states;
        return view('admin.master.state.list', $success);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.master.state.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'state'     => 'required | unique:states,name',
        ]);
        try {
            $requestedData = [
                'country_id'    => 1,
                'name'  => $request->state,
                'status'    => 1
            ];
            $state = $this->state->create($requestedData);
            if ($state) {
                return redirect('admin/master/state')->with('message', 'State created');
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
        $details['list'] = $this->state->whereId($id)->first();
        return view('admin.master.state.edit', $details);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $data = $this->state->find($id);
        $validate = $request->validate([
            'state'     => 'required',
        ]);
        try {
            $requested_Data = [
                'country_id'   => 1,
                'name'  => $request->state,
                'status' => $data ? $data->status : '1'
            ];
            $stateUpdate = $this->state->whereId($id)->update($requested_Data);
            if ($stateUpdate) {
                return redirect('admin/master/state/')->with('message', 'State successfully update');
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
        $this->state->whereId($id)->delete();
        return redirect('admin/master/state')->with('message', 'Successfully deleted');
    }

    public function changeStatus($id)
    {
        try {
            $state = $this->state->where('id', $id)->first();
            if ($state['status'] == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            $statusData = [
                'status' => $status
            ];
            $updated = $this->state->whereId($id)->update($statusData);
            if ($updated) {
                return redirect('admin/master/state')->with('message', 'Status changed successfully');
            } else {
                return redirect()->back()->with('error', 'internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
