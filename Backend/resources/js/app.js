/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

// app.mount('#app');






// / Get the modal and buttons
    
// / modal and buttons

$(document).ready(function(){   
    $('.select2').select2();
})


        var toggler = document.getElementsByClassName("caret");
        var i;

        for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
        this.parentElement.querySelector(".nested").classList.toggle("active");
        this.classList.toggle("caret-down");
        });
        }
        
   


$(document).ready(function() {
    $('.delete-form').click(function(event) {
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
                            loadQuillEditor();
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

   
    // $('.update-form').click(function(event) {
    //             event.preventDefault(); 
    //             var id = $(this).attr('id');
    //             var name= $(this).attr('data-name');
    //             $.ajax({
    //                 type: 'GET',
    //                 url: '/edit/' + id,
    //                 data:{name:name},
    //                 success: function(response) {
    //                 $('#ajaxobjdef').css('display','block');
    //                 $('#objdef').css('display','none');
    //                 $('#objhierarchy').css('display','none');
    //                 $('#ajaxobjdef').html(response);
    //                 $('.select2').select2();
    //                 },
    //                 error: function(error) {
    //                     console.log('Error:', error);
    //                 }
    //             });
    //         });
      
    $('#selectDropdownval').on('change', function () {
        var selectedValue = $(this).val();
        var url='/get-data/' + selectedValue ;
        $.ajax({
            url: url,
            type: 'GET', 
            success: function (response) {
                $('#ajaxdata').css('display','block');
                $('#myUL').css('display','none');
                $('#ajaxdata').html(response);
                $('.select2').select2();

                var toggler = document.getElementsByClassName("caret");
                var i;
        
                for (i = 0; i < toggler.length; i++) {
                toggler[i].addEventListener("click", function() {
                this.parentElement.querySelector(".nested").classList.toggle("active");
                this.classList.toggle("caret-down");
                });
                }
            },
        });
        
    });
});
$(document).on('click', '.update-form', function(event) {
    event.preventDefault(); 
    var id = $(this).attr('id');
    var name = $(this).attr('data-name');

    $.ajax({
        type: 'GET',
        url: '/edit/' + id,
        data: { name: name },
        success: function(response) {
            // Check if #ajaxobjdef exists within a wrapper, else create it inside a suitable container
            if ($('#ajaxobjdef').length === 0) {
                $('.custom-column').append('<div id="ajaxobjdef"></div>'); 
            }

            // Append response to #ajaxobjdef
            $('#ajaxobjdef').html(response);

            // Show #ajaxobjdef
            $('#ajaxobjdef').show();

            // Hide all sibling elements of #ajaxobjdef except scripts
            $('#ajaxobjdef').siblings().not('script').hide();

            // Reinitialize Select2 if needed
            $('.select2').select2();
        },
        error: function(error) {
            console.log('Errors:', error);
        }
    });
});
// $(document).on('click', '.update-form', function(event) {

//         event.preventDefault(); 
//         var id = $(this).attr('id');
//         var name= $(this).attr('data-name');
//         $.ajax({
//             type: 'GET',
//             url: '/edit/' + id,
//             data:{name:name},
//             success: function(response) {
//             $('#ajaxobjdef').css('display','block');
//             $('#objdef').css('display','none');
//             $('#objhierarchy').css('display','none');
//             $('#ajaxobjdef').html(response);
//             $('.select2').select2();
//             },
//             error: function(error) {
//                 console.log('Error:', error);
//             }
//         });
// });


    document.addEventListener("DOMContentLoaded", function() {
        // var quill = new Quill('#editor', {
        //     theme: 'snow',
        //     modules: {
        //         toolbar: [
        //             [{ 'header': '1'}, {'header': '2'}, { 'font': [] }],
        //             ['bold', 'italic', 'underline', 'strike'],
        //             [{'list': 'ordered'}, {'list': 'bullet'}],
        //             ['link', 'image', 'blockquote', 'code-block'],
        //             [{ 'align': [] }],
        //             ['clean'],
        //         ]
        //     },
        //     readOnly: false
        // });
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'size': [] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'align': [] }],
                    [{'list': 'ordered'}, {'list': 'bullet'}, {'list': 'check'}],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean'],
                    [{ 'indent': '-1' }, { 'indent': '+1' }], // indent
                ]
            }
        });
        // Set the initial content of the Quill editor
        var initialContent = document.getElementById('editorContent').value;
        quill.clipboard.dangerouslyPasteHTML(initialContent);
        // Capture Quill content and set it as the value of the hidden input
        quill.on('text-change', function() {
            var content = quill.root.innerHTML;
            document.getElementById('editorContent').value = content;
        });
    });



   
// document.querySelectorAll('.dropdown-toggle').forEach(item => {
//           item.addEventListener('click', event => {
         
//             if(event.target.classList.contains('dropdown-toggle') ){
//               event.target.classList.toggle('toggle-change');
//             }
//             else if(event.target.parentElement.classList.contains('dropdown-toggle')){
//               event.target.parentElement.classList.toggle('toggle-change');
//             }
//           })
//         });
         
//             /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
//             var dropdown = document.getElementsByClassName("dropdown-btn");
//             var i;
           
//             for (i = 0; i < dropdown.length; i++) {
//               dropdown[i].addEventListener("click", function() {
//                 this.classList.toggle("active");
//                 var dropdownContent = this.nextElementSibling;
//                 if (dropdownContent.style.display === "block") {
//                   dropdownContent.style.display = "none";
//                 } else {
//                   dropdownContent.style.display = "block";
//                 }
//               });
//             }



// Add an event listener to all elements with the class "fa-angle-down"
document.querySelectorAll('.fa-angle-down').forEach(item => {
  item.addEventListener('click', event => {
    // Find the closest parent with the class "dropdown-btn"
    const dropdownBtn = event.target.closest('.dropdown-btn');
    
    // If found, toggle the active class and display property of the next sibling
    if (dropdownBtn) {
      dropdownBtn.classList.toggle('active');
      const dropdownContent = dropdownBtn.nextElementSibling;
      if (dropdownContent.style.display === 'block') {
        dropdownContent.style.display = 'none';
      } else {
        dropdownContent.style.display = 'block';
      }
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
  // Find the first dropdown button and hide it
  const firstDropdownBtn = document.querySelector('.dropdown-btn');
  firstDropdownBtn.style.display = 'none';

  // Find the first dropdown button and its content
  const firstDropdownContent = firstDropdownBtn.nextElementSibling;

  // Add the "active" class and set display to "block"
  firstDropdownContent.style.display = 'block';
});


// document.addEventListener('DOMContentLoaded', function() {
//   // Find the first dropdown button and its content
//   const firstDropdownBtn = document.querySelector('.dropdown-btn');
//   const firstDropdownContent = firstDropdownBtn.nextElementSibling;

//   // Add the "active" class and set display to "block"
//   firstDropdownBtn.classList.add('active');
//   firstDropdownContent.style.display = 'block';
// });

    // var content = quill.root.innerHTML;

    

    // var modal = document.getElementById("myModal");
    // var openModalButton = document.getElementById("openModalButton");
    // var closeModalButton = document.getElementById("closeModalButton");
     
     
    // // Open the modal when the button is clicked
    // openModalButton.addEventListener("click", function() {
    //    modal.style.display = "flex";
    // });
     
    // // Close the modal when the close button is clicked
    // closeModalButton.addEventListener("click", function() {
    //    modal.style.display = "none";
    // });
     
    // // Close the modal when the user clicks outside of it
    // window.addEventListener("click", function(event) {
    //    if (event.target == modal) {
    //        modal.style.display = "none";
    //    }
    // });
