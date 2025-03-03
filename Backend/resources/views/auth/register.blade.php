@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center md:my-10">
        <div
            class="flex flex-col justify-center items-center md:flex-row shadow-lg rounded-xl max-w-7xl w-[90%] h-[690px] md:h-[480px] m-2 mt-12 md:mt-16">
            <div class="h-[100%] w-full md:w-3/4  bg-center  bg-cover rounded-lg"
                style="background-image: url('{{ asset('http://127.0.0.1:8000/storage/images/1695805361.png') }}')">
            </div>
            <div class="h-[90%] w-full md:w-3/4">
                <div class="text-xl cursor-pointer flex flex-col justify-center items-center mt-5 md:mt-0">
                    <h1 class="font-semibold text-gray-600">{{ __('Register') }}</h1>
                </div>
                
                <div class="flex flex-col justify-center items-center mt-3 md:mt-5 space-y-6 md:space-y-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input id="name" type="text" placeholder="Name" class="form-control @error('name') is-invalid @enderror bg-gray-100 rounded-lg px-3 py-2 focus:border border-blue-600 focus:outline-none text-black placeholder:text-gray-600 placeholder:opacity-50 font-semibold md:w-72 lg:w-[340px]" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror bg-gray-100 rounded-lg px-3 py-2 focus:border border-blue-600 focus:outline-none text-black placeholder:text-gray-600 placeholder:opacity-50 font-semibold md:w-72 lg:w-[340px]" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror bg-gray-100 rounded-lg px-3 py-2 focus:border border-blue-600 focus:outline-none text-black placeholder:text-gray-600 placeholder:opacity-50 font-semibold md:w-72 lg:w-[340px]" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control bg-gray-100 rounded-lg px-3 py-2 focus:border border-blue-600 focus:outline-none text-black placeholder:text-gray-600 placeholder:opacity-50 font-semibold md:w-72 lg:w-[340px]" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="text-center my-4">
                                <button type="submit" class="uppercase px-24 md:px-[118px] lg:px-[140px] py-2 rounded-md text-white bbg-color bg-[#0088ff] hover:bg-[#0088ff]  font-medium">
                                    {{ __('Signup') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
