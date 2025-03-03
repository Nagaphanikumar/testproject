@extends('layouts.app')
@section('content')
@if(session('success'))
<div class="alert alert-success " style="position: fixed; top: 80px; right: 0;Z-index:1 !important">
  {{ session('success') }}
    </div>
@endif
<div class=" mx-auto my-2 table-responsive" id="objhierarchy">
  <table class="table table-hover">
      <thead>
          <tr>
              <th class="px-2 py-3 font-weight-bold">S.No</th>
              <th class="px-2 py-3 ">Page Id</th>
              <th class="px-2 py-3 ">Access Token</th>
              <th class="px-2 py-3 font-weight-light">Action</th>
          </tr>
      </thead>
      @if(isset($data))
      <tbody>
          @php
            $access_token = $data->access_token;
            $shortenedmessage = substr($access_token, 0, 25);
          @endphp
        <tr>
          <td class="px-2 py-4">1</td>
          <td class="px-2 py-4">{{ $data->page_id }}</td>
          <td class="px-2 py-4" title="{{ $access_token }}">{{ $shortenedmessage }}...</td>
          <td class="px-2 py-4 d-flex">
            <a href="#" class="edit-btn" 
               data-id="{{ $data->id }}" 
               data-page-id="{{ $data->page_id }}" 
               data-access-token="{{ $access_token }}">
              <i class="fa fa-edit"></i>
            </a>
          </td>
        </tr>        
      </tbody>
      @endif
    </table>
</div>
<div class="container" id="ajaxobjdef" >
</div>  
@endsection
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="max-width:none !important;">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Facebook Settings</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="mb-3">
              <label for="pageId" class="form-label">Page ID</label>
              <input type="text" class="form-control" id="pageId" name="page_id" required>
              <input type="hidden" class="form-control" id="pagesl" name="id" >
            </div>
            <div class="mb-3">
              <label for="accessToken" class="form-label">Access Token</label>
              <textarea class="form-control" id="accessToken" name="access_token" rows="8" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary float-end">Save</button>
          </form>
        </div>
      </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
   

    $(document).ready(function(){
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 2000);
      });
      $(document).ready(function () {
    $('.edit-btn').on('click', function (e) {
      e.preventDefault();
      const slno = $(this).data('id');
      const pageId = $(this).data('page-id');
      const accessToken = $(this).data('access-token');

      $('#pageId').val(pageId);
      $('#accessToken').val(accessToken);
      $('#pagesl').val(slno);
      $('#editModal').modal('show');
    });

    $('#editForm').on('submit', function (e) {
      e.preventDefault();
      const formData = $(this).serialize();
    $.ajax({
        url: '/update-facebookfeed-data', 
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            alert(response.success); 
            $('#editModal').modal('hide'); 
            location.reload(); 
        }
    });
    });
  });
</script>