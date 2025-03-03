<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MObjType extends Model
{
    // use HasFactory;
    protected $table = 'm_obj_type';
    protected $fillable = ['obj_type_id', 'obj_type_name', 'obj_type_desc','created_by'];


    protected $primaryKey = 'obj_type_id';

    public function objDefs() {
        return $this->hasMany(MObjDef::class, 'obj_type_id', 'obj_type_id');
    }
}
