<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MObjDef extends Model
{

    
    // use HasFactory;
    protected $table = 'm_obj_def';
    protected $fillable = ['obj_id','obj_type_id', 'obj_name', 'content','image_name','created_by','updated_by'];
    protected $primaryKey = 'obj_id';

    public function objType() {
        return $this->belongsTo(MObjType::class, 'obj_type_id', 'obj_type_id');
    }

    public function objHierarchy() {
        return $this->hasOne(MObjHierarchy::class, 'obj_id', 'obj_id');
    }
}
