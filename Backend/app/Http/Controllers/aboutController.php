<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class aboutController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
{
    // Logic to retrieve and return a list of items
    return view('about');
}

public function store(Request $request)
{
    // Logic to create a new item
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
