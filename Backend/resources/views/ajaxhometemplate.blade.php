<div class="row d-flex align-items-stretch">
    <div class="col-12 col-lg-6 mb-3 " id="">
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
                        <input type="text" id="name" name="name" value="{{ $defdata->obj_name ?? '' }}" class="form-control">
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
                <form action="{{ $hierarchydata ? route('objhierarchy.update', ['id' => $hierarchydata->obj_id]) :  route('objhierarchy.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($hierarchydata)
                @method('PUT')
                @endif
                    <div class="mb-3">
                        <label for="objectId" class="form-label">Object Name <span class="star">*</span></label>
                        <select id="objectId" name="selectDropdown1" class="form-select select2">
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
                    </div>
                    <div class="mb-3">
                        <label for="parentObjectId" class="form-label">Parent Object Name <span class="star">*</span></label>
                        <select id="parentObjectId" name="selectDropdown2" class="form-select select2">
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
                    </div>
                    <div class="mb-3">
                        <label for="displayOrder" class="form-label">Display Order <span class="star">*</span></label>
                        <input type="text" id="displayorder" value="{{ old('displayorder', $hierarchydata->display_order ?? '') }}" placeholder="Enter Display Order" name="displayorder" class="form-control">
                        @error('displayorder')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="displayable" class="form-label">Displayable</label>
                        <input type="text" id="displayable" value="{{ old('displayable', $hierarchydata->displayable ?? '') }}" name="displayable" placeholder="Enter Displayable" class="form-control">
                        @error('displayable')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="displayname" class="form-label">Display Name <span class="star">*</span></label>
                        <input type="text" id="displayname" value="{{ $hierarchydata->display_name ?? '' }}" name="displayname" placeholder="Enter Display name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="routePath" class="form-label">Route Path <span class="star">*</span></label>
                        <input type="text" d="routepath"  value="{{ $hierarchydata->route_path ?? '' }}" name="routepath" placeholder="Enter Routepath" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="imageName" class="form-label">Image Name</label>
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