@php
use  App\Http\Controllers\ObjDefController;
$obj = new ObjDefController;
$header = $obj->getHierarchyAsJson(3, true);
$logos = $obj->getHierarchyAsJson(8, true);

@endphp
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
        @if(!empty($logos))
            @foreach ($logos as $item)
                @if($item['displayable'] == 1 && $item['obj_id'] == 9)
                   <a href="{{$item['route_path']}}" class="logo ml-auto lazyload" loading="lazy"><img src="{{$item['image_name']}}" alt=""></a>
               @endif
            @endforeach
        @endif
      <!-- navbar start -->
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          @if(!empty($header))
              @foreach ($header[0]['items'] as $item)
                  @if($item['displayable'] == 1)
                      @if($item['obj_id'] == 6)
                          <li class="dropdown">
                              <a class="{{ Request::url() == url($item['route_path']) ? 'active' : '' }}" href="{{$item['route_path']}}">
                                  <span>{{$item['display_name']}}</span> <i class="bi bi-chevron-down"></i>
                              </a>
                              <ul class="tri">
                                  <!-- You can dynamically generate child and subchild items here -->
                                  @foreach ($item['items'] as $childItem)
                                      <li class="dropdown">
                                          <a href="/products{{$childItem['route_path']}}/{{$childItem['obj_name']}}">
                                              <span>{{$childItem['display_name']}}</span> @if(!empty($childItem['items']))<i class="bi bi-chevron-right"></i>@endif
                                          </a>
                                          @if(!empty($childItem['items']))
                                              <ul>
                                                  <!-- Loop through subchild items -->
                                                  @foreach ($childItem['items'] as $subChildItem)
                                                      <li class="dropdown">
                                                          <a href="/products{{$subChildItem['route_path']}}/{{$subChildItem['obj_name']}}">
                                                              <span>{{$subChildItem['display_name']}}</span> @if(!empty($subChildItem['items']))<i class="bi bi-chevron-right"></i>@endif
                                                          </a>
                                                          @if(!empty($subChildItem['items']))
                                                              <ul>
                                                                  <!-- Loop through subchild items of subchild -->
                                                                  @foreach ($subChildItem['items'] as $subSubChildItem)
                                                                      <li><a href="/products{{$subSubChildItem['route_path']}}/{{$subSubChildItem['obj_name']}}">{{$subSubChildItem['display_name']}}</a></li>
                                                                  @endforeach
                                                              </ul>
                                                          @endif
                                                      </li>
                                                  @endforeach
                                              </ul>
                                          @endif
                                      </li>
                                  @endforeach
                              </ul>
                          </li>
                      @elseif($item['obj_id'] == 24)
                        
                        <li class="dropdown">
                              <a class="{{ Request::url() == url($item['route_path']) ? 'active' : '' }}" >
                                  <span>{{$item['display_name']}}</span> <i class="bi bi-chevron-down"></i>
                              </a>
                              <ul class="tri">
                                  <!-- You can dynamically generate child items here -->
                                  @foreach ($item['items'] as $childItem)
                                      <li class="dropdown">
                                          <a href="/brands{{$childItem['route_path']}}/{{$childItem['obj_name']}}">
                                              <span>{{$childItem['display_name']}}</span>
                                          </a>
                                      </li>
                                  @endforeach
                              </ul>
                        </li>
                      
                      @else
                          <li><a class="nav-link scrollto {{ Request::url() == url($item['route_path']) ? 'active' : '' }}" href="{{$item['route_path']}}">{{$item['display_name']}}</a></li>
                      @endif
                  @endif
              @endforeach
          @endif
      </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
      <!-- navbar end -->
        @if(!empty($logos))
            @foreach ($logos as $item)
                @if($item['displayable'] == 1 && $item['obj_id'] == 9)
                    <span  class="logo ml-auto " style="opacity: 0"><img src="{{$item['image_name']}}" class="lazyload" loading="lazy" alt=""></span>
                @endif
            @endforeach
        @endif
    </div>
  </header>