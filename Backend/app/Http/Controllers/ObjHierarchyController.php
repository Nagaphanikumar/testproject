<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\MObjHierarchy;
use App\Models\MObjType;
use App\Models\MObjDef;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Cache;
use Imagick;

class ObjHierarchyController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // Logic to retrieve and return a list of items
        return view('services');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $customMessages = [
            'selectDropdown1.required' => 'The Object Name dropdown field is required.',
            'selectDropdown2.required' => 'The Parent Object Name dropdown field is required.',
            'displayorder.numeric' => 'The displayorder field contains only numeric values.',
            'displayable.boolean' => 'The displayable field contains only boolean values.',
            'displayorder.required' => 'The displayorder field is required.',
            'displayname.required' => 'The displayname field is required.',
            'routepath.required' => 'The routepath field is required.',
        ];

        $rules = [
            'selectDropdown1' => 'required', 
            'selectDropdown2' => 'required', 
            'displayorder' => 'required|numeric',
            'displayable' => 'nullable|boolean',
            'displayname' => 'required',
            'routepath' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules,$customMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $objhierarchy = new MObjHierarchy([
            'obj_id' => $request->input('selectDropdown1'),
            'parent_obj_id' => $request->input('selectDropdown2'),
            'display_order' => $request->input('displayorder'),
            'displayable' => $request->input('displayable'),
            'display_name' => $request->input('displayname'),
            'route_path' => $request->input('routepath'),
            'icon_code' => $request->input('iconcode'),
            'brand' => $request->input('brand'),
            'seo_title' => $request->input('seo_title'),
            'seo_description' => $request->input('seo_description'),
            'seo_keywords' => $request->input('seo_keywords'),
            'created_by' => auth()->user()->name,
        ]);

        // Handle the file upload
        if ($request->hasFile('imagename')) {
            $store = $this->compressImage($request);
            $objhierarchy->image_name = url("storage/images/$store");// Save the image path in the database
        }
        if ($request->hasFile('backgroundimg')) {
            $store = $this->compressImage($request,true);
            $objhierarchy->background_image = url("storage/images/$store");// Save the image path in the database
        }
        $objhierarchy->save();
        $objectdef = MObjDef::get();
        foreach ($objectdef as $obj) {
            $id = $obj->obj_id;
          // Forget cache for each obj_id
            cache()->forget('hierarchy_' . $id);
      }
        return redirect()->back()->with('success', 'Data added successfully.');
    }


    public function show($id)
    {
        // Logic to retrieve and return a single item by ID
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust image validation rules as needed
        ]);

        // Handle the file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        // Create a new Service record
        Service::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $imageName,
        ]);

        return redirect()->route('services.create')->with('success', 'Service added successfully.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $customMessages = [
            'selectDropdown1.required' => 'The Object Name dropdown field is required.',
            'selectDropdown2.required' => 'The Parent Object Name dropdown field is required.',
            'displayorder.numeric' => 'The displayorder field contains only numeric values.',
            'displayable.boolean' => 'The displayable field contains only boolean values.',
            'displayorder.required' => 'The displayorder field is required.',
            'displayname.required' => 'The displayname field is required.',
            'routepath.required' => 'The routepath field is required.',
        ];

        $rules = [
            'selectDropdown1' => 'required', 
            'selectDropdown2' => 'required', 
            'displayorder' => 'required|numeric',
            'displayable' => 'nullable|boolean',
            'displayname' => 'required',
            'routepath' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules,$customMessages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $objhierarchy = MObjHierarchy::where('obj_id', $id)->first();
        $objhierarchy->obj_id = $request->input('selectDropdown1');
        $objhierarchy->parent_obj_id = $request->input('selectDropdown2');
        $objhierarchy->display_order = $request->input('displayorder');
        $objhierarchy->displayable = $request->input('displayable');
        $objhierarchy->display_name = $request->input('displayname');
        $objhierarchy->route_path = $request->input('routepath');
        $objhierarchy->icon_code = $request->input('iconcode');
        $objhierarchy->brand = $request->input('brand');
        $objhierarchy->seo_title = $request->input('seo_title');
        $objhierarchy->seo_description = $request->input('seo_description');
        $objhierarchy->seo_keywords = $request->input('seo_keywords');
        // Handle the file upload
        if ($request->hasFile('imagename')) {
            $store = $this->compressImage($request);
            $objhierarchy->image_name = url("storage/images/$store");// Save the image path in the database
        }
        if ($request->hasFile('backgroundimg')) {
            $store = $this->compressImage($request,true);
            $objhierarchy->background_image = url("storage/images/$store");// Save the image path in the database
        }

        $objhierarchy->updated_by = auth()->user()->name;
        $pObjId = 1;
        if($objhierarchy->save()){
            $data =["obj_id" => $objhierarchy->obj_id,
                    "parent_obj_id" => $objhierarchy->parent_obj_id,
                    "display_order" => $objhierarchy->display_order,
                    "displayable" => $objhierarchy->displayable,
                    "display_name" => $objhierarchy->display_name,
                    "route_path" => $objhierarchy->route_path,
                    "image_name" => $objhierarchy->image_name,
                    "background_image" => $objhierarchy->background_image,
                    "cost" =>  $objhierarchy->cost         ];
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
            return response()->json(['success' => false, 'data' => '', 'message' => 'Something went wrong.']);
        }
        // return redirect('/admin')->with('success', 'Data Updated successfully.');

    }

    public function deleteimage(Request $request, $id){
        $objHierarchy = MObjHierarchy::where('obj_id', $id)->first();
        if ($objHierarchy) {
            $objHierarchy->update(['image_name' => null]);
            $objectdef = MObjDef::get();
                    foreach ($objectdef as $obj) {
                        $id = $obj->obj_id;
                      // Forget cache for each obj_id
                        cache()->forget('hierarchy_' . $id);
                  }
            return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Something went wrong.']);
        }
        
    }
    public function deletebgimage(Request $request, $id){
        $objHierarchy = MObjHierarchy::where('obj_id', $id)->first();
        if ($objHierarchy) {
            $objHierarchy->update(['background_image' => null]);
            return response()->json(['success' => true, 'message' => 'Background Image deleted successfully.']);
        }else{
            return response()->json(['success' => false, 'message' => 'Something went wrong.']);
        }
        
    }

    public function compressImaged($request,$flag=false)
{
    if($flag){
       $image = $request->file('backgroundimg');
    }else{
        $image = $request->file('imagename');
    }
    $imageName = time() . '.jpg'; // Ensure output is JPEG
    $path = storage_path("app/public/images");
    $destinationPath = $path . '/' . $imageName;

    try {
        // Load image into Imagick
        $imagick = new \Imagick($image->getPathname());

        // Convert image to JPEG format
        $imagick->setImageFormat('jpeg');

        // Strip unnecessary metadata (EXIF, ICC, etc.)
        $imagick->stripImage();

        // Set compression type and quality
        $imagick->setImageCompression(\Imagick::COMPRESSION_JPEG);
        $imagick->setImageCompressionQuality(70); // Lower value = more compression

        // Resize image (optional) to max 800px width while maintaining aspect ratio
        $imagick->resizeImage(800, 800, \Imagick::FILTER_LANCZOS, 1, true);

        // Reduce colors to optimize further
        $imagick->quantizeImage(256, \Imagick::COLORSPACE_RGB, 0, false, false);

        // Set JPEG sampling factor (reduces file size)
        $imagick->setOption('jpeg:sampling-factor', '4:2:0');

        // Save the compressed image
        $imagick->writeImage($destinationPath);

        // Clear memory
        $imagick->clear();
        $imagick->destroy();

        return $imageName;
    } catch (\Exception $e) {
        return response()->json(['error' => 'Image compression failed: ' . $e->getMessage()], 500);
    }
}
    



    public function compressImage($request,$flag = false)
    {
        if($flag){
            $image = $request->file('backgroundimg');
         }else{
             $image = $request->file('imagename');
         }
        $manager = new ImageManager(new Driver());
        // $image = $request->file('imagename');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = storage_path("app/public/images");
        // Define the path to save the image

            // Ensure the directory exists
            if (!file_exists($path)) {
                mkdir($path, 0777, true); // Create the directory if it doesn't exist
            }
        $img = $manager->read($image);
        $destinationPath = $path . '/' . $imageName;
        $img->toJpeg(70)->save($destinationPath);
        return $imageName;
    }

    

}
