{{-- @extends('layouts.app')

@section('content') --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
                <link rel="stylesheet" href="/assets/css/my.css">

        <link rel="dns-prefetch" href="//fonts.bunny.net">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
        
        <!-- Include Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Include Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
    </head>
    @if(session('success'))
<div class="alert alert-success " style="position: fixed; top: 80px; right: 0;Z-index:1 !important">
  {{ session('success') }}
    </div>
@endif
<body class="section bg-cover">
    
    <div>
        <div class="container center-box" style="max-width:1140px;">
            <div class="row d-flex align-items-md-stretch justify-content-center">
                <div class="col-lg-3 col-md-4 login-box">
                    <div class="col-lg-12 login-form">
                        <div class="col-lg-12 login-form">
                            <img src="https://b-safeug.com/storage/images/1716275702.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 login-box">
                    <div class="login-form">
                        <div class=" login-title">
                            Admin Login
                        </div>
                        <div class="col-lg-12 ">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="col-md-12 form-group mt-3 mt-md-0  t-left">
                                    <label class="form-control-label">User Name</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"  id="email" placeholder="Email Address" required="" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            <br>
                                <div class="col-md-12 form-group t-left">
                                    <label class="form-control-label">Password</label>
                                    <input placeholder="Enter Password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" >
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 loginbttm">
                                    <div class="col-lg-6 login-btm login-text">
                                    <!-- Error Message -->
                                    </div>
                                    <br>
    
                                    <div class="col-lg-12 login-btm login-button">
                                        <button type="submit" class="btn btn-outline-primary uppercase" style="background: #1499d6;width: 100%;border: 0;padding: 10px 35px;color: #fff;transition: 0.4s;border-radius: 4px;
                                        font-weight: bold;letter-spacing: 1px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24); margin-top:10px;">{{ __('Login') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>          
                </div>
                            <div class="col-lg-3 col-md-4 login-box">
                                <div class="col-lg-12 login-form">
                                    <div class="col-lg-12 login-form">
                                        <img src="https://b-safeug.com/storage/images/1716017671.jpg" alt="">
                                    </div>
                                </div>       
                            </div>      
            </div>
        </div>
    </div>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function(){
    setTimeout(function() {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 2000);
  });
</script>
{{-- @endsection --}}
