<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Doctor;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MObjHierarchy;
use App\Models\MObjType;
use App\Models\MObjDef;
use App\Models\MObjCareer;
use App\Models\MObjContact;
use App\Models\Appointment;
use App\Models\DoctorLeaveSchedule;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;






class doctorcontroller extends Controller
{
   
    public function store(Request $request)
    {
        $data = $request->all();
        $parent_obj_id = $request->input('parent_obj_id');
        $obj_id = $request->input('obj_id');
        $gender = $request->input('gender');
        $role = $request->input('role');
        $information =  $request->input('info');
        $speciality = $request->input('Speciality');
        if($speciality){
        $mObjHierarchies = MObjHierarchy::whereIn('obj_id', $speciality)->get();
        
        $displayNames = [];
       
        $displayNames = $mObjHierarchies->pluck('display_name')->toArray();
        $specialityString = implode(', ', $displayNames);
        }
      
        $experience=$request->input('Experience');
        $qualification=$request->input('Qualification');
        
        if (isset($data['days']) && is_array($data['days'])) {
            foreach ($data['days'] as $index => $day) {
                
               
                $schedule = new DoctorSchedule();
                $schedule->obj_id = $obj_id; 
                $schedule->day = $day;
        
                if (isset($data['select_all']) && $data['select_all'] == 'on') {
                    $validator = Validator::make($request->all(), [
                        'start_time_select_all' => 'required',
                        'end_time_select_all' => 'required|after_or_equal:start_time_select_all',
                    ]);
                
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    // If "Select All" is checked, use the same start and end times for all days
                    $schedule->start_time = $data['start_time_select_all'];
                    $schedule->end_time = $data['end_time_select_all'];
        
                    // Check if the values are within the range in the database
                    $existingSchedule = DoctorSchedule::where('obj_id', $obj_id)
                        ->where('day', $day)
                        ->where('start_time', '<=', $schedule->end_time)
                        ->where('end_time', '>=', $schedule->start_time)
                        ->first();
        
                    if ($existingSchedule) {
                      $request->session()->flash('error', 'The time range is already available ');
                    }
                    $schedule->save();
                } else {
                    $validator = Validator::make($request->all(), [
                        'start_times' => 'required',
                        'end_times' => 'required',
                    ]);
                   
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    // If "Select All" is not checked, use the individual start and end times
                    $schedule->start_time = isset($data['start_times'][$day]) ? $data['start_times'][$day] : null;
                    $schedule->end_time = isset($data['end_times'][$day]) ? $data['end_times'][$day] : null;
        
                    // Check if start_times and end_times are set and not null
                    if ($schedule->start_time !== null && $schedule->end_time !== null) {
                        // Check if the values are within the range in the database
                        $existingSchedule = DoctorSchedule::where('obj_id', $obj_id)
                            ->where('day', $day)
                            ->where('start_time', '<=', $schedule->end_time)
                            ->where('end_time', '>=', $schedule->start_time)
                            ->first();
        
                        if ($existingSchedule) {
                           
                            $request->session()->flash('error', 'The time range is already available ');

                        }
                    }
                    $schedule->save();
                }
               
            }
        }
    
        if (!empty($gender) || !empty($speciality) || !empty($experience) || !empty($qualification)) {
            $doctor = new Doctor([
               'parent_obj_id' => $parent_obj_id,
                'obj_id' => $obj_id,
                'Speciality' => $specialityString,
                'Experience' => $experience,
                'Qualification' => $qualification,
                'Gender' => $gender,
                'role'   => $role,
                'information' => $information,
            ]);
          
            $doctor->save();
        }
        // $request->session()->flash('success', 'Data Inserted Successfully');
        return back();
    }
    

    public function doctorleave(){

        $departments = MObjHierarchy::where('parent_obj_id', 27)->pluck('display_name', 'obj_id');
           
        $doctors = MObjHierarchy::where('parent_obj_id',158)->pluck('display_name', 'obj_id');
        // $leave_dates = DoctorLeaveSchedule::all();
        $leave_dates = DoctorLeaveSchedule::join('m_obj_hierarchy as d', 'doctor_leave_schedule.doctor_id', '=', 'd.obj_id')
        ->join('m_obj_hierarchy as dep', 'doctor_leave_schedule.department_id', '=', 'dep.obj_id')
        ->select('doctor_leave_schedule.*', 'd.display_name as doctor_name', 'dep.display_name as department_name')
        ->get();


       return view('doctorleave',compact('departments','doctors','leave_dates'));
    }

    public function leavestore(Request $request){
        // dd($request->all());
         //validation rules
         $rules = [
            'department' => 'required',
            'doctors' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after_or_equal:start_time',
        ];
        
        // Custom error messages
        $messages = [
            'start_date.after_or_equal' => 'The start date must be today or a future date.',
            'end_date.after_or_equal' => 'The end date must be equal to or after the start date.',
            'start_time.after_or_equal' => 'The start time must be the current time or a future time.',
            'end_time.after_or_equal' => 'The end time must be equal to or after the start time.',
        ];
    
        $this->validate($request, $rules, $messages);


if($request->input('start_time') !== null){
$overlap = DoctorLeaveSchedule::where('doctor_id', $request->input('doctors'))
    ->where(function ($query) use ($request) {
        $query->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->input('start_date'), $request->input('end_date')])
                ->orWhereBetween('end_date', [$request->input('start_date'), $request->input('end_date')])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_date', '<=', $request->input('start_date'))
                        ->where('end_date', '>=', $request->input('end_date'));
                });
        })
        ->where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->whereNotNull('start_time')
                            ->whereNotNull('end_time')
                            ->where(function ($query) use ($request) {
                                $query->whereBetween('start_time', [$request->input('start_time'), $request->input('end_time')])
                                    ->orWhereBetween('end_time', [$request->input('start_time'), $request->input('end_time')])
                                    ->orWhere(function ($query) use ($request) {
                                        $query->where('start_time', '<=', $request->input('start_time'))
                                            ->where('end_time', '>=', $request->input('end_time'));
                                    });
                            });
                    })
                    ->orWhere(function ($query) use ($request) {
                        $query->whereNull('start_time')->whereNull('end_time');
                    });
                });
            });
        });
    })
    ->exists();
}else{

$overlap = DoctorLeaveSchedule::where('doctor_id', $request->input('doctors'))
    ->where(function ($query) use ($request) {
        $query->where(function ($query) use ($request) {
            $query->whereBetween('start_date', [$request->input('start_date'), $request->input('end_date')])
                ->orWhereBetween('end_date', [$request->input('start_date'), $request->input('end_date')])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_date', '<=', $request->input('start_date'))
                        ->where('end_date', '>=', $request->input('end_date'));
                });
        });
    })
    ->exists();
}


if ($overlap) {
    return redirect()->back()->withErrors(['start_date' => 'The range overlaps with an existing record.',
                                            'end_date' =>'The range overlaps with an existing record.' ]);
}
        $department = $request->input('department');
        $doctor = $request->input('doctors');
        $startdate = $request->input('start_date');
        $enddate = $request->input('end_date');
        $starttime = $request->input('start_time');
        $endtime = $request->input('end_time');
       

        $doctor_leave_schedule = new DoctorLeaveSchedule([
            'department_id' => $department,
            'doctor_id' => $doctor,
            'start_date' => $startdate,
            'end_date' => $enddate,
            'start_time' => $starttime,
            'end_time' => $endtime,
        ]);
        $doctor_leave_schedule->save();
        $request->session()->flash('success', 'Data Inserted Successfully');

        return back();
    }


    public function delete($id){
        DB::table('doctor_leave_schedule')->where('id', $id)->delete();
        return back();
    }

    public function edit($id)
    {
        $departments = MObjHierarchy::where('parent_obj_id', 27)->pluck('display_name', 'obj_id');
        $leave_dates = DoctorLeaveSchedule::all();
        
        $leave = DoctorLeaveSchedule::find($id);
        $id = $leave->id ?? null;
        $dept_id = $leave->department_id ?? null;
        $specialty = MObjHierarchy::where('obj_id', $dept_id)
        ->where('parent_obj_id', 27)
        ->value('display_name');
        $specialties = explode(',', $specialty);
                
        $specialties = array_map('trim', $specialties);
        $doctorsdata = Doctor::where(function ($query) use ($specialties) {
                foreach ($specialties as $specialty) {
                    $query->orWhere('Speciality', 'like', '%' . trim($specialty) . '%');
                }
            })->get();
            
            $doctorIds = [];
            foreach ($doctorsdata as $doctor) {
                $doctorIds[] = $doctor->obj_id;
            }
            $hierarchyData1 = MObjHierarchy::whereIn('obj_id', $doctorIds)->get();  
            foreach ($hierarchyData1 as $item) {
                $doctorIds[] = $item->obj_id;
            }
            $doctors = DB::table('m_obj_hierarchy')
            ->select('m_obj_def.*', 'doctors.*', 'm_obj_hierarchy.*')
            ->join('m_obj_def', 'm_obj_hierarchy.obj_id', '=', 'm_obj_def.obj_id')
            ->leftJoin('doctors', 'm_obj_def.obj_id', '=', 'doctors.obj_id')
            ->whereIn('m_obj_hierarchy.obj_id', $doctorIds)
            ->pluck('display_name', 'obj_id');
        
        $doctor_id = $leave->doctor_id ?? null;
        $start_date = $leave->start_date ?? null;
        $end_date = $leave->end_date ?? null;
        $start_time = $leave->start_time ?? null;
        $end_time = $leave->end_time ?? null;
    
        return view('leaveedit', compact('dept_id', 'doctor_id', 'start_date', 'end_date','departments','doctors','leave_dates','id','start_time','end_time'));
    }

    public function update(Request $request,$id){
        $rules = [
            'department' => 'required',
            'doctors' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable',
            'end_time' => 'nullable|after_or_equal:start_time',
        ];

        $messages = [
            'start_date.after_or_equal' => 'The start date must be today or a future date.',
            'end_date.after_or_equal' => 'The end date must be equal to or after the start date.',
            'start_time.after_or_equal' => 'The start time must be the current time or a future time.',
            'end_time.after_or_equal' => 'The end time must be equal to or after the start time.',
        ];
    
        $this->validate($request, $rules, $messages);
        // Check for overlaps
        $overlap = DoctorLeaveSchedule::where('id', '!=', $id) // Exclude the current record being updated
        ->where('doctor_id', $request->input('doctors'))
        ->where(function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->input('start_date'), $request->input('end_date')])
                    ->orWhereBetween('end_date', [$request->input('start_date'), $request->input('end_date')])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->input('start_date'))
                            ->where('end_date', '>=', $request->input('end_date'));
                    });
            });

            // Check for time-related conditions only if start_time is present
            if ($request->filled('start_time')) {
                $query->where(function ($query) use ($request) {
                    $query->where(function ($query) use ($request) {
                        $query->where(function ($query) use ($request) {
                            $query->where(function ($query) use ($request) {
                                $query->whereNotNull('start_time')
                                    ->whereNotNull('end_time')
                                    ->where(function ($query) use ($request) {
                                        $query->whereBetween('start_time', [$request->input('start_time'), $request->input('end_time')])
                                            ->orWhereBetween('end_time', [$request->input('start_time'), $request->input('end_time')])
                                            ->orWhere(function ($query) use ($request) {
                                                $query->where('start_time', '<=', $request->input('start_time'))
                                                    ->where('end_time', '>=', $request->input('end_time'));
                                            });
                                    });
                            })
                            ->orWhere(function ($query) use ($request) {
                                $query->whereNull('start_time')->whereNull('end_time');
                            });
                        });
                    });
                });
            }
        })
        ->exists();
        
    if ($overlap) {
        return redirect()->back()->withErrors(['start_date' => 'The date and time range overlaps with an existing record.']);
    }
        $leave = DoctorLeaveSchedule::find($id);
        $leave->department_id = $request->input('department');
        $leave->doctor_id = $request->input('doctors');
        $leave->start_date = $request->input('start_date');
        $leave->end_date = $request->input('end_date');
        $leave->start_time = $request->input('start_time');
        $leave->end_time = $request->input('end_time');
        $leave->save(); // Save the changes
    
        $request->session()->flash('success', 'Data Updated Successfully');
        return redirect('/leaveschedule');
    }

    public function doctorupdate(Request $request,$id){
       

        $leave = Doctor::where('obj_id', $id)->first();
        $speciality = $request->input('Speciality');
        $mObjHierarchies = MObjHierarchy::whereIn('obj_id', $speciality)->get();
        $displayNames = [];
        $displayNames = $mObjHierarchies->pluck('display_name')->toArray();
        $specialityString = implode(', ', $displayNames);
        $leave->parent_obj_id = $request->input('parent_obj_id');
        $leave->obj_id = $request->input('obj_id');
        $leave->Speciality = $specialityString;
        $leave->Experience = $request->input('Experience');
        $leave->Qualification = $request->input('Qualification');
        $leave->Gender = $request->input('gender');
        $leave->role = $request->input('role');
        $leave->information = $request->input('info');
        $leave->save();
        $request->session()->flash('success', 'Data Updated Successfully');
        return back();
    }


    public function doctordelete($id){
        DB::table('doctor_schedule')->where('id', $id)->delete();
        return back();
    }

    public function doctoredit($id){
        $doctor_schedule = DoctorSchedule::find($id);
        // dd($doctor);
        return view('doctoredit',compact('doctor_schedule'));
    }

    // public function doctorupdate1(Request $request,$id){
    //     $doctorSchedule = DoctorSchedule::find($id);

    //     $doctorSchedule->update([
    //         'day' => $request->input('day'),
    //         'start_time' => $request->input('start_time'),
    //         'end_time' => $request->input('end_time'),
    //     ]);

    //     return back();
    

    // }

    public function doctorupdate1(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required|after_or_equal:start_time',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $doctorSchedule = DoctorSchedule::find($id);

        if (!$doctorSchedule) {
            return abort(404);
        }

        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');

        if ($start_time !== null && $end_time !== null) {
            $existingSchedule = DoctorSchedule::where('obj_id', $doctorSchedule->obj_id)
                ->where('day', $request->input('day'))
                ->where('id', '!=', $id) 
                ->where('start_time', '<=', $end_time)
                ->where('end_time', '>=', $start_time)
                ->first();

            if ($existingSchedule) {
                $request->session()->flash('error', 'The time range overlaps with an existing record.');
                return back();
            }

            // Values are not within the range, proceed with updating
            $doctorSchedule->update([
                'day' => $request->input('day'),
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
        } else {
            // Handle the case where start_time or end_time is null
            return back()->withErrors(['message' => 'Validation failed: start_time or end_time cannot be null.']);
        }
        $request->session()->flash('Success', 'The time range Updated Successfully.');

        return back();
    }


    public function addoctor(Request $request,$id){

        $childrendata = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
        ->where('m_obj_hierarchy.obj_id', $id)
        ->get();  
        $departments = MObjHierarchy::where('parent_obj_id', 27)->pluck('display_name','obj_id');
        if ($id) {
            $defdata = MObjDef::find($id);
            $doctordata = Doctor::where('obj_id', $id)->get();

            $doctor_schedule = DoctorSchedule::where('obj_id', $id)->get();

            // dd($doctor_schedule);

            if (!$doctordata->isEmpty()) {
                // $objHierarchy = MObjHierarchy::where('display_name', $doctordata->first()->Speciality)->first();
                $objHierarchy = MObjHierarchy::where('display_name', $doctordata->first()->Speciality)
                ->where('parent_obj_id', 27)
                ->first();
                if ($objHierarchy) {
                    $department_name_id = $objHierarchy->obj_id;    
                } else {
                    $department_name_id = null;
                }
            }else{
                // $department_name_id = null;
            }
        }
        return view('adddoctor',compact('id','departments','doctordata'));

    }

    public function editdoctor(Request $request,$id){
        $departments = MObjHierarchy::where('parent_obj_id', 27)->pluck('display_name','obj_id');
        $department_name_id = null;
        if ($id) {
            $defdata = MObjDef::find($id);
            $doctordata = Doctor::where('obj_id', $id)->first();
            $doctor_schedule = DoctorSchedule::where('obj_id', $id)->get();


            if ($doctordata) {
                $specialities = explode(', ', $doctordata->Speciality);

                $objHierarchy = MObjHierarchy::whereIn('display_name', $specialities)
                ->where('parent_obj_id', 27)
                ->get();
        
                $department_name_id = $objHierarchy->pluck('obj_id')->toArray();

            }else{
            }
           
       }
       return view('editdoctor',compact('departments','department_name_id','doctordata','doctor_schedule','id'));
    }

   }
