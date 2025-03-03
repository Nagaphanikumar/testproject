
 <div>
    @php
        $decodedHierarchy = json_decode($hierarchy);
    @endphp
</div>

<ul>
    @if (empty($decodedHierarchy))
    <span>{{ $defdata->obj_name }}
        <a href="/edit/{{ $defdata->obj_id }}" id="{{ $defdata->obj_id }}" class="update-form">
            <i class="mr-4 fa-solid fa-pen"></i>
        </a>
        <a href="/items/{{ $defdata->obj_id }}" id="{{ $defdata->obj_name }}" class="delete-form">
            <i class="fa-solid fa-trash" style="color: #a30000;"></i>
        </a>
        </span>
    @endif
    @if (isset($decodedHierarchy[0]->title_name))
    <span class="caret1">  {{ $decodedHierarchy[0]->title_name }}
        <a href="/edit/{{ $defdata->obj_id }}" id="{{ $defdata->obj_id }}" class="update-form">
            <i class="mr-4 fa-solid fa-pen"></i>
        </a>
    </span>  
    @endif

    @foreach($decodedHierarchy as $item)   
    <li class="list-item value" value="{{$item->obj_id}}"  style="margin-left: 28px">
        <span class="{{ !empty($item->items) ? 'caret' : '' }} " >
            {{ $item->obj_name }}
            <a href="/edit/{{ $item->obj_id }}" id="{{ $item->obj_id }}" class="update-form">
                <i class="mr-4 fa-solid fa-pen"></i>
            </a>
            @if (empty($item->items))
            <a href="/items/{{ $item->obj_id }}"  id="{{ $item->obj_name }}" class="delete-form">
                <i class="fa-solid fa-trash" style="color: #a30000;"></i>
            </a>
            @endif
        </span>
        @if (!empty($item->items))
        <ul class="nested">
            @foreach($item->items as $key => $subItem)
            <li style="margin-left: 33px" >
                <span class="{{ !empty($subItem->items) ? 'caret' : '' }}">{{ $subItem->obj_name }}</span>
                <a href="/edit/{{ $subItem->obj_id }}" id="{{ $subItem->obj_id }}" class="update-form">
                    <i class="mr-4 fa-solid fa-pen"></i>
                </a>
                @if (empty($subItem->items))
                <a href="/items/{{ $subItem->obj_id }}" id="{{ $subItem->obj_name }}" class="delete-form">
                    <i class="fa-solid fa-trash" style="color: #a30000;"></i>
                </a>
                @endif
                @if (!empty($subItem->items))
                    <ul class="nested">
                        @foreach($subItem->items as $subKey => $subSubItem)
                        <li class="child" >
                            <span style="margin-left: 33px;" class="{{ !empty($subSubItem->items) ? 'caret' : '' }}"> {{ $subSubItem->obj_name }}</span>
                       
                        <a href="/edit/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_id }}" class="update-form">
                            <i class="mr-4 fa-solid fa-pen" ></i>
                        </a>
                        @if (empty($subSubItem->items))
                        <a href="/items/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_name }}" class="delete-form">
                            <i class="fa-solid fa-trash" style="color: #a30000;"></i>
                        </a>
                        @endif
                            @if (!empty($subSubItem->items))
                            <ul class="nested">
                                @foreach($subSubItem->items as $subKey => $subSubItem)
                                <li class="child" style="margin-left: 33px">
                                    <span class="{{ !empty($subSubItem->items) ? 'caret' : '' }}" style="margin-left: 33px;">  {{ $subSubItem->obj_name }}</span>
                               
                                <a href="/edit/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_id }}" class="update-form">
                                    <i class="mr-4 fa-solid fa-pen"></i>
                                </a>
                                @if (empty($subSubItem->items))
                                <a href="/items/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_name }}" class="delete-form">
                                    <i class="fa-solid fa-trash" style="color: #a30000;"></i>
                                </a>
                                @endif
                                @if (!empty($subSubItem->items))
                                <ul class="nested">
                                    @foreach($subSubItem->items as $subKey => $subSubItem)
                                    <li class="child" style="margin-left: 33px">
                                        <span class="{{ !empty($subSubItem->items) ? 'caret' : '' }}" style="margin-left: 33px;">  {{ $subSubItem->obj_name }}</span>
                                   
                                    <a href="/edit/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_id }}"class="update-form">
                                        <i class="mr-4 fa-solid fa-pen"></i>
                                    </a>
                                    @if (empty($subSubItem->items))
                                    <a href="/items/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_name }}" class="delete-form">
                                        <i class="fa-solid fa-trash" style="color: #a30000;"></i>
                                    </a>
                                    @endif
                                    @if (!empty($subSubItem->items))
                                    <ul class="nested">
                                        @foreach($subSubItem->items as $subKey => $subSubItem)
                                        <li class="child" style="margin-left: 33px">
                                            <span class="{{ !empty($subSubItem->items) ? 'caret' : '' }}" style="margin-left: 33px;">  {{ $subSubItem->obj_name }}</span>
                                       
                                        <a href="/edit/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_id }}" class="update-form">
                                            <i class="mr-4 fa-solid fa-pen"></i>
                                        </a>
                                        @if (empty($subSubItem->items))
                                        <a href="/items/{{ $subSubItem->obj_id }}" id="{{ $subSubItem->obj_name }}" class="delete-form">
                                            <i class="fa-solid fa-trash" style="color: #a30000;"></i>
                                        </a>
                                        @endif
                                        </li>
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
                            @endif
                        </li>
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

<script>
    $(document).ready(function(){
        $('.value').hide();
        $(".caret1").click(function(){
            $('.value').toggle();
            $('.caret1').toggleClass('caret-down');
        });
        $(".helo").click(function(){
            $('.child').show();
            $('.helo').toggleClass('active');
        });
        $('.delete-form').click(function(event) {
        var id = $(this).attr('id');
        event.preventDefault();

    var confirmed = confirm('Are you sure you want to delete' + ' '+id+'?');
    if (confirmed) {
    window.location.href = $(this).attr('href');
    }
    });
    $('.update-form').click(function(event) {
                event.preventDefault(); 
                
                var id = $(this).attr('id');
                
                $.ajax({
                    type: 'GET',
                    url: '/edit/' + id,
                    success: function(response) {
                       console.log(response);
                       $('#ajaxobjdef').css('display','block');
                    $('#objdef').css('display','none');
                    $('#objhierarchy').css('display','none');

                    $('#ajaxobjdef').html(response);
                    },
                    error: function(error) {
                        // Handle error cases
                        console.log('Error:', error);
                    }
                });
            });
    })
    $(document).ready(function(){
            $('.select2').select2();
        })
</script>



