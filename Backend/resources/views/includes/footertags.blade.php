{{-- <div id="preloader"></div> --}}
{{-- @if(!empty($whatsapp))      
<img class="object-cover img-fluid object-cover img-fluid back-to-top d-flex align-items-center justify-content-center active wt_footer" id="wt_footer" src="{{$whatsapp[0]['image_name']}}" style="height: 29px; width: 29px;bottom:64px;visibility: hidden;" alt="B-safe-whatsapp-chat" />                 
@endif --}}
<a href="#" class="back-to-top d-flex align-items-center justify-content-center active" id="b_to_top"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
    <!-- Template Main JS File -->
    <script src="https://cdn.jsdelivr.net/npm/lazysizes/lazysizes.min.js" defer></script>

  <script src="/assets/custom/purecounter/purecounter_vanilla.js"></script>
  <script src="/assets/custom/aos/aos.js"></script>
  <script src="/assets/custom/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/custom/glightbox/js/glightbox.min.js"></script>
  <script src="/assets/custom/swiper/swiper-bundle.min.js"></script>
  <script src="/assets/js/main.js"></script>
  <script type="text/javascript" src="/assets/js/ajax.googleapis.com_ajax_libs_jquery_3.3.1_jquery.min.js"></script>
  <script type="text/javascript" src="/assets/js/24limousine.com_wp-content_themes_24Limousine_assets_js_owl.carousel.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    lazySizes.init(); // Initialize lazysizes manually
  });
    $(document).ready(function() {
  
    });
    $(document).ready(function() { 
    $('#client-logos').owlCarousel({
          loop:true,
          margin:15,
          nav:true,
          autoPlay:true,
          autoplayTimeout:1000,
          autoplayHoverPause:true,
          responsive:{
              0:{
                  items:2,
                  loop:true,
  
              },
              600:{
                  items:4,
                  loop:true
              },
              1000:{ 
                  items:4,
                  loop:true
              }
          },
          navText: ["<img src='https://pixsector.com/cache/a8009c95/av8a49a4f81c3318dc69d.png'/>","<img src='https://pixsector.com/cache/81183b13/avcc910c4ee5888b858fe.png'/>"]
          // navText : ['<i class="fa-solid fa-chevron-left text-gray-500 text-sm"></i>','<i class="fa-solid fa-chevron-right text-gray-500 text-sm"></i>']
      });
    });
    $(document).ready(function() { 

      $('#partners-logos').owlCarousel({
          loop:true,
          margin:15,
          nav:true,
          autoPlay:true,
          autoplayTimeout:1000,
          autoplayHoverPause:true,
          responsive:{
              0:{
                  items:2,
                  loop:true,
  
              },
              600:{
                  items:4,
                  loop:true
              },
              1000:{ 
                  items:4,
                  loop:true
              }
          },
          navText: ["<img src='https://pixsector.com/cache/a8009c95/av8a49a4f81c3318dc69d.png'/>","<img src='https://pixsector.com/cache/81183b13/avcc910c4ee5888b858fe.png'/>"]
          // navText : ['<i class="fa-solid fa-chevron-left text-gray-500 text-sm"></i>','<i class="fa-solid fa-chevron-right text-gray-500 text-sm"></i>']
      });
    });

      AOS.init();
        $(document).ready(function(){
            setTimeout(function() {
                $('.alert').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 3000);

            $(document).on("click","#testimonials_read_more",function(e) {
                e.preventDefault();
                var objId = $(this).data('obj-id');
                $('.mini_desc[data-obj-id="' + objId + '"]').css('display', 'none');
                $('.total_desc[data-obj-id="' + objId + '"]').css('display', 'block');
                $('#testimonials_read_less[data-obj-id="' + objId + '"]').css('display', 'block');
                $('#testimonials_read_more[data-obj-id="' + objId + '"]').css('display', 'none');           
            })

            $(document).on("click","#testimonials_read_less",function(e) {
                e.preventDefault();
                var objId = $(this).data('obj-id');
                $('.mini_desc[data-obj-id="' + objId + '"]').css('display', 'block');
                $('.total_desc[data-obj-id="' + objId + '"]').css('display', 'none');
                $('#testimonials_read_less[data-obj-id="' + objId + '"]').css('display', 'none');
                $('#testimonials_read_more[data-obj-id="' + objId + '"]').css('display', 'block');           
            })

            $(document).on("click",".about-us-read-more",function(e) {
                e.preventDefault();
                $('#about-limited-desc').hide();
                $('#about-desc').css('display','block');
                $('.about-us-read-more').css('display','none');
            })

            $(document).on("click",".quality-read-more",function(e) {
                e.preventDefault();
                $('#quality-limited-desc').hide();
                $('#quality-desc').css('display','block');
                $('.quality-read-more').css('display','none');
            })

            $(document).on("click",".quality-read-less",function(e) {
                e.preventDefault();
                $('#quality-limited-desc').show();
                $('#quality-desc').css('display','none');
                $('.quality-read-more').css('display','block');
            })
            
            $(document).on("click",".about-us-read-less",function(e) {
                e.preventDefault();
                $('#about-limited-desc').show();
                $('#about-desc').css('display','none');
                $('.about-us-read-more').css('display','block');
                $(window).scrollTop(0);
            })
        });

    function getBrowserTimeZone() {
    return Intl.DateTimeFormat().resolvedOptions().timeZone;
}

// Send the time zone to Laravel via AJAX
function sendTimeZoneToLaravel() {
    const timeZone = getBrowserTimeZone();


    // Example of using jQuery for AJAX request
    $.ajax({
        url: '/save-timezone', // Your Laravel route
        method: 'POST',
        data: {
            timeZone: timeZone,
            _token: '{{ csrf_token() }}' // Include CSRF token
        },
        success: function(response) {
        }
    });
}

// Call the function to send the time zone
sendTimeZoneToLaravel();
const video = document.getElementById('myVideo');
    const playPauseBtn = document.getElementById('playPauseBtn');
    const playPauseIcon = document.getElementById('playPauseIcon');

    function togglePlayPause(event, videoId) {
    event.preventDefault(); // Prevent default behavior
    const video = document.getElementById('video_' + videoId);
    const playPauseIcon = document.getElementById('playPauseIcon_' + videoId);

    if (video.paused) {
        // If the video is paused, play the video and show the pause icon
        video.play();
        playPauseIcon.classList.remove('fa-play');
        document.getElementById('playPauseBtn_' + videoId).style.display = 'none';
        // playPauseIcon.classList.add('fa-pause');
    } else {
        // If the video is playing, pause the video and show the play icon
        video.pause();
        document.getElementById('playPauseBtn_' + videoId).style.display = 'block';

        playPauseIcon.classList.remove('fa-pause');
        playPauseIcon.classList.add('fa-play');
    }
}

// Bind click event to the video itself to pause on click
document.querySelectorAll('video').forEach(video => {
    video.addEventListener('click', function() {
        togglePlayPause(event, video.id.replace('video_', ''));

    });
});

  </script>
</body>

</html>