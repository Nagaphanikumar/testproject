<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class GetHomeController extends Controller
{
    public function getData($id){
        if ($id) {
            $getData = DB::table('m_obj_def as df')
                ->join('m_obj_hierarchy as mh', 'df.obj_id', '=', 'mh.obj_id')
                ->select('mh.obj_id', 'mh.display_name', 'df.content', 'mh.route_path', 'mh.image_name')
                ->where('mh.parent_obj_id', $id)
                ->where('mh.displayable',1)
                ->orderBy('mh.display_order')
                ->get();
            return response()->json($getData);
        } else {
            return response()->json([
                'error' => 'Invalid or missing ID'
            ], 400); // 400 Bad Request
        }
        
    }
}
