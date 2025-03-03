<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MObjHierarchy;
use App\Models\MObjType;
use App\Models\MObjDef;
class ObjTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
{
    // Logic to retrieve and return a list of items
    return view('products');
}

public function store(Request $request)
        {
            $validatedData = $request->validate([
                'objtypename' => 'required',
                'description' => 'required',
            ]);
            $objtype = new MObjType([
                'obj_type_name' => $request->input('objtypename'),
                'obj_type_desc' => $request->input('description'),
                'created_by' => auth()->user()->name,
            ]);
            $objtype->save();
            return redirect()->back()->with('success', 'Object Definition added successfully.');
        }

public function show($id)
{
    // Logic to retrieve and return a single item by ID
}

public function update(Request $request, $id)
{
    // Logic to update an existing item
}

public function destroy($id)
{
    // Logic to delete an item
}

}
