@extends('layouts.app')
@section('content')
@if(session('success'))
<div class="alert alert-success " style="position: fixed; top: 80px; right: 0;Z-index:1 !important">
  {{ session('success') }}
    </div>
@endif
<div class="container mt-5" id="objhierarchy">
    <form action="/contactupdate/{{$result->id}}" method="put" role="form" class="php-email-form">
        @csrf
        @method('PUT')
        <div class="form-group mt-2">
        <label for="firstName">First Name</label>
        <input type="text" class="form-control" name="firstname" value="{{$result->firstname}}" placeholder="Enter First Name" required>
      </div>
      <div class="form-group mt-2">
        <label for="lastName">Last Name</label>
        <input type="text" class="form-control" name="lastname" value="{{$result->lastname}}" placeholder="Enter Last Name" required>
      </div>
      <div class="form-group mt-2">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" value="{{$result->email}}" placeholder="Enter email" required>
      </div>
      <div class="form-group mt-2">
        <label for="phone">Phone Number</label>
        <input type="number" class="form-control" name="phone" value="{{$result->phone}}" placeholder="Enter Phone Number" required>
      </div>
      <div class="form-group mt-2">
        <select class="form-select" name="query" aria-label="Default select example" required>
            <option <?php echo ($result->feedback == 'Select') ? 'selected' : ''; ?>>Select</option>
            <option <?php echo ($result->feedback == 'Sales Query') ? 'selected' : ''; ?> value="Sales Query">Sales Query</option>
            <option <?php echo ($result->feedback == 'Complaints') ? 'selected' : ''; ?> value="Complaints">Complaints</option>
            <option <?php echo ($result->feedback == 'feedback') ? 'selected' : ''; ?> value="feedback">Feedback</option>
            <option <?php echo ($result->feedback == 'Others') ? 'selected' : ''; ?> value="Others">Others</option>
        </select>
    </div>
    
      <div class="form-group mt-3">
        <textarea class="form-control" name="message" rows="7" placeholder="Message" required="">{{$result->message}}</textarea>
      </div>
      <button type="submit" class="btn btn-success float-end mt-2">Update</button>
    </form>
  </div>
  <div class="container" id="ajaxobjdef" >
  </div>
  <script>
       $(document).ready(function(){
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 2000);
      });

  </script>
@endsection