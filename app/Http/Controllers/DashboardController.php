<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            return datatables()->of(Employee::where('user_type', 'employee')->latest()->get())
                    ->addColumn('action', function($data){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$data->id.'" data-original-title="Edit" class="edit btn btn-success edit-emp">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0);" id="delete-emp" data-toggle="tooltip" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn btn-danger">   Delete</a>';
                    return $button;
                    })
                    ->parameters([
                        'buttons' => ['excel'],
                    ])
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unique = '';
        if($request->employee_id){
            $emp = Employee::where('id', $request->employee_id)->first();
            if($emp->email != $request->email){
               $unique = '|unique:employees,email';
            }
        }

        $response['status'] = 'success';
        $validation = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z]+$/u',
            'email' => 'required|email'.$unique,
        ]); 

        if($validation->fails()){
            if($validation->errors()->messages()){
                $response['status'] = 'error';
                $response['messages'] = $validation->errors()->messages();
                return Response::json($response);
            }
        }

        $employeeId = $request->employee_id;
        $employee   =   Employee::updateOrCreate([
            'id' => $employeeId],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('Passsword123#'),
                'mobile_number' => $request->mobile_number,
                'designation' => $request->designation,
                'salary' => $request->salary
            ]);        
        return Response::json($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $employee  = Employee::where($where)->first();
     
        return Response::json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('id',$id)->delete();
     
        return Response::json($employee);
    }
}
