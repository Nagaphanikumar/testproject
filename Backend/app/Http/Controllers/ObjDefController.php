<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MObjHierarchy;
use App\Models\MObjType;
use App\Models\MObjDef;
use App\Models\MobjCareer;
use App\Models\MObjContact;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

// use Intervention\Image\ImageManagerStatic as Image;




class ObjDefController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getHierarchyAsJson($pObjIdOrName, $diff = false) {     
        $pObjId = $pObjIdOrName;
        $cacheKey = 'hierarchy_' . $pObjId;

        // Check if data is present in the cache
        $cachedResult = cache($cacheKey);
        if ($cachedResult && !$diff) {
            return response()->json($cachedResult);
        } elseif ($cachedResult && $diff) {
            return $cachedResult;
        }
        $buildHierarchy = function ($parentId) use (&$buildHierarchy) {
            $result = MObjHierarchy::where('parent_obj_id', $parentId)
            ->with('objDef.objType')
            ->orderBy('display_order')
            ->get();
            $formattedResult = [];
            $title_name = MObjDef::find($parentId);
            $display_Parent_name= MObjHierarchy::find($parentId);
            if($title_name){
            $title_name = $title_name->obj_name;
            }else{
                $title_name = '';
            }
          
            foreach ($result as $item) {
                $relatedObjDef = MObjDef::find($item->obj_id);
                $formattedItem = [
                    "description" => $relatedObjDef->content,
                    "obj_name" => $relatedObjDef->obj_name,
                    "parent_obj_id" => $item->parent_obj_id,
                    "obj_id" => $item->obj_id,
                    "display_order" => $item->display_order,
                    "display_name" => $item->display_name,
                    "route_path" => $item->route_path,
                    "image_name" => $item->image_name,
                    "displayed" => $item->displayed,
                    "displayable" => $item->displayable,
                    "level" => $item->level,
                    'icon_code' => $item->icon_code,
                    "path" => $item->path,
                    "path_info" => $item->path_info,    
                    "items" => $buildHierarchy($item->obj_id),
                    'title_name' => $title_name,
                ];
                $formattedResult[] = $formattedItem;
            }   
            return $formattedResult;
        };  

         $formattedResult = cache()->remember('hierarchy_' . $pObjId, now()->addMinutes(10), function () use ($buildHierarchy, $pObjId) {
            return $buildHierarchy($pObjId);
        });

        if ($diff) {
            return $formattedResult;
        } else {
            return response()->json($formattedResult);

        }
    }
    // public function getHierarchyAsJson($pObjIdOrName, $diff = false) {
    //     // Assuming $pObjId is the ID from $pObjIdOrName
    
    //     $pObjId = $pObjIdOrName;
    
    //     // Call stored procedure to fetch hierarchy
    //     $formattedResult = DB::select('CALL get_hierarchy_as_json(?, ?)', [$pObjIdOrName, $diff]);
    
    //     if ($diff) {
    //         return $formattedResult;
    //     } else {
    //         return response()->json($formattedResult);
    //     }
    // }
    
    public function getdata($obj_id = false, $ajaxTemplate = false)
    {
        $targetSizeKB = 100;
        $objectTypes = MObjType::all();
        $objecthierarchy = MObjHierarchy::all();
        $brands = MObjHierarchy::where('parent_obj_id', 24)->get();
        $objectdef = MObjDef::all();

        $mainresponse = [];

       
        $defdata = $selectedValue = $hierarchydata = $tmpobj_id = $parent_obj_id = null;

        if ($obj_id) {
            $defdata = MObjDef::find($obj_id);
            $column_name = 'obj_id'; 
            $hierarchydata = MObjHierarchy::where($column_name, $obj_id)->first();
            $selectedValue=$defdata['obj_type_id'];
            if (isset($hierarchydata['obj_id'])) {
                $tmpobj_id = $hierarchydata['obj_id'];
            }
            if (isset($hierarchydata['parent_obj_id'])) {
                $parent_obj_id=$hierarchydata['parent_obj_id'];
            }
        }

        // $databaseImageNames = $objecthierarchy->pluck('image_name')->map(function ($path) {
        //     // Extract the path from the URL
        //     $parsedUrl = parse_url($path);
        //     return basename($parsedUrl['path']);
        // })->toArray();
        
        // // Get all image files in the storage folder
        // $storagePath = storage_path("app/public/images");
        // $storageImageNames = collect(Storage::files('public/images'))->map(function ($path) {
        //     return basename($path);
        // })->toArray();

        // // Find the image names that are in storage but not in the database
        // $imagesToRemove = array_diff($storageImageNames, $databaseImageNames);

        // // Remove the images from the storage folder
        // foreach ($imagesToRemove as $imageName) {
        //     $imagePath = $storagePath . '/' . $imageName;            
        //     if (file_exists($imagePath)) {
        //         unlink($imagePath);
        //     }
        // }
        if($ajaxTemplate){
            $html =  view('ajaxhometemplate', compact('objectTypes', 'objecthierarchy', 'objectdef', 'defdata','selectedValue','hierarchydata','tmpobj_id','parent_obj_id','ajaxTemplate','brands'))->render();
            return $html;
        }else{
            return view('home', compact('objectTypes', 'objecthierarchy', 'objectdef', 'defdata','selectedValue','hierarchydata','tmpobj_id','parent_obj_id','brands'));
        }
    }
       public function ajax($obj_id)
        {
            $hierarchyArray = $this->getHierarchyAsJson($obj_id, true);
            $defdata = MObjDef::find($obj_id);
            
            if (isset($hierarchyArray['error'])) {
                return response()->json(['error' => 'Hierarchy data not found'], 404);
            }

            $data = [
                'hierarchy' => json_encode($hierarchyArray),
                'defdata' => $defdata,
            ];

            return view('welcome', $data);
        }

     public function ajaxedit(Request $request,$obj_id = false)
    {
        $seoDisplayFlag = false;
        $name = $request->input('name');
        $objectTypes = MObjType::all();
        $brands = MObjHierarchy::where('parent_obj_id', 24)->get();
        $objectdef = MObjDef::all();
        $mainresponse = [];
        foreach ($objectdef as $mainvalue) {
            if ($mainvalue['obj_type_id'] == 1) {
                $mainresponse[] = [
                    'name' => $mainvalue['obj_name'],
                    'id'   => $mainvalue['obj_id'],
                    'Hierarchy' => $this->getHierarchyAsJson($mainvalue['obj_id'], true)
                ];
            }
        }
        $defdata = $selectedValue = $hierarchydata = $tmpobj_id = $parent_obj_id =  $childrenids = $displayNames =  $doctordata = $objHierarchy = $doctor_schedule = null;
        
        $department_name_id = null;
      
            $childrendata = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
                ->where('m_obj_hierarchy.obj_id', $obj_id)
                ->get();  
        if ($obj_id) {
            $defdata = MObjDef::find($obj_id);
            $column_name = 'obj_id'; 
            $hierarchydata = MObjHierarchy::where($column_name, $obj_id)->first();
            $selectedValue=$defdata['obj_type_id'];
            if (isset($hierarchydata['obj_id'])) {
                $tmpobj_id = $hierarchydata['obj_id'];
            }
            if (isset($hierarchydata['parent_obj_id'])) {
                $parent_obj_id=$hierarchydata['parent_obj_id'];
            }
        }

        if(isset($parent_obj_id)){
            $fetchData = MObjHierarchy::where('obj_id', $parent_obj_id)->select('parent_obj_id')->first();
            if(isset($fetchData) && $fetchData['parent_obj_id'] == 6){
                  $seoDisplayFlag = true;
            }
        }
        return view('ajaxedit', compact('objectTypes', 'objectdef', 'mainresponse', 'defdata','selectedValue','hierarchydata','tmpobj_id','parent_obj_id','childrendata','department_name_id','obj_id','brands','seoDisplayFlag'));
    }


    public function store(Request $request)
    {
        $obj_type_id = $request->input('selectDropdown');
        $obj_name = $request->input('name');
        $content = $request->input('editorContent');
           // Check if the combination of obj_type_id and obj_name already exists
           $existingObjDef = MObjDef::where('obj_type_id', $obj_type_id)
           ->where('obj_name', $obj_name)
           ->first();
   
       if ($existingObjDef) {
           return redirect()->back()->with('error', 'Object with the same name already exists Please give another name.');
       }
   
        if (!empty($obj_type_id) || !empty($obj_name) || !empty($content)) {
            $objDef = new MObjDef([
                'obj_type_id' => $obj_type_id,
                'obj_name' => $obj_name,
                'content' => $content,
                'created_by' => auth()->user()->name,
            ]);
            $objDef->save();
        }
        return redirect()->back()->with('success', 'Data added successfully.');
    }

    public function delete($obj_id)
    {
        $pObjId = 1;
        DB::table('m_obj_def')->where('obj_id', $obj_id)->delete();
        DB::table('m_obj_hierarchy')->where('obj_id', $obj_id)->delete();
        $html = $this->getdata(false,true);
        if(!empty($html)){
            $objectdef = MObjDef::get();
            foreach ($objectdef as $obj) {
                $id = $obj->obj_id;
              // Forget cache for each obj_id
                cache()->forget('hierarchy_' . $id);
          }
            return response()->json(array('success' => true, 'html'=> $html, 'message' => 'Data deleted successfully.'));
        }else{
            return response()->json(array('success' => false, 'html'=> $html, 'message' => 'Something went wrong!'));
        }
        // return redirect('admin');
    }

    public function update(Request $request, $id)
    {
        $pObjId = 1;
        $objDef = MObjDef::findOrFail($id);
        $objDef->obj_type_id = $request->input('selectDropdown');
        $objDef->obj_name = $request->input('name');
        $objDef->content = $request->input('editorContent');
        $objDef->updated_by =auth()->user()->name;
        // Check if the combination of obj_type_id and obj_name already exists
        $existingObjDef = MObjDef::where('obj_id', '!=', $id) // Exclude the current object being updated
        ->where('obj_name', $objDef->obj_name)
        ->first();
        if ($existingObjDef) {
            return response()->json(['success' => false, 'data' => '', 'message' => 'Object with the same name already exists Please give another name']);
        }
        if($objDef->save()){
            $data =["obj_type_id" => $objDef->obj_type_id,
                    "obj_name" => $objDef->obj_name,
                    "content" => $objDef->content,];
                    $objectdef = MObjDef::get();
                    foreach ($objectdef as $obj) {
                        $id = $obj->obj_id;
                      // Forget cache for each obj_id
                        cache()->forget('hierarchy_' . $id);
                  }
        // return redirect('/admin');
        // return redirect('/admin')->with('success', 'Data Updated successfully.');
            return response()->json(['success' => true, 'data' => $data, 'message' => 'Data Updated successfully.']);
        }else{
            return response()->json(['success' => false, 'data' => '', 'message' => 'Something went wrong!']);
        }

    }

    public function title($id){
        $result = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
                    ->where('m_obj_def.obj_id', $id)->where('displayable',1)->get();
        return $result;         
    }

   public function product($route,$obj_name){
    $result = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
    ->where('m_obj_def.obj_name', $obj_name)->get();
    $seoData = [];
    if($result){
        $result = $result[0];
        $seoData = seotags($result->obj_id);
    }else{
        $result = '';
    }
    return view('user.mainproduct',compact('result','seoData'));
   }

   public function productssub($route,$obj_name){
    $label = 'products';
    $brand = false;
    $seoData = [];
    $result = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
    ->where('m_obj_def.obj_name', $obj_name)->get();
    $flag = true;
    if($result){
        $id=$result[0]['obj_id'];
        $seoData = seotags($id);
        $final_result = $this->getHierarchyAsJson($id,true);
    }else{
        $final_result = '';
    }
    if(empty($final_result) && isset($id)){
        $flag = false;
        $final_result = $this->title($id);
        $seoData = seotags($id);
        $final_result = $final_result[0];
    }
    return view('user.productcategory',compact('final_result','flag','label','brand','seoData'));
   }


   public function brands($route,$obj_name){
    $label = 'brands';
    $id =  '';
    $brand = false;
    $seoData = [];
    $result = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
    ->where('m_obj_def.obj_name', $obj_name)
    ->where('parent_obj_id',24)->get();
    $flag = false;
    $brandName = $brandContent = $brandImage = '';
    if(isset($result,$result[0])){
        $id=$result[0]['obj_id'];
        $brandName = $result[0]['display_name'];
        $brandContent = $result[0]['content'];
        $getData = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
                ->where('m_obj_hierarchy.brand', $id)
                ->get()
                ->toArray();
        $seoData = seotags($id);
    
    // Replace 'description' with 'content'
    $final_result = array_map(function ($item) use ($brandName,$brandContent,$brandImage) {
        $item['title_name'] = $brandName; // Add brand name as 'title_name'
        $item['brand_content'] = $brandContent; // Add brand content'
        $item['brand_image'] = $brandImage; // Add brand image'
        return $item;
    }, $getData);
    
        $flag = true;
    }else{
        $final_result = '';
    }
    if(empty($final_result) && isset($id)){
        $brand = true;
        $seoData = seotags($id);
        $final_result = $this->title($id);
        $final_result = $final_result[0];
    }
    // die;
    return view('user.productcategory',compact('final_result','flag','label','brand','seoData','id'));
   }

   public function home(){
      $seoData = seotags(4);
      $facebookData = DB::table('facebook_posts')->get();
      $twitterData = DB::table('twitterposts')->get();
      return view('user.home',compact('seoData','facebookData','twitterData'));
   }

   public function aboutus(){
    $seoData = seotags(5);
    return view('user.about',compact('seoData'));
   }

   public function quality(){
    $seoData = seotags(118);
    $id = 118;
    $flag = true;
    return view('user.quality',compact('seoData','flag','id'));
   }

   public function blog(){
    $seoData = seotags(119);
    $result = MObjDef::join('m_obj_hierarchy', 'm_obj_def.obj_id', '=', 'm_obj_hierarchy.obj_id')
            ->where('m_obj_hierarchy.parent_obj_id', 119)
            ->get();    
    return view('user.blog',compact('seoData','result'));
   }

   public function viewBlog($name){
    if($name){
        $data = MObjDef::where('obj_name',$name)->first();
        if(isset($data)){
            $id = $data->obj_id;
            $seoData = seotags($id);
            $flag = false;
        }else{
            return back();
        }
       
    }else{
        return back();
    }
 
    return view('user.quality',compact('seoData','flag','id'));
   }

   public function contact(){
    $seoData = seotags(7);
    return view('user.contact',compact('seoData'));
   }

   public function products(){
    $seoData = seotags(6);
    return view('user.product',compact('seoData'));
   }

   public function checkdata(){
    if(isset($_POST['selectedValue'])){
        $checkFlag = false;
        $fetchData = DB::table('m_obj_hierarchy')->select('parent_obj_id')->where('obj_id',$_POST['selectedValue'])->get();
        if(isset($fetchData,$fetchData[0]) && $fetchData[0]->parent_obj_id == 6){
           $checkFlag = true;
        }
        return $checkFlag;
    }else{
        return false;
    }
 }


 public function facebookfeeeds(){
    $data = DB::table('facebookfeeds')->first();
    return view('facebookfeeds',compact('data'));
 }

public function facebookfeedupdate(Request $request){
    $request->validate([
        'page_id' => 'required|string',
        'access_token' => 'required|string',
    ]);

    $updated = DB::table('facebookfeeds')
    ->where('id', $request->id)
    ->update([
        'page_id' => $request->page_id,
        'access_token' => $request->access_token,
    ]);

    if ($updated) {
    return response()->json(['success' => 'Data updated successfully!']);
    }

    return response()->json(['error' => 'Record not found!'], 404);
}

    public function saveTimeZone(Request $request)
    {
        $timeZone = $request->input('timeZone');


        // Save the time zone to the user's profile or session
        // For example, store it in the session
        session(['user_time_zone' => $timeZone]);

        // Or save it to the database for the logged-in user
        // Auth::user()->update(['time_zone' => $timeZone]);

        return response()->json(['success' => true, 'message' => 'Time zone saved successfully!']);
}

}