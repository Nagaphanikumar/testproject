<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MobjCareer; 
use App\Models\MObjHierarchy;
use App\Models\MObjType;
use App\Models\MObjDef;
use App\Models\MObjContact;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;


class CareersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $career = MobjCareer::all();
        return view('career', compact('career'));
    }

   

    public function store(Request $request)
    {
        // return response()->json($request);
        $name = $request->input('name');
        $email = $request->input('email');
        $phonenumber = $request->input('phonenumber');
        $image_64 = $request['uploadfile'];
        $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1]; // .jpg, .png, .pdf
        $replace = substr($image_64, 0, strpos($image_64, ',')+1);
        // Find substring to replace, e.g., data:image/png;base64,
        $image = str_replace($replace, '', $image_64);
        $image = str_replace(' ', '+', $image);
        $imageName = Str::random(10) . '.' . $extension;
        // Specify the relative path where you want to store the file
        $relativePath = 'images/' . $imageName;
        // Save the file
        if (Storage::disk('public')->put($relativePath, base64_decode($image))) {
            // File stored successfully
        } else {
            // Handle storage error
            return redirect()->back()->with('error', 'Error storing the file.');
        }
        
        // Create a new MObjCareer instance with the file URL
        $career = new MobjCareer([
            'name' => $name,
            'email' => $email,
            'phonenumber' => $phonenumber,
            'uploadfile' => $relativePath, // Store the URL in the 'uploadfile' field
        ]);
    
        $career->save();
        return redirect()->back()->with('success', 'Object Definition added successfully.');
    }

    // public function getdata($obj_id)
    // {
    //     $defdata = MObjDef::find($obj_id);
    //     $column_name = 'obj_id'; 
    //     $hierarchydata = MObjHierarchy::where($column_name, $obj_id)->first();
    //     $selectedValue=$defdata['obj_type_id'];
    //     if (isset($hierarchydata['obj_id'])) {
    //         $tmpobj_id = $hierarchydata['obj_id'];
    //     }
    //     if (isset($hierarchydata['parent_obj_id'])) {
    //         $parent_obj_id=$hierarchydata['parent_obj_id'];
    //     }
        
    //     return view('ajaxedit', compact('defdata','selectedValue','hierarchydata','tmpobj_id','parent_obj_id'));
    // }
    public function delete($obj_id)
    {
        DB::table('m_obj_careers')->where('id', $obj_id)->delete();
       
        return redirect('home');
    }
}
