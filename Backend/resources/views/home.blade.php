@extends('layouts.app')
@section('content')
@if(session('success'))
<div class="alert alert-success " style="position: fixed; top: 80px; right: 0;Z-index:1 !important">
  {{ session('success') }}
    </div>
@endif

@if(session('error'))
<div class="alert alert-danger " style="position: fixed; top: 80px; right: 0;Z-index:1 !important">
  {{ session('error') }}
    </div>
@endif
   
   
    <body class="my-bg">
            <div class="container-fluid d-flex px-0">
                
                <div class="col-sm-12 col-md-12 d-flex justify-content-center">
                    <nav class="navbar navbar-default">
                        <div class="container-xxl mx-auto">
                            
                            <div class="container-xxl mx-auto d-flex sm-px-0">
                                
                                <div class="row d-flex align-items-stretch" id="ajaxobjdef">
                                    <div class="col-12 col-lg-6 mb-3 " id="
                                    ">
                                        <div class="card shadow ">
                                            <div class="card-body">
                                                @if ($defdata)
                                                <h6 class="text-lg mb-3 font-medium" style="font-weight:bold">Add Object Definition</h2>
                                                @else
                                                <h6 class="text-lg mb-3 font-medium" >Add Object Definition</h6>
                                                @endif
                                                <form action="{{ $defdata ? route('objDef.update', ['id' => $defdata->obj_id]) : route('objDef.store') }}" method="POST" >
                                                    @csrf
                                                    @if ($defdata)
                                                    @method('PUT')
                                                    @endif
                                                    <div class="mb-3" style="display :none">
                                                        <label for="objectType" class="form-label">Object Type</label>
                                                        <select id="objectType" name="selectDropdown" class="form-select select2">
                                                            <option value="">Select</option>
                                                                @foreach($objectTypes as $objectType)
                                                            <option value="{{ $objectType->obj_type_id }}" {{ $objectType->obj_type_id == $selectedValue ? 'selected' : '' }}>
                                                                {{ $objectType->obj_type_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="selectDropdown" value="0">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Name <span class="star">*</span></label>
                                                        <input type="text" id="name" name="name" value="{{ $defdata->obj_name ?? '' }}" class="form-control" required>
                                                    </div>
                                                    <!-- <div class="mb-3">
                                                        <div class="form-group">
                                                            <label for="editor" class="leading-7 text-sm text-gray-600">Content</label>
                                                            <div id="editor" name="editor" style="height: 200px;"></div>
                                                            <input type="hidden" id="editorContent" name="editorContent" value="{{ $defdata->content ?? '' }}">
                                                        </div>
                                                    </div> -->
                                                    <div class="my-4">
                                                        <label for="editor" class=" text-sm ">Content</label>
                                                        <div id="editor" name="editor" style="height: 310px;"></div>
                                                        <input type="hidden" id="editorContent" name="editorContent" value="{{ $defdata->content ?? '' }}">
                                                    </div>             
                                                    <div class="text-end mb-4">
                                                        @if ($defdata)
                                                        <button class="save mt-1">Update</button>
                                                        @else
                                                        <button class="save mt-1">Save</button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6 " id="objhierarchy">
                                        <div class="card shadow ">
                                            <div class="card-body">
                                                @if ($hierarchydata)
                                                <h6 class="text-lg mb-3 font-medium">Edit Object Component</h6>
                                                @else
                                                <h6 class="text-lg mb-3 font-medium">Add Object Component</h6>
                                                @endif
                                                <form onsubmit="return validateForm();" action="{{ $hierarchydata ? route('objhierarchy.update', ['id' => $hierarchydata->obj_id]) :  route('objhierarchy.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @if ($hierarchydata)
                                                @method('PUT')
                                                @endif
                                                    <div class="mb-3">
                                                        <label for="objectId" class="form-label">Object Name <span class="star">*</span></label>
                                                        <select id="objectId" name="selectDropdown1" class="form-select select2" required>
                                                            <option value="">Select</option>
                                                            @foreach($objectdef as $objectType)
                                                            <option value="{{ $objectType->obj_id }}" {{ $objectType->obj_id == old('selectDropdown1', $tmpobj_id) ? 'selected' : '' }}>
                                                                {{ $objectType->obj_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('selectDropdown1')
                                                        <span class="text-danger text-sm" >{{ $message }}</span>
                                                        @enderror
                                                        <div id="objectNameError" class="text-danger text-sm"></div>

                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="parentObjectId" class="form-label">Parent Object Name <span class="star">*</span></label>
                                                        <select id="parentObjectId" name="selectDropdown2" class="form-select select2" required>
                                                        <option value="">Select</option>
                                                            @foreach($objectdef as $objectType)
                                                            <option value="{{ $objectType->obj_id }}" {{ $objectType->obj_id == old('selectDropdown2', $parent_obj_id) ? 'selected' : '' }}>
                                                                {{ $objectType->obj_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        @error('selectDropdown2')
                                                        <span class="text-danger text-sm">{{ $message }}</span>
                                                        @enderror
                                                        <div id="parentObjectNameError" class="text-danger text-sm"></div>

                                                    </div>

                                                    <div class="mb-3" id="brand-container">
                                                        <label for="brand" class="form-label">Brand Name</label>
                                                        <select id="brand" name="brand" class="form-select select2" >
                                                        <option value="">Select</option>
                                                            @foreach($brands as $brand)
                                                            <option value="{{ $brand->obj_id }}">
                                                                {{ $brand->display_name }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="displayOrder" class="form-label">Display Order <span class="star">*</span></label>
                                                        <input type="text" id="displayorder" value="{{ old('displayorder', $hierarchydata->display_order ?? '') }}" placeholder="Enter Display Order" name="displayorder" class="form-control" required>
                                                        @error('displayorder')
                                                        <span class="text-danger text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="displayable" class="form-label">Displayable</label>
                                                        {{-- <input type="text" id="displayable" value="{{ old('displayable', $hierarchydata->displayable ?? '') }}" name="displayable" placeholder="Enter Displayable" class="form-control" > --}}
                                                        <select class="form-select" name="displayable"  required>
                                                            {{-- <option value="">Select</option> --}}
                                                            <option value="1" selected>Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                        @error('displayable')
                                                        <span class="text-danger text-xs">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="displayname" class="form-label">Display Name <span class="star">*</span></label>
                                                        <input type="text" id="displayname" value="{{ $hierarchydata->display_name ?? '' }}" name="displayname" placeholder="Enter Display name" class="form-control" required>
                                                        @error('displayname')
                                                        <span class="text-danger text-sm" >{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div id="seoContainer">
                                                        <div class="mb-3">
                                                            <label for="seo_title" class="form-label">Seo Title</label>
                                                            <input type="text" id="seo_title" name="seo_title" placeholder="Enter Seo title" class="form-control" >
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="seo_description" class="form-label">Seo Description</label>
                                                            <textarea rows="4"  id="seo_description"  name="seo_description" placeholder="Enter Seo Description" class="form-control"></textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="seo_keywords" class="form-label">Seo Keywords<i class="fa fa-info-circle mx-1" title="Use comma(,) as separator ex: keyword1,keyword2 etc." aria-hidden="true"></i></label>
                                                            <textarea rows="4" id="seo_keywords"  name="seo_keywords" placeholder="Enter Seo Keywords" class="form-control"></textarea>
                                                        </div>
                                                    </div>    
                                                    <div class="mb-3">
                                                        <label for="iconcode" class="form-label">Icon code</label>
                                                        <input type="text" id="iconcode"  value="" name="iconcode" placeholder="Enter icon code" class="form-control" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="routePath" class="form-label">Route Path <span class="star">*</span></label>
                                                        <input type="text" d="routepath"  value="{{ $hierarchydata->route_path ?? '' }}" name="routepath" placeholder="Enter Routepath" class="form-control" required>
                                                        @error('routepath')
                                                        <span class="text-danger text-sm" >{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="mb-3" id="backgroundContainer">
                                                        <label for="imageName" class="form-label">Backgound Image</label>
                                                        <input type="file" id="backgroundimg" name="backgroundimg" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="imageName" class="form-label">Image</label>
                                                        @if (optional($hierarchydata)->image_name)
                                                                        <div>
                                                                            <a class="del-link" href="/image/{{ $hierarchydata->obj_id }}">
                                                                                <span class="close-button" id="closeModalButton">&times;</span>
                                                                            </a>
                                                                            <img src="{{ asset($hierarchydata->image_name) }}" class="img" alt="Current Image">
                                                                            @endif
                                                        <input type="file" id="imagename" name="imagename" class="form-control">
                                                    </div>
                                                    <div class="text-end">
                                                        @if ($hierarchydata)
                                                        <button class="save">Update</button>
                                                        @else
                                                        <button class="save">Save</button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
     
    </body>
    <script>
        function validateForm() {
        var objectName = document.getElementById('objectId').value;
        var parentObjectName = document.getElementById('parentObjectId').value;

        if (objectName === parentObjectName) {
            var errorMessage = "Objectname and Parent Object name cannot be the same.";
            
            // Display error message for Object Name
            document.getElementById('objectNameError').innerHTML = errorMessage;

            // Display error message for Parent Object Name
            document.getElementById('parentObjectNameError').innerHTML = errorMessage;

            return false;
        }

        // Clear error messages if there are no issues
        document.getElementById('objectNameError').innerHTML = '';
        document.getElementById('parentObjectNameError').innerHTML = '';

        return true;
    }
        $(document).ready(function(){
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 2000);
        });

        $(document).ready(function () {
            $('#brand-container').hide();
            $('#seoContainer').hide();
            $('#backgroundContainer').hide();
            $('#parentObjectId').change(function () {
                var selectedValue = $(this).val();
                if (selectedValue == 6) {
                    $('#brand-container').show();
                } else {
                    $('#brand-container').hide();
                }

                if (selectedValue == 24) {
                    $('#backgroundContainer').show();
                } else {
                    $('#backgroundContainer').hide();
                }

                if (selectedValue == 2 || selectedValue == 6 || selectedValue == 24 || selectedValue == 119) {
                    $('#seoContainer').show();
                } else {
                    $.ajax({
                        url: '/check-data', 
                        method: 'POST',
                        data: {
                            selectedValue: selectedValue,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if(response){
                                $('#seoContainer').show();
                            }else{
                                $('#seoContainer').hide();
                            }
                        }
                  });
                }
            });
       });

</script>
@endsection

