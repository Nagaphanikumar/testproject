<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MObjHierarchy extends Model
{
    // use HasFactory;
    protected $table = 'm_obj_hierarchy';
    protected $fillable = [
        'obj_id', 'parent_obj_id', 'display_order', 'displayable','display_name','route_path', 'image_name', 'created_by','updated_by','cost','icon_code','brand','seo_title','seo_description','seo_keywords','background_image'
    ];
    protected $primaryKey = 'obj_hierarchy_id';

    public function objDef() {
        return $this->belongsTo(MObjDef::class, 'obj_id', 'obj_id');
    }
}
