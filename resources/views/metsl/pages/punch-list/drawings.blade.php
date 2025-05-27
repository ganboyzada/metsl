@extends('metsl.layouts.master')

@section('title', 'Punch List - Create drawing')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Add a Punch Drawings </h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
	<form id="snag-item-form" class="space-y-6"  method="POST" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="project_id" value="{{ \Session::get('projectID') }}"/>

      

            <div class="flex flex-wrap md:flex-nowrap items-start gap-6">

          
                <div class="w-full md:w-2/5 mb-4">
                    <label for="title" class="block text-sm mb-2 font-medium dark:text-gray-200">Title <span class="text-red-500">*</span></label>
                    <input
                        type="text"
                        id="title" name="title"
                        class="w-full px-4 py-2 dark:bg-gray-800 dark:text-gray-200"
                        placeholder="Enter title"
                        required
                    />
                </div>

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
                    <label class="block mb-2 text-sm">Attachments (JPG, JPEG, PNG)  <span class="text-red-500">*</span></label>
                    <div id="drop-zone" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed  dark:bg-gray-800 dark:border-gray-700 border-gray-300">
                        <div class="flex flex-col items-center justify-center">
                            <i data-feather="upload" class="w-10 h-10 text-gray-500"></i>
                            <p class="text-sm text-gray-500">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-500"> JPG, JPEG, PNG (max. 10MB)</p>
                        </div>
                    <input id="file-upload" accept="image/jpeg,image/gif,image/png,image/x-eps"  name="docs[]" type="file" class="hidden" multiple>
                    </div>
                    <ul id="file-list" class="mt-4 space-y-2">
                        <!-- Uploaded files will appear here -->
                    </ul>
                </div>
            

        </div>
        <button
        type="submit"
        class="submit_punch_list_form px-4 py-2 mt-5 bg-blue-500 text-white hover:bg-blue-600"
    >
        Submit Item
    </button>

    </form>

    <div class="p-6">


        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @if (isset($drawings) && $drawings->count() > 0)
                @foreach ($drawings as $drawing)
                <div class="sm:col-span-1 text-center" id="draw{{ $drawing->id }}">
                    <a target="_blank" href="{{ Storage::url('project'.$drawing->project_id.'/drawings/'.$drawing->image) }}">
                        <img style="width:40%;margin:auto; " src="{{ Storage::url('project'.$drawing->project_id.'/drawings/'.$drawing->image) }}"/>
                        <p>{{ $drawing->title }}</p>
                        <small>{!! $drawing->description !!}</small>
                    </br>
                    </a>    
                        <button onclick="deleteDrawing({{ $drawing->id }})"
                             class="text-red-500 dark:text-red-400 text-center">
                            <i data-feather="trash" class="w-5 h-5" style="margin:auto;"></i>
                        </button>
                    
            
                </div>
                    
                @endforeach
                
            @endif


        </div>
    </div>
</div>
<script>
        async function deleteDrawing(id){
        $('.error').hide(); 
        $('.success').hide();
		let url =`/project/punch-list/deleteDrawings/${id}`;		
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
 $("#snag-item-form").on("submit", function(event) {

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
                url: "{{ route('projects.punch-list.drawings.create') }}",
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
							location.reload();
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
                            if(el.length == 0){
                                el = $(document).find('#file-upload');
								el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the drawings is required </div>'));
								
                            }
                            
                        });

                        $(".submit_punch_list_form").prop('disabled', false);


                }
            });
    
      });
	  



	



</script>
@endsection