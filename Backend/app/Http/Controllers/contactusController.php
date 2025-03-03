<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\contact;

class contactusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $contact = contact::all();
        return view('contactus',compact('contact'));
    }

    public function store(Request $request)
    {
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $phonenumber = $request->input('phone');
        $message = $request->input('message');
        $feedback = $request->input('query');
            $contact = new contact([
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'phone' => $phonenumber,
                'feedback' => $feedback,
                'message' => $message,
            ]);
            $contact->save();
        return redirect()->back()->with('success', 'Thanks for contacting us we will reach you soon.');
    }

    public function edit($id){
       $result = DB::table('contact')->where('id', $id)->get();
       if($result){
        $result = $result[0];
       }else{
        $result = '';
       }
        return view('contactedit',compact('result'));

    }

    public function update(Request $request,$id){
        $contact = contact::findOrFail($id);
        $contact->firstname = $request->input('firstname');
        $contact->lastname = $request->input('lastname');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->feedback = $request->input('query');
        $contact->message = $request->input('message');
        $contact->save();
        return redirect()->back()->with('success','Data Updated Successfully');
    }
    public function delete($obj_id)
    {
        DB::table('contact')->where('id', $obj_id)->delete();
       
        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
