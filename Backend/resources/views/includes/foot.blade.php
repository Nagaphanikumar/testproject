@php
use  App\Http\Controllers\ObjDefController;
$obj = new ObjDefController;
$header = $obj->getHierarchyAsJson(3, true);
$footer = $obj->getHierarchyAsJson(11, true);
$footer_socialmedia = $obj->getHierarchyAsJson(13, true);
$logos = $obj->getHierarchyAsJson(8, true);
$products = $obj->getHierarchyAsJson(6, true);
@endphp
<footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
  
          <div class="col-lg-4 col-md-6">
            <div class="footer-info">
              @if(!empty($logos))
                @foreach ($logos as $item)
                    @if($item['displayable'] == 1 && $item['obj_id'] == 9)
                      <a href="{{$item['route_path']}}" class="footer-logo ml-auto"><img class="lazyload"  src="{{$item['image_name']}}" alt="" loading="lazy"></a>
                  @endif
                @endforeach
              @endif              
              <p>
                @if(!empty($footer))
                  @foreach ($footer as $item)
                      @if($item['displayable'] == 1 && $item['obj_id'] == 12)
                        {!! $footer[0]['description'] !!}
                      @endif
                  @endforeach
                @endif
              </p>
              <div class="social-links mt-3">
                @if(!empty($footer_socialmedia))
                  @foreach ($footer_socialmedia as $item)
                      @if($item['displayable'] == 1)
                      <a href="{{$item['route_path']}}" class=""><i class="{{$item['icon_code']}}"></i></a>
                      @endif
                  @endforeach
                @endif
                <a href="/admin" class="" target="_blank"><i class="fas fa-user"></i></a>
              </div>
            </div>
          </div>
  
          <div class="col-lg-2 col-md-6 footer-links d-grid justify-content-lg-center justify-content-sm-start">
            <h4>Useful Links</h4>
            <ul>
              @if(!empty($header))
                @foreach ($header[0]['items'] as $item)
                    @if($item['displayable'] == 1 && $item['obj_id'] != 24)
                      <li><i class="bx bx-chevron-right"></i> <a href="{{$item['route_path']}}">{{$item['display_name']}}</a></li>
                    @endif
                @endforeach
              @endif
              <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
            </ul>
          </div>
  
          <div class="col-lg-3 col-md-6 footer-links d-grid justify-content-lg-center justify-content-sm-start">
            <h4>Our Products</h4>
            <ul>
              @if(!empty($products))
                @foreach ($products as $index => $item)
                    @if($item['displayable'] == 1 && $index < 5)
                    <li><i class="bx bx-chevron-right"></i> <a href="/products{{$item['route_path']}}/{{$item['obj_name']}}">{{$item['display_name']}}</a></li>
                    @endif
                @endforeach
              @endif
            </ul>
          </div>
  
          <div class="col-lg-3 col-md-6 footer-newsletter">
            @if(!empty($footer))
              @foreach ($footer as $item)
                  @if($item['displayable'] == 1 && $item['obj_id'] == 122)
                    {{-- <a href="{{$item['route_path']}}" class="r-logo ml-auto"><img class="lazyload" src="{{$item['image_name']}}" alt="" loading="lazy"></a> --}}
                    <iframe src="{{$item['route_path']}}"></iframe>
                  @endif
              @endforeach
            @endif
          </div>
  
        </div>
      </div>
    </div>
  
    <div class="container" style="    display: flex;
    align-items: flex-end;
    justify-content: center;">
      <div class="copyright">
        <?php $currentYear = date("Y");?>
        Copyright © {{$currentYear}} Reddy's Pharma LTD, All Rights Reserved | Designed and Developed By <a href="https://www.bitapps.com/" target="_blank">BitApps</a>
      </div>
    </div>
  </footer>
  <!-- End Footer -->