@extends('metsl.layouts.master')

@section('title', 'Correspondence - Create')

@section('content')
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
<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
<div class="flex items-end mb-3">
    <h1 class="text-lg dark:text-gray-200">{{  $punch_list->title }} / <b>{{$punch_list->number}}</b></h1>
    @if ($punch_list->status_val != 2)
    @if ((auth()->user()->is_admin || $punch_list->created_by == auth()->user()->id))
        <div class="ml-auto relative has-dropdown">
            <button type="button"
                class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 focus:outline-none"
                >
                <i data-feather="loader" class="mr-2"></i>
                Action 		

            </button>
            <!-- Dropdown Menu -->
            <div
                class="dropdown absolute right-0 mt-2 w-48 bg-gray-800 text-gray-200  shadow-lg"
            >
                <button  data-modal="uploader-modal" class="modal-toggler  flex px-4 py-2 hover:bg-gray-700">
                    <i data-feather="corner-up-left" class="mr-2"></i> <span class="hidden md:inline">Add Reply</span>
                </button> 


            </div>
        </div>
    @elseif((checkIfUserHasThisPermission(Session::get('projectID') ,'responsible_punch_list') ||
    checkIfUserHasThisPermission(Session::get('projectID') ,'distribution_members_punch_list')
    ) && $punch_list->status_val  == 0)
            <div class="ml-auto relative has-dropdown">
                <button type="button"
                    class="dropdown-toggle flex items-center px-4 py-2 bg-blue-500 text-white  hover:bg-blue-600 focus:outline-none"
                    >
                    <i data-feather="loader" class="mr-2"></i>
                    Action 		

                </button>
                <!-- Dropdown Menu -->
                <div
                    class="dropdown absolute right-0 mt-2 w-48 bg-gray-800 text-gray-200  shadow-lg"
                >
                    <button  data-modal="uploader-modal" class="modal-toggler  flex px-4 py-2 hover:bg-gray-700">
                        <i data-feather="corner-up-left" class="mr-2"></i> <span class="hidden md:inline">Add Reply</span>
                    </button> 


                </div>
            </div>               
    @endif
    

    @endif





</div>


<!-- Correspondence Information -->
 <div class="pt-4 bg-white dark:bg-gray-900 ">

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
        <!-- Number -->
        <div class="sm:col-span-1">
            <h3 class="text-sm font-medium dark:text-gray-400">Number</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->number}}</p>
        </div>

        <!-- Subject -->
        <div class="sm:col-span-1">
            <h3 class="text-sm font-medium dark:text-gray-400">Subject</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->title}}</p>
        </div>

        <!-- Status -->
        <div class="sm:col-span-1">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Status</h3>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $punch_list->status->color()}}">{{$punch_list->status->name}}</span>

        </div>

        <!-- Programme Impact -->
        <div class="sm:col-span-1">
            <h3 class="text-sm font-medium dark:text-gray-400">priority</h3>
            {!! $punch_list->priority->color()   !!}
        </div>

        <!-- Cost Impact -->
        <div class="sm:col-span-1">
            <h3 class="text-sm font-medium dark:text-gray-400">Location</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->location}}</p>
        </div>


        <div class="sm:col-span-1">
            <h3 class="text-sm font-medium dark:text-gray-400">Due Date</h3>
            <p class="text-lg font-semibold dark:text-gray-200">{{$punch_list->due_date}}</p>
        </div>


        <!-- Assignees -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Responsible</h3>
			
			
            <div class="flex flex-wrap gap-4">
			
                <div class="flex items-center">
                    <img src="{{$punch_list->responsible->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                    <p class="  dark:text-gray-200">{{$punch_list->responsible->userable->first_name}} {{$punch_list->responsible->userable->last_name}}</p>
                </div>		
			
            </div>
        </div>

        <!-- Distribution Members -->
        <div class="mb-6">
            <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Distribution Members</h3>
            <div class="flex flex-wrap gap-4">
			@if($punch_list->users->count() > 0)
				@foreach($punch_list->users as $user)
					<div class="flex items-center">
						<img src="{{$user->userable->image}}" alt="Profile" class="w-10 h-10 rounded-full mr-4">
                        <p class="  dark:text-gray-200">{{$user->userable->first_name}} {{$user->userable->last_name}}</p>
					</div>
					
				@endforeach
				
			@endif	
            </div>
        </div>

        <div>
            <h3 class="text-sm font-medium dark:text-gray-400 mb-1">Description</h3>
            <p class="text-lg dark:text-gray-200">{!! $punch_list->description   !!}.</p>
        </div>
        

    </div>

    <!-- Description -->
    <div class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        
            <div  class=" sm:col-span-2 mb-6">
                <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Linked Documents</h3>
                <div class="grid grid-cols-2 gap-4">
                @if($punch_list->documentFiles->count() > 0)
                    @foreach($punch_list->documentFiles as $file)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                            <div class="flex items-center">
                                <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                                <p class="text-sm dark:text-gray-200">{{$file->file}}</p>
                            </div>
                            @if($file->pivot->revision_id == NULL || $file->pivot->revision_id == 0)
                                <a target="_blank" href="{{Storage::url('project'.$punch_list->project_id.'/documents'.$file->project_document_id.'/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
                           
                            @else
                            <a target="_blank" href="{{Storage::url('project'.$punch_list->project_id.'/documents'.$file->project_document_id.'/revisions/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
    
                            @endif
                        </div>
            
                
                    @endforeach
                    
                
                @endif
                </div>
            </div>
            <div  class=" sm:col-span-2 mb-6">
                <h3 class="text-sm font-medium dark:text-gray-400 mb-2">Attached Files</h3>
                <div class="grid grid-cols-2 gap-4">
                @if($punch_list->files->count() > 0)
                    @foreach($punch_list->files as $file)
                        <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                            <div class="flex items-center">
                                <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                                <p class="text-sm dark:text-gray-200">{{$file->file}}</p>
                            </div>
                            <a target="_blank" href="{{Storage::url('project'.$punch_list->project_id.'/punch_list'.$punch_list->id.'/'.$file->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
                        </div>            
                    @endforeach
                @endif
                </div>
            </div>

       
        </div>


        @if (isset($punch_list->drawing))
        <h2 class="text-2xl font-semibold mb-6 dark:text-gray-200">drawing</h2>
        @endif        
        <div class="w-full border-2 border-dotted overflow-y-auto p-5" style="position: relative; height: auto; display: flex; justify-content: center; align-items: center;">
            <div id="image-container" style="position: relative;">
                <img src="{{ Storage::url('project'.$punch_list->drawing->project_id.'/drawings/'.$punch_list->drawing->image) }}" id="myImage" alt="Image">
              </div>


        </div>
    </div>

    <!-- Attachments -->
    <div class="mb-4">
        
    </div>

    <h3 class="font-medium dark:text-gray-400 mb-2">Replies</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border dark:border-gray-800">
            <thead class="bg-gray-100 dark:bg-gray-800 text-sm text-left">
                <tr>
                    <th class="px-6 py-3 font-light">Subject</th><!-- WILL HAVE LINK TO REDIRECT (target="_blank") -->
                    <th class="px-6 py-3 font-light">description</th>
                    <th class="px-6 py-3 font-light">Created By</th>
                    <th class="px-6 py-3 font-light">Created Date</th>
                   
                    <th class="px-6 py-3 font-light">file</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @if ($punch_list->replies->count() > 0)
                @foreach ($punch_list->replies as $reply)                
                    <tr class="border dark:border-gray-800">
                        <td class="px-6 py-4">{{$reply->title}}</td>
                        <td class="px-6 py-4">{!! $reply->description !!}</td>
                        <td class="px-6 py-4">{{$reply->user->name}}</td>
                        <td class="px-6 py-4">{{$reply->created_date}}</td>
                        <td class="px-6 py-4">
                            @if ($reply->file != NULL)
                                <div class="bg-gray-100 dark:bg-gray-800 p-4  flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i data-feather="file" class="w-6 h-6 mr-3 dark:text-gray-400"></i>
                                        <p class="text-sm dark:text-gray-200">{{$reply->file}}</p>
                                    </div>

                                    <a target="_blank" href="{{Storage::url('project'.$punch_list->project_id.'/punch_list'.$punch_list->id.'/replies/'.$reply->file)}}" class="text-blue-500 hover:underline"><i data-feather="arrow-down-circle"></i></a>
                                </div>                                 
                            @endif

                        </td>
                       
                    </tr>
                @endforeach
                
            @endif
               
                <!-- Rows will be dynamically loaded -->
            </tbody>
        </table>
    </div>
</div>

@if ($punch_list->status_val != 2)
    @if ((auth()->user()->is_admin || $punch_list->created_by == auth()->user()->id))
        @include('metsl.pages.punch-list.addReply')
    @elseif((checkIfUserHasThisPermission(Session::get('projectID') ,'responsible_punch_list') ||
    checkIfUserHasThisPermission(Session::get('projectID') ,'distribution_members_punch_list')
    ) && $punch_list->status_val  == 0)
        @include('metsl.pages.punch-list.addReply')              
    @endif


@endif


<script>
    function createDraggablePin(xPercent, yPercent , labelcontent , number) {
        //alert(number);
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
        //wrapper.style.transform = 'translate(-50%, -100%)';



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

        // pin.addEventListener('mousedown', (e) => {
        //     isDragging = true;
        //     wasDragged = false;
        //     currentDraggedWrapper = wrapper;
        //     e.preventDefault();
        //     e.stopPropagation();
        // });

        // document.addEventListener('mousemove', (e) => {
        //     if (!isDragging || !currentDraggedWrapper) return;

        //     wasDragged = true; // Mark that the mouse moved

        //     const rect = image.getBoundingClientRect();
        //     const x = e.clientX - rect.left;
        //     const y = e.clientY - rect.top;

        //     const xPercent = (x / rect.width) * 100;
        //     const yPercent = (y / rect.height) * 100;

        //     pin__x = xPercent;
        //     pin__y = yPercent;

        //     currentDraggedWrapper.style.left = `${xPercent}%`;
        //     currentDraggedWrapper.style.top = `${yPercent}%`;

        
        // });


        // document.addEventListener('mouseup', () => {
        //     if (!wasDragged || !isDragging || !currentDraggedWrapper) {
        //     isDragging = false;
        //     currentDraggedWrapper = null;
        //     return;
        //     }

        //     isDragging = false;
        //     currentDraggedWrapper = null;

        //     if (labelcontent != null) {
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{ route('projects.punch-list.update_pin') }}",
        //         type: "POST",
        //         data: {
        //             id: labelcontent,
        //             pin_x: pin__x,
        //             pin_y: pin__y,
        //             "_token": "{{ csrf_token() }}"
        //         },
        //         dataType: 'json',
        //         success: function(data) {
        //             if (data.success) {
        //                 $('.success').show();
        //                 $('.success').html('<div class="text-white-500 px-2 py-1 text-sm font-semibold">Pin coordination has been changed for punch number ' + number + '</div>');
        //             } else if (data.error) {
        //                 $('.error').show();
        //                 $('.error').html('<div class="text-white-500 px-2 py-1 text-sm font-semibold">' + data.error + '</div>');
        //             }
        //         },
        //         error: function(err) {
        //             $.each(err.responseJSON.errors, function(key, value) {
        //                 $('.error').show();
        //                 $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
        //                 var el = $(document).find('[name="' + key + '"]');
        //                 el.after($('<div class="err-msg text-red-500 px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
        //             });
        //         }
        //     });
        //     }
        // });
        let user  = '{{ auth()->user()->is_admin }}';
        if(user == 1){
            // Optional: remove on click
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
                    //console.log(fetchRes);
                        if(labelcontent == current_punchlist_id){
                            $('.success').show();
                            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
                            setInterval(function() {
                                window.location.href = "{{ route('home') }}";
                            }, 3000);	
                        }else{
                            $('.success').show();
                            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
                    
                        }
        
                    
                }
            }

            });


        }

            

        return wrapper;
    }


    const container = document.getElementById('image-container');
    const image = document.getElementById('myImage');

    let current_punchlist_id = "{{ $punch_list->id }}";
    let imageLoaded = false; // Track if listener already 
    get_image("{{ $punch_list->drawing_id??0 }}");
    
    async function get_image(id){

        let savedPins = [];
        let fetchRes = await fetch(`{{url('project/punch-list/drawingImage/${id}/${current_punchlist_id}')}}`);
        const all = await fetchRes.json();

        savedPins = all;

        //console.log(savedPins);



        // Clear existing pins before adding new ones
        document.querySelectorAll('.pin-wrapper').forEach(el => el.remove());

        savedPins.forEach(coord => {
           // alert(coord.y);
            createDraggablePin(coord.x, coord.y , coord.id , coord.number);
        });
        


    }



const pins = []; // Store pin coordinates
    let currentPin = null; // Holds the last placed pin
    // image.addEventListener('click', function (e) {
    //     const rect = image.getBoundingClientRect();
    //     const x = e.clientX - rect.left;
    //     const y = e.clientY - rect.top;

    //     const xPercent = (x / rect.width) * 100;
    //     const yPercent = (y / rect.height) * 100;

    //     // 🔄 Remove previous pin if exists
    //     if (currentPin) {
    //         currentPin.remove();
            
    //     }

    //     currentPin = createDraggablePin(xPercent, yPercent , null , null);
    //     $('[name="pin_x"]').val(xPercent);
    //     $('[name="pin_y"]').val(yPercent);
    //     //alert(xPercent.toFixed(2)+'//'+yPercent.toFixed(2));
    //     // Save and show coordinates
    //     // const coords = { x: xPercent.toFixed(2), y: yPercent.toFixed(2) };
    //     // pins.push(coords);

    //     // const listItem = document.createElement('li');
    //     // listItem.textContent = `Pin ${pins.length}: x = ${coords.x}%, y = ${coords.y}%`;
    //     // logList.appendChild(listItem);


    //     // console.log(x+'//'+y);
    // });













async function deleteDrawing(punchlist_id , id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`/project/punch-list/deleteAssignedDrawings/${punchlist_id}/${id}`;		
		let fetchRes = await fetch(url);
        if(fetchRes.status != 200){
            $('.error').show();
            $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+fetchRes.statusText+'</div>');

        }else{
            //console.log(fetchRes);
            $('.success').show();
            $('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Item Deleted Successfully</div>');
            $('#draw'+id).remove();
        }


    }

</script>
@endsection
