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
              <th class="px-2 py-3 ">First Name</th>
              <th class="px-2 py-3 ">Last Name</th>
              <th class="px-2 py-3 ">Email</th>
              <th class="px-2 py-3 ">Query</th>
              <th class="px-2 py-3 ">Message</th>
              <th class="px-2 py-3 font-weight-light">Action</th>
          </tr>
      </thead>
      <tbody>
          @foreach ($contact as $key => $contacts)
          @php
            $message = $contacts->message;
            $shortenedmessage = substr($message, 0, 25);
          @endphp
        <tr>
          <td class="px-2 py-4">{{ $key + 1 }}</td>
          <td class="px-2 py-4">{{ $contacts->firstname }}</td>
          <td class="px-2 py-4">{{ $contacts->lastname }}</td>
          <td class="px-2 py-4">{{ $contacts->email }}</td>
          <td class="px-2 py-4">{{ $contacts->feedback }}</td>
          <td class="px-2 py-4" title="{{ $message }}">{{ $shortenedmessage }}</td>
          <td class="px-2 py-4 d-flex">
              <a href="/contactedit/{{$contacts->id }}}"  class=" ">
                <i class="fa fa-edit"></i>
              </a>
              <a href="/contactus/{{$contacts->id }}" id="{{ $contacts->name }}" class="deleteform">
                <i class="fas fa-trash-alt text-danger" ></i>
            </a>
          </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
</div>
<div class="container" id="ajaxobjdef" >
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
      $('.deleteform').click(function(event) {
          event.preventDefault();

          var confirmed = confirm('Are you sure you want to delete?');
          if (confirmed) {
              window.location.href = $(this).attr('href');
          }
      });
    });

    $(document).ready(function(){
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 2000);
      });

</script>