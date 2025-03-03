
<!doctype html>
<html>

    <body>
        <div class="row d-flex align-items-stretch" data-objId="{{$obj_id}}">
            <div class="col-12 col-lg-6 mb-3 " >
                <div class="card shadow ">
                    <div class="card-body">
                        @if ($defdata)
                        <h6 class="text-lg mb-3 font-medium">Edit Object Definition</h6>
                        @else
                        <h6 class="text-lg mb-3 font-medium">Add Object Definition</h6>
                        @endif
                        <form action="{{ $defdata ? route('objDef.update', ['id' => $defdata->obj_id]) : route('objDef.store') }}" method="POST" id="obj-dif" data-id="{{$obj_id}}" >
                            @csrf
                            @if ($defdata)
                            @method('PUT')
                            @endif
                            <div class="mb-3" style="display: none">
                                <label for="objectType" class="form-label">Object Type</label>
                                <select id="objectType" name="selectDropdown" class="form-select">
                                    <option value="">Select</option>
                                        @foreach($objectTypes as $objectType)
                                    <option value="{{ $objectType->obj_type_id }}" {{ $objectType->obj_type_id == $selectedValue ? 'selected' : '' }}>
                                        {{ $objectType->obj_type_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <input id="obj-type-id" type="hidden" name="selectDropdown" value="0">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" value="{{ $defdata->obj_name ?? '' }}" class="form-control" >
                            </div>
                            <div class="my-4">
                                <label for="editor" class=" text-sm ">Content</label>
                                <div id="editor" name="editor" style="height: 310px;"></div>
                                <input type="hidden" class="editorContent{{$obj_id}}" id="editorContent" name="editorContent" value="{{ $defdata->content ?? '' }}">
                            </div>             
                            <div class="text-end mb-4">
                                @if ($defdata)
                                <button type="submit" class="save mt-1">Update</button>
                                @else
                                <button type="submit" class="save mt-1">Save</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
                <div class="col-12 col-lg-6 " >
                    <div class="card shadow ">
                        <div class="card-body">
                            @if ($hierarchydata)
                            <h6 class="text-lg mb-3 font-medium">Edit Object Component</h6>
                            @else
                            <h6 class="text-lg mb-3 font-medium">Add Object Component</h6>
                            @endif
                                <form action="{{ $hierarchydata ? route('objhierarchy.update', ['id' => $hierarchydata->obj_id]) :  route('objhierarchy.store') }}" method="POST" enctype="multipart/form-data" id="obj-hierarchy">
                                            @csrf
                                            @if ($hierarchydata)
                                            @method('PUT')
                                            @endif
                                            <div class="mb-3">
                                                <label for="objectId" class="form-label">Object Name</label>
                                                <select id="objectId" name="selectDropdown1" class="form-select select2" disabled>
                                                    <option value="">Select</option>
                                                    @foreach($objectdef as $objectType)
                                                    <option value="{{ $objectType->obj_id }}" {{ $objectType->obj_id == old('selectDropdown1', $tmpobj_id) ? 'selected' : '' }} >
                                                        {{ $objectType->obj_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="selectDropdown1" name="selectDropdown1" value="{{ old('selectDropdown1', $tmpobj_id) }}">

                                                @error('selectDropdown1')
                                                <span class="text-danger text-sm" >{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="parentObjectId" class="form-label">Parent Object Name</label>
                                                <select id="parentObjectId" name="selectDropdown2" class="form-select select2" disabled>
                                                <option value="">Select</option>
                                                    @foreach($objectdef as $objectType)
                                                    <option value="{{ $objectType->obj_id }}" {{ $objectType->obj_id == old('selectDropdown2', $parent_obj_id) ? 'selected' : '' }}>
                                                        {{ $objectType->obj_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" id="selectDropdown2" name="selectDropdown2" value="{{ old('selectDropdown2', $parent_obj_id) }}">

                                                @error('selectDropdown2')
                                                <span class="text-danger text-sm">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        @if($hierarchydata->parent_obj_id == 6)
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Brand Name</label>
                                                <select id="brand" name="brand" class="form-select select2" >
                                                <option value="">Select</option>
                                                    @foreach($brands as $brand)
                                                    <option value="{{ $brand->obj_id }}" {{ $brand->obj_id == old('brand', $hierarchydata->brand) ? 'selected' : '' }}>
                                                        {{ $brand->display_name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                            <div class="mb-3">
                                                <label for="displayOrder" class="form-label">Display Order <span class="star">*</span></label>
                                                <input type="text" id="displayorder" value="{{ old('displayorder', $hierarchydata->display_order ?? '') }}" placeholder="Enter Display Order" name="displayorder" class="form-control" required>
                                                @error('displayorder')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="displayable" class="form-label">Displayable</label>
                                                <select class="form-select" name="displayable" required>
                                                    <option value="">Select</option>
                                                    <option value="1" {{ $hierarchydata->displayable == 1 ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ $hierarchydata->displayable == 0 ? 'selected' : '' }}>No</option>
                                                </select>                                                @error('displayable')
                                                <span class="text-red-500 text-xs">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="displayname" class="form-label">Display Name <span class="star">*</span></label>
                                                <input type="text" id="displayname" value="{{ $hierarchydata->display_name ?? '' }}" name="displayname" placeholder="Enter Display name" class="form-control" required>
                                            </div>

                                            @if($hierarchydata->parent_obj_id == 2 || $hierarchydata->parent_obj_id == 6 || $hierarchydata->parent_obj_id == 24 || $hierarchydata->parent_obj_id == 119 || $seoDisplayFlag)
                                                <div class="mb-3">
                                                    <label for="seo_title" class="form-label">Seo Title</label>
                                                    <input type="text" id="seo_title" name="seo_title" value="{{ $hierarchydata->seo_title ?? '' }}"  placeholder="Enter Seo title" class="form-control" >
                                                </div>

                                                <div class="mb-3">
                                                    <label for="seo_description" class="form-label">Seo Description</label>
                                                    <textarea rows="4"  id="seo_description"  name="seo_description" placeholder="Enter Seo Description" class="form-control">{{ $hierarchydata->seo_description ?? '' }}</textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="seo_keywords" class="form-label">Seo Keywords<i class="fa fa-info-circle mx-1" title="Use comma(,) as separator ex: keyword1,keyword2 etc." aria-hidden="true"></i></label>
                                                    <textarea rows="4" id="seo_keywords"  name="seo_keywords"  placeholder="Enter Seo Keywords" class="form-control">{{ $hierarchydata->seo_keywords ?? '' }}</textarea>
                                                </div>
                                            @endif

                                            <div class="mb-3">
                                                <label for="iconcode" class="form-label">Icon Code</label>
                                                <input type="text" id="iconcode" value="{{ $hierarchydata->icon_code ?? '' }}" name="iconcode" placeholder="Enter icon code" class="form-control" >
                                            </div>
                                    <div class="mb-3">
                                        <label for="routePath" class="form-label">Route Path <span class="star">*</span></label>
                                        <input type="text" id="routepath"  value="{{ $hierarchydata->route_path ?? '' }}" name="routepath" placeholder="Enter Routepath" class="form-control" required>
                                    </div>

                                  @if($hierarchydata->parent_obj_id == 24)
                                    <div class="mb-3">
                                        <label for="backgroundimg" class="form-label">Background Image</label>
                                        <div class="inner-image">
                                        @if ($hierarchydata->background_image)
                                            {{-- Check if the file is an image --}}
                                                <div class="inner-image" id="close-link-bg">
                                                    <a class="del-link-bg" href="/bgimage/{{ $hierarchydata->obj_id }}">
                                                        <span class="close-button cl-btn" id="closeModalButton">&times;</span>
                                                    </a>
                                                    <img id="img-bg-show" src="{{ asset($hierarchydata->background_image) }}" class="img img-fluid mb-3" alt="Current Image">
                                                </div>
                                        @endif


                                            <input type="file" id="backgroundimg" name="backgroundimg" class="form-control">
                                        </div>
                                    </div>
                                   @endif


                                    <div class="mb-3">
                                        <label for="imageName" class="form-label">Image</label>
                                        <div class="inner-image">
                                        {{-- @if (optional($hierarchydata)->image_name)
                                        
                                            <a href="/image/{{ $hierarchydata->obj_id }}">
                                                <span class="close-button cl-btn" id="closeModalButton">&times;</span>
                                            </a>
                                            <img src="{{ asset($hierarchydata->image_name) }}" class="img img-fluid mb-3" alt="Current Image">
                                        @endif --}}
                                        @if (optional($hierarchydata)->image_name)
                                            {{-- Check if the file is an image --}}
                                            @if (in_array(pathinfo($hierarchydata->image_name, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <div class="inner-image" id="close-link">
                                                    <a class="del-link" href="/image/{{ $hierarchydata->obj_id }}">
                                                        <span class="close-button cl-btn" id="closeModalButton">&times;</span>
                                                    </a>
                                                    <img id="img-show" src="{{ asset($hierarchydata->image_name) }}" class="img img-fluid mb-3" alt="Current Image">
                                                </div>
                                                <a href="{{ $hierarchydata->image_name }}" target="_blank" id="pdf-link" style="display: none;">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/136/136522.png" class="img img-fluid mb-3" alt="PDF Icon" id="pdf-show">
                                                </a>
                                            @elseif (in_array(pathinfo($hierarchydata->image_name, PATHINFO_EXTENSION), ['pdf']))
                                                {{-- Display link for viewing PDF --}}
                                                {{-- <a href="{{ $hierarchydata->image_name }}" target="_blank">
                                                    View PDF
                                                </a> --}}
                                                <a href="{{ $hierarchydata->image_name }}" target="_blank" id="pdf-link">
                                                    <img src="https://cdn-icons-png.flaticon.com/128/136/136522.png" class="img img-fluid mb-3" alt="PDF Icon" id="pdf-show">
                                                </a>
                                                <div class="inner-image" id="close-link" style="display: none;">
                                                    <a class="del-link" href="/image/{{ $hierarchydata->obj_id }}">
                                                        <span class="close-button cl-btn" id="closeModalButton">&times;</span>
                                                    </a>
                                                    <img id="img-show" src="{{ asset($hierarchydata->image_name) }}" class="img img-fluid mb-3" alt="Current Image">
                                                </div>
                                            @endif
                                        @else
                                            <div class="inner-image" id="close-link" style="display: none">
                                                <a class="del-link" href="/image/{{ $hierarchydata->obj_id }}">
                                                    <span class="close-button cl-btn" id="closeModalButton">&times;</span>
                                                </a>
                                                <img id="img-show" src="" class="img img-fluid mb-3" alt="Current Image">
                                            </div>
                                            <a href="" target="_blank" id="pdf-link" style="display: none">
                                                <img src="https://cdn-icons-png.flaticon.com/128/136/136522.png" class="img img-fluid mb-3" alt="PDF Icon" id="pdf-show">
                                            </a>
                                        @endif


                                            <input type="file" id="imagename" name="imagename" class="form-control">
                                        </div>
                                    </div>    
                                        <div class="text-end mt-2">
                                            @if ($hierarchydata)
                                            <button type="submit" class="save">Update</button>
                                            @else
                                            <button type="submit" class="save">Save</button>
                                            @endif
                                        </div>
                                </form>
                        </div>
                    </div>
                </div>
         </div> 
           
    <script>
    $(document).ready(function() {
        $('.select2').select2();
    });

   

     
        $(document).ready(function() {
            // var quill = new Quill('#editor', {
            //     theme: 'snow',
            //     modules: {
            //         toolbar: [
            //             [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
            //             ['bold', 'italic', 'underline', 'strike'],
            //             [{'list': 'ordered'}, {'list': 'bullet'}],
            //             ['link', 'image', 'blockquote', 'code-block'],
            //             [{ 'align': [] }],
            //             ['clean'],
            //         ]
            //     },
            //     readOnly: false
            // });
            var quill = new Quill('#editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'font': [] }, { 'size': [] }],
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'align': [] }],
                        [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean'],
                        [{ 'indent': '-1' }, { 'indent': '+1' }], // indent
                    ]
                }
            });
            var initialContent = $('#editorContent').val();
            quill.clipboard.dangerouslyPasteHTML(initialContent);

            quill.on('text-change', function() {
                var content = quill.root.innerHTML;
                $('#editorContent').val(content);
            });
        });
        $(document).ready(function(){
            $('.select2').select2(); 

            $('.delimage').click(function(event){
                event.preventDefault();
                var id = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url: '/image/' + id,
                    success: function(response) {
                        $('.editimg').hide();
                        $('#closeimage').hide();
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });

            });  
            
            
            $('.deleteform').click(function(event) {
                event.preventDefault();
                var confirmed = confirm('Are you sure you want to delete ?');
                if (confirmed) {
                  window.location.href = $(this).attr('href');
                }
            });

            

        });

        $(document).ready(function(){
           
            // $('#obj-dif, #obj-hierarchy').submit(function (e) {
                $(document).on('submit', '#obj-dif, #obj-hierarchy', function (e) { 

                e.preventDefault();
                var formData = new FormData(this);
                var formId = $(this).attr('id');
                var dataId = $(this).data('id');
                var content = $('#editorContent').hasClass('editorContent'+dataId);
                if(content){
                    var inputValue = $('.editorContent'+dataId).val();
                    var inputLength = inputValue.length;
                    if(inputLength < 1){
                        return;
                    }
                }
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.success) {
                            if (formId === 'obj-dif') {
                                handleResponse(response.data, 'obj-dif');
                            } else if (formId === 'obj-hierarchy') {
                                console.log(response.data);
                                handleResponse(response.data, 'obj-hierarchy');
                            }
                            // alert('Data updated successfully for "' + formId + '" form!');
                            showToast(response.message, 'success');
                        } else {
                            // Handle error response
                            // alert('Error: ' + response.message);
                            showToast('Error: ' + response.message, 'danger');
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            });

            function handleResponse(data, formId) {
                var imgExtension = ['jpg', 'jpeg', 'png', 'gif'];
                if (formId === 'obj-dif') {
                    $('#' + formId + ' #name').val(data.obj_name);
                    $('#' + formId + ' #editorContent').val(data.content);
                    $('#' + formId + ' #obj-type-id').val(data.obj_type_id);
                } else if (formId === 'obj-hierarchy') {
                    $('#' + formId + ' #selectDropdown1').val(data.obj_id);
                    $('#' + formId + ' #selectDropdown2').val(data.parent_obj_id);
                    $('#' + formId + ' #displayorder').val(data.display_order);
                    $('#' + formId + ' #displayable').val(data.displayable);
                    $('#' + formId + ' #displayname').val(data.display_name);
                    $('#' + formId + ' #routepath').val(data.route_path);
                    if(imgExtension.includes(getExtension(data.image_name))){
                        $('#' + formId + ' #img-show').attr('src',data.image_name);
                        

                        if ($('#' + formId + ' #img-show').length < 2 || $('#' + formId + ' #close-link').length < 2) {
                            // $('#' + formId + ' #img-show').show();
                            $('#' + formId + ' #pdf-link').hide();
                            $('#' + formId + ' #close-link').show();
                        }
                    }else if(getExtension(data.image_name) == 'pdf'){
                        $('#' + formId + ' #pdf-link').attr('href',data.image_name);
                        // $('#' + formId + ' #pdf-show').attr('src',data.image_name);

                        if($('#' + formId + ' #pdf-link').length < 2) {
                            $('#' + formId + ' #close-link').hide();
                            $('#' + formId + ' #pdf-link').show();
                        }
                    }
                    if(data.parent_obj_id == 24){
                        $('#' + formId + ' #img-bg-show').attr('src',data.background_image);
                        $('#' + formId + ' #close-link-bg').css('display', 'block');
                    }
                    $('#' + formId + ' #imagename').val('');
                }
            }
            function getExtension(filename) {
                if(filename !== null && filename !== ''){
                    return filename.split('.').pop();
                }
            }
            function showToast(message, messageType) {
                // Use your existing Blade template to display the toast
                var alertClass = messageType === 'success' ? 'alert-success' : 'alert-danger';
                var toastDiv = $('<div class="alert ' + alertClass + ' " style="position: fixed; top: 80px; right: 0; z-index: 1 !important">');
                toastDiv.text(message);
                $('body').append(toastDiv);

                // Auto-hide the toast after a few seconds
                setTimeout(function () {
                    toastDiv.fadeOut('slow', function () {
                        $(this).remove();
                    });
                }, 5000);
            }

            $('.del-link').click(function(event) {
                event.preventDefault();
                var href = $(this).attr('href');
                var confirmed = confirm('Are you sure you want to delete');
                if(confirmed){
                    $.ajax({
                        type: 'GET',
                        url: href,
                        success: function (response) {
                            if(response.success){
                                showToast(response.message, 'success');
                                $('#close-link').closest('.inner-image').hide();
                                // $('#close-link').closest('.inner-image').hide();
                            }else{
                                showToast('Error: ' + response.message, 'danger');
                            }
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });

            $('.del-link-bg').click(function(event) {
                event.preventDefault();
                var href = $(this).attr('href');
                var confirmed = confirm('Are you sure you want to delete');
                if(confirmed){
                    $.ajax({
                        type: 'GET',
                        url: href,
                        success: function (response) {
                            if(response.success){
                                showToast(response.message, 'success');

                                $('#close-link-bg').hide();
                                // $('#close-link').closest('.inner-image').hide();
                            }else{
                                showToast('Error: ' + response.message, 'danger');
                            }
                        },
                        error: function (error) {
                            console.error('Error:', error);
                        }
                    });
                }
            });
        });
       
      
                
    </script>
 </body>

</html>

