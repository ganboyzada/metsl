@extends('metsl.layouts.master')

@section('title', 'Punch List - Create')

@section('content')
<style>
    [type=radio]:checked+img{
        border: 4px solid red !important;
    }
    </style>

<style>
    #image-container {
      position: relative;
      display: inline-block;
      border: 1px solid #ccc;
    }
    #myImage {
      max-width: 100%;
      height: auto;
      display: block;
    }

    #coords-list {
      margin-top: 20px;
      font-family: monospace;
    }


    .pin {
  /*position: absolute;*/
  width: 34px;
  height: 34px;
  background-image: url({{ asset("images/marker-icon.png") }}); /* 🔁 Replace with your file */
  background-size: cover;
  background-repeat: no-repeat;
  /*transform: translate(-50%, -100%); *//* Tip of marker points to click */
  cursor: pointer;
  z-index: 10000000;

}
.pin-wrapper {
  position: absolute;
  cursor: pointer;
}

.pin-label {
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0, 0, 0, 0.75);
  color: #fff;
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 12px;
  white-space: nowrap;
  bottom: -27px;



  opacity: 0;
  pointer-events: none;
  transition: opacity 0.2s;
}
.pin-wrapper:hover .pin-label,
.pin-label.always-visible {
  opacity: 1;
  pointer-events: auto;
}


.choices {
    z-index:0 !important;

}

  </style>

<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Add a Punch Item</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
	<form id="snag-item-form" class="space-y-6"  method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="project_id" value="{{ \Session::get('projectID') }}"/>

            <input type="hidden" name="pin_x"/>
            <input type="hidden" name="pin_y"/>       

            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                <!-- Title (Required) -->
                <div class="sm:col-span-1">
                    <label for="title" class="block text-sm mb-2 font-medium dark:text-gray-200">Title <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="title" name="title"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter title"
                        required
                    />
                </div>

                <!-- Number (#) (Required) -->
                <div class="sm:col-span-1">
                    <label for="number" class="block text-sm mb-2 font-medium dark:text-gray-200">Number (#) <span class="text-red-500">*</span></label>
                    <input
                        type="text" readonly
                        id="number" name="number"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter number"
                        required
                    />
                </div>

                <!-- Responsible Member (Single Selector) (Required) -->
                <div class="md:col-span-1">
                    <label for="responsible-member" class="block text-sm mb-2 font-medium dark:text-gray-200">Responsible Member <span class="text-red-500">*</span></label>
                    <select id="responsible-member" name="responsible_id" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200" required>
                
                    </select>
                </div>

                <!-- Priority -->
                <div  class="sm:col-span-1">
                    <label for="priority" class="block text-sm mb-2 font-medium dark:text-gray-200">Priority</label>
                    <select id="priority" name="priority" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
                        @php
                        $status_list = \App\Enums\PunchListPriorityEnum::cases();
                        @endphp
                        @foreach ($status_list as $status)
                            <option value="{{$status->value}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Distribution Members (Multiple Selector) -->
     

                <!-- Location -->
                <div class="md:col-span-1">
                    <label for="location" class="block text-sm mb-2 font-medium dark:text-gray-200">Location</label>
                    <input
                        type="text"
                        id="location" name="location"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter location"
                    />
                </div>

                <div class="md:col-span-1">
                    <label for="due_days" class="block text-sm mb-2 font-medium dark:text-gray-200">Due Days</label>
                    <select id="due_days" required name="due_days" class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200">
                        <option value="1">1 day</option>
                        <option value="2">2 day</option>
                        <option value="3">3 day</option>
                        <option value="4">4 day</option>
                        <option value="5">5 day</option>
                        <option value="7">7 day</option>
                        <option value="14">14 day</option>
                        <option value="21">21 day</option>
                        <option value="30">30 day</option>

                    </select>
            
                </div>	
            </div>
            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">    
                
                <div class="sm:col-span-2">
                    <label for="distribution-members" class="block text-sm mb-2 font-medium dark:text-gray-200">Distribution Members</label>
                    <select id="distribution-members"  name="participates[]" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
                
                    </select>
                </div>                
                <div class="sm:col-span-2">
                    <label for="linked_documents" class="block text-sm font-medium mb-1">Linked Documents</label>
                    <select id="linked_documents" name="linked_documents[]" multiple class="w-full"></select>
                </div>


                <!-- Submit Button -->
             
            </div>

            <div class="flex flex-wrap md:flex-nowrap items-start gap-6">

          
                <div class="w-full md:w-2/5 mb-4">
                    <label for="description" class="block text-sm mb-2 dark:text-gray-200">Description</label>
                    <textarea
                        id="description" name="description"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        rows="4"
                        placeholder="Enter description"
                    ></textarea>
                </div>




                <!-- Attachments (Dropzone) -->
                <div  class=" w-full md:w-2/5 mb-4">
                    <label class="block mb-2 text-sm">Attachments (PDF, JPG, JPEG, PNG)</label>
                    <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                        <div class="flex flex-col items-center justify-center">
                            <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                            <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG (max. 10MB)</p>
                        </div>
                    <input id="file-upload" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps"  name="docs[]" type="file" class="hidden" multiple>
                    </div>
                    <ul id="file-list" class="mt-4 space-y-2">
                        <!-- Uploaded files will appear here -->
                    </ul>
                </div>
            

        </div>


   

        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        <div class="sm:col-span-1">
            <label for="drawings_search" class="block text-sm mb-2 font-medium dark:text-gray-200">Search Drawing Title</label>
            <input
                type="text" oninput="searchDrawings(this.value)"
                id="drawings_search" name="drawings_search"
                class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                placeholder="Enter drawings search"
                
            />
        </div>
        </div>
        
        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 border-2 border-dotted overflow-y-auto p-5" 
        style="height:300px;" id="drawing_list">

            @if (isset($drawings) && $drawings->count() > 0)
                @foreach ($drawings as $drawing)
                <div class="sm:col-span-1 text-center" id="draw{{ $drawing->id }}">
                    <label class="relative cursor-pointer group">
                        <!-- Hidden checkbox -->
                        <input type="radio" id="{{ $drawing->id }}" name="drawing_id" value="{{ $drawing->id }}" class="peer absolute opacity-0 w-0 h-0" />
                    
                        <!-- Image -->
                        <img onclick="get_image({{ $drawing->id }} , '{{ Storage::url('project'.$drawing->project_id.'/drawings/'.$drawing->image) }}')"
                          alt="Image 1"
                          class="rounded-lg border-4 border-transparent peer-checked:border-blue-500 transition drawing"
                          style="width:30%;height:150px;margin:auto; " src="{{ Storage::url('project'.$drawing->project_id.'/drawings/'.$drawing->image) }}"
            
            
                        />
                        <a target="_blank" href="{{ Storage::url('project'.$drawing->project_id.'/drawings/'.$drawing->image) }}">
                            {{ $drawing->title }}</a>
                
                      </label>   
                        
                    
            
                </div>
                    
                @endforeach
                
            @endif


        </div>
        <button
        type="submit"
        class="submit_punch_list_form px-4 py-2 mt-5 bg-blue-500 text-white hover:bg-blue-600"
    >
        Submit Item
    </button>

    </form>

    <div id="roleAssignmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 max-h-[90vh] overflow-y-scroll p-6 max-w-7xl">
            <h3></h3>
            <div id="image-container">
              <img src="" id="myImage" alt="Image">
            </div>
            


            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeRoleAssignmentModal()" class="text-gray-600 dark:text-gray-300 mr-3">Save</button>
            </div>
        
        </div>
    </div>

</div>


<script>
    	
        document.addEventListener('DOMContentLoaded', () => {
		distribution_obj = populateChoices2('distribution-members', [], true);	
		reviewers_obj = populateChoices2('responsible-member', []);		
        linked_documents = populateChoices2('linked_documents', [], false);		

		
    }); 
    
   function createDraggablePin(xPercent, yPercent , labelcontent , number) {

        const wrapper = document.createElement('div');
        if(labelcontent != null){
            wrapper.classList.add('pin-wrapper');
        }else{
            wrapper.classList.add('pin-wrapper');
            wrapper.classList.add('pin-wrapper2');

        }
        
        wrapper.style.position = 'absolute';
        wrapper.style.left = `${xPercent}%`;
        wrapper.style.top = `${yPercent}%`;
        wrapper.style.transform = 'translate(-50%, -100%)';



        const pin = document.createElement('img');
        pin.src = '{{ asset("images/marker-icon.png") }}'; // Replace with your marker
        pin.classList.add('pin');
        //pin.style.position = 'relative';
        //pin.style.width = '24px';
        //pin.style.height = '24px';
        //pin.style.transform = 'translate(-50%, -100%)';
        pin.style.left = `${xPercent}%`;
        pin.style.top = `${yPercent}%`;
        //container.appendChild(pin);
        wrapper.appendChild(pin);
        if(labelcontent != null){
            const label = document.createElement('span');
            label.classList.add('pin-label');
            label.innerHTML  = `Number ${number} <a href="{{ url('/project/punch-list/edit') }}/${labelcontent}" target="_blank">View Details</a>`;
            label.classList.add('pin-label', 'always-visible');

            wrapper.appendChild(label);

            label.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent pin/image click handlers
            });
            });
        }


    
        container.appendChild(wrapper);



        // Drag support
        let isDragging = false;
        let wasDragged = false;
        let currentDraggedWrapper = null;

        let pin__x = null;
        let pin__y = null;

//         pin.addEventListener('mousedown', (e) => {
//         isDragging = true;
//         wasDragged = false;
//         currentDraggedWrapper = wrapper;
//         e.preventDefault();
//         e.stopPropagation();
//         });

//         document.addEventListener('mousemove', (e) => {
//             if (!isDragging || !currentDraggedWrapper) return;

//             wasDragged = true; // Mark that the mouse moved

//             const rect = image.getBoundingClientRect();
//             const x = e.clientX - rect.left;
//             const y = e.clientY - rect.top;

//             const xPercent = (x / rect.width) * 100;
//             const yPercent = (y / rect.height) * 100;

//             pin__x = xPercent;
//             pin__y = yPercent;

//             currentDraggedWrapper.style.left = `${xPercent}%`;
//             currentDraggedWrapper.style.top = `${yPercent}%`;

//             if (labelcontent == null) {
//                 $('[name="pin_x"]').val(xPercent);
//                 $('[name="pin_y"]').val(yPercent);
//             }
//         });


//         document.addEventListener('mouseup', () => {
//     if (!wasDragged || !isDragging || !currentDraggedWrapper) {
//         isDragging = false;
//         currentDraggedWrapper = null;
//         return;
//     }

//     isDragging = false;
//     currentDraggedWrapper = null;

//     if (labelcontent != null) {
//         $.ajaxSetup({
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//             }
//         });
//         $.ajax({
//             url: "{{ route('projects.punch-list.update_pin') }}",
//             type: "POST",
//             data: {
//                 id: labelcontent,
//                 pin_x: pin__x,
//                 pin_y: pin__y,
//                 "_token": "{{ csrf_token() }}"
//             },
//             dataType: 'json',
//             success: function(data) {
//                 if (data.success) {
//                     $('.success').show();
//                     $('.success').html('<div class="text-white-500 px-2 py-1 text-sm font-semibold">Pin coordination has been changed for punch number ' + number + '</div>');
//                 } else if (data.error) {
//                     $('.error').show();
//                     $('.error').html('<div class="text-white-500 px-2 py-1 text-sm font-semibold">' + data.error + '</div>');
//                 }
//             },
//             error: function(err) {
//                 $.each(err.responseJSON.errors, function(key, value) {
//                     $('.error').show();
//                     $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
//                     var el = $(document).find('[name="' + key + '"]');
//                     el.after($('<div class="err-msg text-red-500 px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
//                 });
//             }
//         });
//     }
// });

    // Optional: remove on click
    let user  = '{{ auth()->user()->is_admin }}';
    if(user == 1){

        pin.addEventListener('click', (e) => {
            e.stopPropagation();
            if(labelcontent == null){
                wrapper.remove();

            }else{
                const confirmed = confirm('Are you sure you want to delete this punch?');
                if (confirmed) {
                    $('.error').hide(); 
                    $('.success').hide();

                    wrapper.remove();


                    let url =`/project/punch-list/destroy/${labelcontent}`;		
                    let fetchRes =  fetch(url);
                    console.log(fetchRes);
                        
                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
                    
                    
                }
            }

        });

        
    }

    return wrapper;
}


    const container = document.getElementById('image-container');
    const image = document.getElementById('myImage');


    let imageLoaded = false; // Track if listener already added

    async function get_image(id , image_url){

        let savedPins = [];
       let fetchRes = await fetch(`{{url('project/punch-list/drawingImage/${id}')}}`);
       const all = await fetchRes.json();


        $('#myImage').attr('src', image_url);



        savedPins = all;
        console.log(savedPins);

        // image.addEventListener('load', () => {
        //     savedPins.forEach(coord => {
        //         createDraggablePin(coord.x, coord.y , coord.id , coord.number);
        //     });
        // });


        image.onload = () => {
            // Clear existing pins before adding new ones
            document.querySelectorAll('.pin-wrapper').forEach(el => el.remove());

            savedPins.forEach(coord => {
                createDraggablePin(coord.x, coord.y , coord.id , coord.number);
            });
        };

        document.getElementById("roleAssignmentModal").classList.remove("hidden");
    }


    
    const pins = []; // Store pin coordinates
            let currentPin = null; // Holds the last placed pin
            image.addEventListener('click', function (e) {
                const rect = image.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const xPercent = (x / rect.width) * 100;
                const yPercent = (y / rect.height) * 100;

                // 🔄 Remove previous pin if exists
                if (currentPin) {
                    currentPin.remove();
                    
                }

                currentPin = createDraggablePin(xPercent, yPercent , null , null);
                $('[name="pin_x"]').val(xPercent);
                $('[name="pin_y"]').val(yPercent);
                //alert(xPercent.toFixed(2)+'//'+yPercent.toFixed(2));
                // Save and show coordinates
                // const coords = { x: xPercent.toFixed(2), y: yPercent.toFixed(2) };
                // pins.push(coords);

                // const listItem = document.createElement('li');
                // listItem.textContent = `Pin ${pins.length}: x = ${coords.x}%, y = ${coords.y}%`;
                // logList.appendChild(listItem);


            // console.log(x+'//'+y);
            });




    function closeRoleAssignmentModal() {
        document.getElementById("roleAssignmentModal").classList.add("hidden");
    }
function searchDrawings(search){
    let html=``;
    $.ajax({
        url: "{{ route('projects.punch-list.drawings.search') }}",
        type: "GET",
        data: {search:search},
        dataType: 'json',
        success: function(list) {
            if(list.length > 0){
                for(let i=0;i<list.length;i++){

                    html+=`   <div class="sm:col-span-1 text-center" id="draw${list[i].id}">
                    <label class="relative cursor-pointer group">
                        <!-- Hidden checkbox -->
                        <input type="radio" id="${list[i].id}" name="drawing_id" value="${list[i].id}" class="peer absolute opacity-0 w-0 h-0" />
                    
                        <!-- Image -->
                        <img  onclick="get_image(${list[i].id} , '${list[i].image}')"
                          alt="Image 1"
                          class="rounded-lg border-4 border-transparent peer-checked:border-blue-500 transition drawing"
                          style="width:30%;height:150px;margin:auto; " src="${list[i].image}"
            
            
                        />
                        <a target="_blank" href="${list[i].image}">
                            ${list[i].title}</a>
                
                      </label>   
                        
                    
            
                </div>`;
                }

            }

           // 
           

                $("#drawing_list").html(html);
        }
    })
}

    $("#snag-item-form").on("submit", function(event) {

        if($('[name="pin_x"]').val() == '' ||  $('[name="pin_y"]').val() == '' ){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">Please Chose Drawing and set The coordinations</div>');
            event.preventDefault();

        }else{
            const form = document.getElementById("snag-item-form");
            const formData = new FormData(form); 
            formData.append('description',tinyMCE.get('description').getContent());
        
            $('.error').hide();
            $('.success').hide();
            $('.err-msg').hide();
            $(".error").html("");
            $(".success").html("");
            event.preventDefault();  
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('projects.punch-list.store') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $(".submit_punch_list_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                        
                        $(".submit_punch_list_form").prop('disabled', false);
                        
                        $("#snag-item-form")[0].reset();
                        
                        window.scrollTo(0,0);

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
                        
                        $('#file-list').html('');
                        setInterval(function() {
                            window.location.href="{{ route('home') }}";
                        }, 3000);						


                    }
                    else if(data.error){
                        $(".submit_punch_list_form").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                        
                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');

                            var el = $(document).find('[name="'+key + '"]');
                            el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            // if(el.length == 0){
                            //     el = $(document).find('#file-upload');
                            //     el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents required </div>'));
                                
                            // }
                            
                        });

                        $(".submit_punch_list_form").prop('disabled', false);


                }
            });

        }
    
    });
	  

	$(".projectButton").on('click',function(event) {
		if(localStorage.getItem("project_tool") == 'punch_list'){
			get_participates();
		}
		
	});



    async  function get_participates(){

        
		let fetchRes = await fetch(`{{url('project/punch-list/participates')}}`);
		const all = await fetchRes.json();
		$('[name="number"]').val(all.next_number);

		let reviewers = all.distribution_members.map(function(item) {
		  return {'value' : item.id , 'label' : item.name};
		});
			distribution_obj.clearStore();
			distribution_obj.setChoices(reviewers);	


			reviewers = all.responsible.map(function(item) {
			  return {'value' : item.id , 'label' : item.name , 'selected' : true};
			});	
			reviewers_obj.clearStore();
			reviewers_obj.setChoices(reviewers);


            let files =  {!! json_encode($files) !!};
			const allfiles = files.map(function(item) {
			  return {'value' : item.file_id+'-'+item.revisionid  , 'label' : item.project_document.number};
			});	
			linked_documents.clearStore();
			linked_documents.setChoices(allfiles);	
		
	}
			

	get_participates();

	

		



</script>
@endsection