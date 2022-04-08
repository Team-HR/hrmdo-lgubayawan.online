<?php

namespace App\Http\Controllers\PMS\PCR;

use App\Http\Controllers\Controller;
use App\Models\PcrRecord;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class PcrSignatoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rating_period_id = intval($request->rating_period_id);
        $auth_user = auth()->user();
        $auth_user_employee_id = $auth_user->employee_id;
        $auth_user_department_id = $auth_user->department_id;
        $pcr_record = PcrRecord::where('employee_id', $auth_user_employee_id)->where('department_id', $auth_user_department_id)->get()->first();

        return response()->json($pcr_record);
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
        $form_data = $request->form_data;
        $rating_period_id = $request->rating_period_id;
        $pcr_record = new PcrRecord;
        $auth_user = auth()->user();
        $auth_user_employee_id = $auth_user->employee_id;
        $auth_user_department_id = $auth_user->department_id;
        $pcr_record->period_id = $rating_period_id;
        $pcr_record->employee_id = $auth_user_employee_id;
        $pcr_record->department_id = $auth_user_department_id;
        $pcr_record->employee_type = $form_data['employee_type'];
        $pcr_record->form_type = $form_data['form_type'];
        $pcr_record->employee_id_immediate_supervisor = isset($form_data['immediateSupervisor']['id'])?$form_data['immediateSupervisor']['id']:NULL;
        $pcr_record->full_name_immediate_supervisor = isset($form_data['immediateSupervisor']['full_name'])?$form_data['immediateSupervisor']['full_name']:NULL;
        $pcr_record->employee_id_department_head = isset($form_data['departmentHead']['id'])?$form_data['departmentHead']['id']:NULL;
        $pcr_record->full_name_department_head = isset($form_data['departmentHead']['full_name'])?$form_data['departmentHead']['full_name']:NULL;
        $pcr_record->employee_id_head_of_agency = isset($form_data['headOfAgency']['id'])?$form_data['headOfAgency']['id']:NULL;
        $pcr_record->full_name_head_of_agency = isset($form_data['headOfAgency']['full_name'])?$form_data['headOfAgency']['full_name']:NULL;
        $pcr_record->save();
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
        //
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
        //
    }
}
