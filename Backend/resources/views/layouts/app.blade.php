<?php
use App\Http\Controllers\ObjDefController;
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
                <link rel="stylesheet" href="/assets/css/my.css">
                <title>B-Safe</title>
        <link href="assets/css/style.css" rel="stylesheet">
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
        <!-- Favicons -->
        <link href="/assets/img/bsafe_fav.png" rel="icon">
        <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        {{-- @vite(['resources/sass/app.scss']) --}}

        
    </head>
    <body>
        <div id="app">
          @auth
          <nav class="navbar navbar-expand-md d-flex justify-content-between  align-items-center py-2 shadow-sm px-5 main-nav" style="background: #fff !important;">
            <div class="container-fluid">
                @if(auth()->user()->role == 'admin')
                <a class="navbar-brand col-2" href="/admin" >
                      <img class="" src="https://b-safeug.com/storage/images/1716275702.png" style="width:100px;">
                </a>
                @else
                <a class="navbar-brand col-2"  href="/admin">
                    <img class="" src="https://b-safeug.com/storage/images/1716275702.png" style="width:100px;">
                </a>
                @endif
               
               
              <ul class="navbar-nav ms-auto my-ul">
                    <!-- Authentication Links -->
                    <div class="d-flex align-items-center">
                     
                      @guest
                      @if (Route::has('login'))
                      {{-- <li class="nav-item mx-6">
                          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                      </li> --}}
                      @endif
                      @if (Route::has('register'))
                      {{-- <li class="nav-item mx-2">
                          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                      </li> --}}
                      @endif
                      @else
                     
                    </div>
                    
                    <li class="nav-item dropdown d-flex align-items-center">
                        {{-- <a class=""  href="/admin">
                            <img class="" src="https://b-safeug.com/storage/images/1716017671.jpg" style="width:120px;">
                        </a> --}}
                        <a id="navbarDropdown" class="p-1 rounded-2 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('profile.edit')}}">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                       
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
              </ul>
        </div>
    </nav>
        @endauth
       <?php
        $obj1 = new ObjDefController;
        $mainresponse[] = [
            'name' => 'name',
            'id'   => 0,
            'Hierarchy' => $obj1->getHierarchyAsJson(1, true)
        ];

        $mainresponse1[] = [
            'name' => 'Header',
            'id'   => 0,
            // 'Hierarchy' => $obj1->getHierarchyAsJson(1, true)
        ];
       ?> 
    <div class="row mx-auto mainrow mt-2">
          @auth
          @if(auth()->user()->role == 'admin')
          <div class="col-5 col-lg-3">
          <input type="text" id="searchInput" placeholder="Search..." style="width: 100%; border: 1px solid #b3b3b3; height: 41px; border-radius: 3px;">
            <div class="sidenav">
                <span class="nav1">Pages</span>

                @foreach($mainresponse as $res)
                
                    <button class="dropdown-btn" id="searchButton" style="display: none !important">
                        <span style="cursor:pointer">{{ $res['name'] }}</span>
                        @if (!empty($res['Hierarchy']))
                            <i class="fa fa-angle-down mt-2" ></i>
                        @endif
                    </button>

                    @if (!empty($res['Hierarchy']))
                        <div class="dropdown-container" id="searchButton">
                            @foreach($res['Hierarchy'] as $item)
                                <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                    <span style="text-transform:capitalize;">{{ $item['obj_name'] }} </span>
                                    <div class="align-items-center" style="display: flex !important;">
                                        <a href="/edit/{{ $item['obj_id'] }}" id="{{ $item['obj_id'] }}" data-name="{{ $item['obj_name'] }}" class="update-form my-edit " >
                                            <i class="fa fa-edit "  ></i>
                                        </a>
                                        {{-- @if (empty($item['items']))
                                        <a href="/items/{{ $item['obj_id'] }}" id="{{ $item['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $item['obj_id'] }}">
                                            <i class="fas fa-trash-alt "></i>
                                        </a>
                                        @endif --}}
                                    
                                    
                                        @if (!empty($item['items']))
                                            <i class="fa fa-angle-down mt-2"></i>
                                        @endif
                                </div>
                                </button>

                                <!-- Level 2 -->
                                @if (!empty($item['items']))
                                    <div class="dropdown-container">
                                        @foreach($item['items'] as $subItem)
                                            <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                <span style="margin-left: 0px;text-transform:capitalize;">{{ $subItem['obj_name'] }}</span>
                                                <div class="align-items-center" style="display: flex !important;">

                                                    <a href="/edit/{{ $subItem['obj_id'] }}" id="{{ $subItem['obj_id'] }}" data-name="{{ $subItem['obj_name'] }}" class="update-form my-edit " >
                                                        <i class="fa fa-edit "  ></i>
                                                    </a>
                                                    @if (empty($subItem['items']))
                                                    <a href="/items/{{ $subItem['obj_id'] }}" id="{{ $subItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subItem['obj_id'] }}">
                                                        <i class="fas fa-trash-alt " ></i>
                                                    </a>
                                                    @endif

                                                    @if (!empty($subItem['items']))
                                                        <i class="fa fa-angle-down mt-2"></i>
                                                    @endif
                                                </div>
                                            </button>

                                            <!-- Level 3 -->
                                            @if (!empty($subItem['items']))
                                                <div class="dropdown-container">
                                                    @foreach($subItem['items'] as $subSubItem)
                                                        <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                            <span >{{ $subSubItem['obj_name'] }}</span>
                                                            <div class="align-items-center" style="display: flex !important;">

                                                                <a href="/edit/{{ $subSubItem['obj_id'] }}" id="{{ $subSubItem['obj_id'] }}" data-name="{{ $subSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                    <i class="fa fa-edit "  ></i>
                                                                </a>
                                                                @if (empty($subSubItem['items']))
                                                                <a href="/items/{{ $subSubItem['obj_id'] }}" id="{{ $subSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubItem['obj_id'] }}">
                                                                    <i class="fas fa-trash-alt " ></i>
                                                                </a>
                                                                @endif
                                                                @if (!empty($subSubItem['items']))
                                                                    <i class="fa fa-angle-down mt-2"></i>
                                                                @endif
                                                            </div>
                                                        </button>

                                                        <!-- Level 4 -->
                                                        @if (!empty($subSubItem['items']))
                                                            <div class="dropdown-container">
                                                                @foreach($subSubItem['items'] as $subSubSubItem)
                                                                    <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                                        <span style="margin-left: 0px">{{ $subSubSubItem['obj_name'] }}</span>
                                                                        <div class="align-items-center" style="display: flex !important;">

                                                                            <a href="/edit/{{ $subSubSubItem['obj_id'] }}" id="{{ $subSubSubItem['obj_id'] }}" data-name="{{ $subSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                <i class="fa fa-edit "  ></i>
                                                                            </a>
                                                                            @if (empty($subSubSubItem['items']))
                                                                            <a href="/items/{{ $subSubSubItem['obj_id'] }}" id="{{ $subSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubItem['obj_id'] }}">
                                                                                <i class="fas fa-trash-alt " ></i>
                                                                            </a>
                                                                            @endif
                                                                            @if (!empty($subSubSubItem['items']))
                                                                                <i class="fa fa-angle-down mt-2"></i>
                                                                            @endif
                                                                        </div>    
                                                                    </button>

                                                                    <!-- Level 5 -->
                                                                    @if (!empty($subSubSubItem['items']))
                                                                        <div class="dropdown-container">
                                                                            @foreach($subSubSubItem['items'] as $subSubSubSubItem)
                                                                                <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                                                    <span>{{ $subSubSubSubItem['obj_name'] }}</span>
                                                                                    <div class="align-items-center" style="display: flex !important;">

                                                                                        <a href="/edit/{{ $subSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubItem['obj_id'] }}" data-name="{{ $subSubSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                            <i class="fa fa-edit "  ></i>
                                                                                        </a>
                                                                                        @if (empty($subSubSubSubItem['items']))
                                                                                        <a href="/items/{{ $subSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubSubItem['obj_id'] }}">
                                                                                            <i class="fas fa-trash-alt " ></i>
                                                                                        </a>
                                                                                        @endif
                                                                                        @if (!empty($subSubSubSubItem['items']))
                                                                                            <i class="fa fa-angle-down mt-2"></i>
                                                                                        @endif
                                                                                    </div>    
                                                                                </button>

                                                                                <!-- Level 6 -->
                                                                                @if (!empty($subSubSubSubItem['items']))
                                                                                    <div class="dropdown-container">
                                                                                        @foreach($subSubSubSubItem['items'] as $subSubSubSubSubItem)
                                                                                            <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                                                                <span>{{ $subSubSubSubSubItem['obj_name'] }}</span>
                                                                                                <div class=" align-items-center" style="display: flex !important;">

                                                                                                    <a href="/edit/{{ $subSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubItem['obj_id'] }}" data-name="{{ $subSubSubSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                                        <i class="fa fa-edit "  ></i>
                                                                                                    </a>
                                                                                                    @if (empty($subSubSubSubSubItem['items']))
                                                                                                    <a href="/items/{{ $subSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubSubSubItem['obj_id'] }}">
                                                                                                        <i class="fas fa-trash-alt " ></i>
                                                                                                    </a>
                                                                                                    @endif
                                                                                                    @if (!empty($subSubSubSubSubItem['items']))
                                                                                                        <i class="fa fa-angle-down mt-2"></i>
                                                                                                    @endif
                                                                                                </div>    
                                                                                            </button>

                                                                                            <!-- Level 7 -->
                                                                                            @if (!empty($subSubSubSubSubItem['items']))
                                                                                                <div class="dropdown-container">
                                                                                                    @foreach($subSubSubSubSubItem['items'] as $subSubSubSubSubSubItem)
                                                                                                        <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                                                                            <span>{{ $subSubSubSubSubSubItem['obj_name'] }}</span>
                                                                                                            <div class="align-items-center" style="display: flex !important;">

                                                                                                                <a href="/edit/{{ $subSubSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubSubItem['obj_id'] }}" data-name="{{ $subSubSubSubSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                                                    <i class="fa fa-edit "  ></i>
                                                                                                                </a>
                                                                                                                @if (empty($subSubSubSubSubSubItem['items']))
                                                                                                                <a href="/items/{{ $subSubSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubSubSubSubItem['obj_id'] }}">
                                                                                                                    <i class="fas fa-trash-alt " ></i>
                                                                                                                </a>
                                                                                                                @endif
                                                                                                                @if (!empty($subSubSubSubSubSubItem['items']))
                                                                                                                    <i class="fa fa-angle-down mt-2"></i>
                                                                                                                @endif
                                                                                                            </div>    
                                                                                                        </button>

                                                                                                        <!-- Level 8 -->
                                                                                                        @if (!empty($subSubSubSubSubSubItem['items']))
                                                                                                            <div class="dropdown-container">
                                                                                                                @foreach($subSubSubSubSubSubItem['items'] as $subSubSubSubSubSubSubItem)
                                                                                                                    <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                                                                                        <span>{{ $subSubSubSubSubSubSubItem['obj_name'] }}</span>
                                                                                                                        <div class="align-items-center" style="display: flex !important;">

                                                                                                                            <a href="/edit/{{ $subSubSubSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubSubSubItem['obj_id'] }}" data-name="{{ $subSubSubSubSubSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                                                                <i class="fa fa-edit "  ></i>
                                                                                                                            </a>
                                                                                                                            @if (empty($subSubSubSubSubSubSubItem['items']))
                                                                                                                            <a href="/items/{{ $subSubSubSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubSubSubSubSubItem['obj_id'] }}">
                                                                                                                                <i class="fas fa-trash-alt " ></i>
                                                                                                                            </a>
                                                                                                                            @endif

                                                                                                                            @if (!empty($subSubSubSubSubSubSubItem['items']))
                                                                                                                                <i class="fa fa-angle-down mt-2"></i>
                                                                                                                            @endif
                                                                                                                        </div>    
                                                                                                                    </button>

                                                                                                                    <!-- Level 9 -->
                                                                                                                    @if (!empty($subSubSubSubSubSubSubItem['items']))
                                                                                                                        <div class="dropdown-container">
                                                                                                                            @foreach($subSubSubSubSubSubSubItem['items'] as $subSubSubSubSubSubSubSubItem)
                                                                                                                                <button class="dropdown-btn justify-content-between align-items-center" style="display: flex !important;">
                                                                                                                                    <span>{{ $subSubSubSubSubSubSubSubItem['obj_name'] }}</span>
                                                                                                                                    <div class="align-items-center" style="display: flex !important;">

                                                                                                                                        <a href="/edit/{{ $subSubSubSubSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubSubSubSubItem['obj_id'] }}" data-name="{{ $subSubSubSubSubSubSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                                                                            <i class="fa fa-edit "  ></i>
                                                                                                                                        </a>
                                                                                                                                        @if (empty($subSubSubSubSubSubSubSubItem['items']))
                                                                                                                                        <a href="/items/{{ $subSubSubSubSubSubSubSubItem['obj_id'] }}" id="{{ $subSubSubSubSubSubSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubSubSubSubSubSubItem['obj_id'] }}">
                                                                                                                                            <i class="fas fa-trash-alt " ></i>
                                                                                                                                        </a>
                                                                                                                                        @endif

                                                                                                                                        @if (!empty($subSubSubSubSubSubSubSubItem['items']))
                                                                                                                                            <i class="fa fa-angle-down mt-2"></i>
                                                                                                                                        @endif
                                                                                                                                    </div>
                                                                                                                                    </button>
                                                                                                                                

                                                                                                                                <!-- Level 10 -->
                                                                                                                                <!-- Add more levels as needed -->
                                                                                                                                <!-- Repeat the pattern for additional levels -->
                                                                                                                            @endforeach
                                                                                                                        </div>
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                </div>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
                
                <span class="nav1">Menu</span>
                @foreach($mainresponse1 as $res)
                    <button class="dropdown-btn " style="display:none !important">
                        <span style="cursor:pointer;text-transform:capitalize" >{{ $res['name'] }}</span>
                        @if (!empty($res['Hierarchy']))
                            <i class="fa fa-angle-down mt-2"></i>
                        @endif
                    </button>

                    @if (!empty($res['Hierarchy']))
                        <div class="dropdown-container" style="display: block !important">
                            @foreach($res['Hierarchy'] as $item)
                                <button class="dropdown-btn justify-content-between align-items-center" style="display: flex">
                                    <span style="text-transform:capitalize;">{{ $item['obj_name'] }}</span>
                                    <div class="align-items-center" style="display: flex">
                                        <a href="/edit/{{ $item['obj_id'] }}" id="{{ $item['obj_id'] }}" data-name="{{ $item['obj_name'] }}" class="update-form my-edit">
                                            <i class="fa fa-edit" ></i>
                                        </a>
                                        {{-- @if (empty($item['items']))
                                            <a href="/items/{{ $item['obj_id'] }}" id="{{ $item['obj_name'] }}" class="delete-form-new" data-objDelid="{{ $item['obj_id'] }}">
                                                <i class="fas fa-trash-alt" ></i>
                                            </a>
                                        @endif --}}
                                        @if (!empty($item['items']))
                                            <i class="fa fa-angle-down mt-2"></i>
                                        @endif
                                    </div>
                                </button>

                                <!-- Level 2 -->
                                @if (!empty($item['items']))
                                    <div class="dropdown-container">
                                        @foreach($item['items'] as $subItem)
                                            <button class="dropdown-btn justify-content-between align-items-center" style="display: flex">
                                                <span style="text-transform:capitalize;">{{ $subItem['obj_name'] }}</span>
                                                <div class="align-items-center" style="display: flex">
                                                    <a href="/edit/{{ $subItem['obj_id'] }}" id="{{ $subItem['obj_id'] }}" data-name="{{ $subItem['obj_name'] }}" class="update-form my-edit">
                                                        <i class="fa fa-edit" ></i>
                                                    </a>
                                                    @if (empty($subItem['items']))
                                                        <a href="/items/{{ $subItem['obj_id'] }}" id="{{ $subItem['obj_name'] }}" class="delete-form-new" data-objDelid="{{ $subItem['obj_id'] }}">
                                                            <i class="fas fa-trash-alt" ></i>
                                                        </a>
                                                    @endif
                                                    @if (!empty($subItem['items']))
                                                        <i class="fa fa-angle-down mt-2"></i>
                                                    @endif
                                                </div>
                                            </button>

                                            <!-- Level 3 -->
                                            @if (!empty($subItem['items']))
                                                <div class="dropdown-container">
                                                    @foreach($subItem['items'] as $subSubItem)
                                                        <button class="dropdown-btn justify-content-between align-items-center" style="display: flex">
                                                            <span style="text-transform:capitalize;">{{ $subSubItem['obj_name'] }}</span>
                                                            <div class="align-items-center" style="display: flex">
                                                                <a href="/edit/{{ $subSubItem['obj_id'] }}" id="{{ $subSubItem['obj_id'] }}" data-name="{{ $subSubItem['obj_name'] }}" class="update-form my-edit">
                                                                    <i class="fa fa-edit" ></i>
                                                                </a>
                                                                @if (empty($subSubItem['items']))
                                                                    <a href="/items/{{ $subSubItem['obj_id'] }}" id="{{ $subSubItem['obj_name'] }}" class="delete-form-new" data-objDelid="{{ $subSubItem['obj_id'] }}">
                                                                        <i class="fas fa-trash-alt" ></i>
                                                                    </a>
                                                                @endif
                                                                @if($subSubItem['obj_name'] == 'Topbar Scrollable')
                                                                    @if (!empty($subSubItem['items']))
                                                                        <i class="fa fa-angle-down mt-2"></i>
                                                                    @endif
                                                                @endif    
                                                            </div>
                                                        </button>
                                                        @if($subSubItem['obj_name'] == 'Topbar Scrollable')
                                                                @if (!empty($subSubItem['items']))
                                                                    <div class="dropdown-container">
                                                                        @foreach($subSubItem['items'] as $subSubSubItem)
                                                                            <button class="dropdown-btn justify-content-between align-items-center" style="display: flex">
                                                                                <span style="margin-left: 0px;text-transform:capitalize;">{{ $subSubSubItem['obj_name'] }}</span>
                                                                                <div class="d-flex align-items-center" style="display: flex">

                                                                                    <a href="/edit/{{ $subSubSubItem['obj_id'] }}" id="{{ $subSubSubItem['obj_id'] }}" data-name="{{ $subSubSubItem['obj_name'] }}" class="update-form my-edit " >
                                                                                        <i class="fa fa-edit "  ></i>
                                                                                    </a>
                                                                                    @if (empty($subSubSubItem['items']))
                                                                                    <a href="/items/{{ $subSubSubItem['obj_id'] }}" id="{{ $subSubSubItem['obj_name'] }}"class="delete-form-new" data-objDelid="{{ $subSubSubItem['obj_id'] }}">
                                                                                        <i class="fas fa-trash-alt " ></i>
                                                                                    </a>
                                                                                    @endif
                                                                                    @if (!empty($subSubSubItem['items']))
                                                                                        <i class="fa fa-angle-down mt-2"></i>
                                                                                    @endif
                                                                                </div>    
                                                                            </button>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                        @endif         

                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                @endforeach
                <span class="nav1">Forms</span>
                <button class="dropdown-btn">
                   <a class="txt-1" style="color:#1499d6;padding-left:10px;text-decoration:none" href="/contactus">Contact</a>
                </button>   
                {{-- <span class="nav1">Social Feeds</span>
                <button class="dropdown-btn">
                   <a class="txt-1" style="color:#1499d6;padding-left:10px;text-decoration:none" href="/facebookfeeeds">Facebook</a>
                </button>           --}}
            </div>
          </div> 
          @endif
          @endauth


         
         
           <div class="col-7 col-lg-9 custom-column" >
           
        
            <main class="py-2">
                @yield('content')
            </main>
   
        </div> 
    </div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}

<script>
     $(document).ready(function () {
        $('#searchInput').on('input', function () {
            searchItems();
        });
    });

    function searchItems() {
        var searchQuery = $('#searchInput').val().toLowerCase();
        $('.dropdown-btn').hide();
        $('.dropdown-btn:contains("' + searchQuery + '")').each(function () {
            showHierarchy($(this));
        });
    }

    function showHierarchy(element) {
        element.show();
        var parentContainer = element.closest('.dropdown-container');
        if (parentContainer.length) {
            parentContainer.prev('.dropdown-btn').css({
                'color': '#ffffff',
                'background': '#1499D6'
            }).show();
            showHierarchy(parentContainer.prev('.dropdown-btn'));
            parentContainer.show();
        }
    }

    $.extend($.expr[':'], {
        'contains': function (elem, i, match, array) {
            return (
                (elem.textContent || elem.innerText || '').toLowerCase()
                    .indexOf((match[3] || '').toLowerCase()) >= 0
            );
        }
    });
    $(document).ready(function () {
        $('#searchButton').hide();
        $('#searchInput').on('input', function () {
            if ($(this).val().trim() !== '') {
                $('#searchButton').hide();
            } else {
                $('#searchButton').show();
            }
        });
    });
    $(document).ready(function() {
    $('.delete-form-new').click(function(event) {
        var id = $(this).attr('id');
        var objId = $(this).data('objdelid');
        var url = $(this).attr('href');
        var closestButton = $(this).closest('button');
        event.preventDefault();
        var confirmed = confirm('Are you sure you want to delete' + ' '+id+'?');
        if (confirmed) {
            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    if(response.success){
                        closestButton.remove();
                        if(objId != '' && objId > 0){
                            $('div[data-objid="'+objId+'"]').parent('#ajaxobjdef').html(response.html);
                        }
                        var hasMyClass = $("#editor").hasClass("ql-container");
                        if(!hasMyClass){
                            // loadQuillEditor();
                            var quill = new Quill('#editor', {
                                theme: 'snow',
                                modules: {
                                    toolbar: [
                                        [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
                                        ['bold', 'italic', 'underline', 'strike'],
                                        [{'list': 'ordered'}, {'list': 'bullet'}],
                                        ['link', 'image', 'blockquote', 'code-block'],
                                        [{ 'align': [] }],
                                        ['clean'],
                                    ]
                                },
                                readOnly: false
                            });
                            // Set the initial content of the Quill editor
                            var initialContent = document.getElementById('editorContent').value;
                            quill.clipboard.dangerouslyPasteHTML(initialContent);
                            // Capture Quill content and set it as the value of the hidden input
                            quill.on('text-change', function() {
                                var content = quill.root.innerHTML;
                                document.getElementById('editorContent').value = content;
                            });
                        }
                        $('.select2').select2();
                        showToast(response.message, 'success');
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
</script>
</body>
</html>
