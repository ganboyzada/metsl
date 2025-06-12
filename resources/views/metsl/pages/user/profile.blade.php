@extends('metsl.layouts.master')

@section('header')
<div><h1 class="text-xl mb-0">Profile</h1></div>
@endsection

@section('content')
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    <form id="createUserForm"   enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
       <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">

        <div class="sm:col-span-2">
                      <img id="preview" src="{{ auth()->user()->profile_photo_path }}" alt="Image Preview" class="w-32 h-32 rounded-full object-cover border-4 border-gray-300 shadow-md "/>

            <label for="imageInput" class="block text-sm mb-4 font-medium dark:text-gray-200">Profile Image</label>
            <input type="file" name="image" id="imageInput" accept="image/*"  class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>

        @php
            $name = auth()->user()->name;
            $nameArr = explode('_', $name);
            $first_name = $nameArr[0]??'';
            $last_name = $nameArr[1]??'';
        @endphp
        <div class="sm:col-span-1">
            <label for="first_name" class="block text-sm mb-4 font-medium dark:text-gray-200">First Name</label>
            <input type="text"  value="{{ $first_name  }}" name="first_name" id="first_name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>

        <div class="sm:col-span-1">
            <label for="last_name" class="block text-sm mb-4 font-medium dark:text-gray-200">Last Name</label>
            <input type="text"  value="{{ $last_name  }}" name="last_name" id="last_name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
        <div class="sm:col-span-1">
            <label for="specialty" class="block text-sm mb-4 font-medium dark:text-gray-200">Email</label>
            <input type="email" value="{{ auth()->user()->email }}" name="email" id="email" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
       <div class="sm:col-span-1">
            <label for="password" class="block text-sm mb-4 font-medium dark:text-gray-200">Password</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div class="sm:col-span-1">
            <label for="email" class="block text-sm mb-4 font-medium dark:text-gray-200">phone</label>
            <input type="text" name="mobile_phone" value="{{ auth()->user()->mobile_phone }}"  id="phone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>


   


 
        </div>

    </br>
        <button type="submit" id="submitBtn" class="bg-blue-500 text-white px-4 py-2">Update User</button>

</form>

<script>
            $("#createUserForm").on("submit", function(event) {
        $('.err-msg').hide();
        $(".error").html("");
        $(".error").hide();
        event.preventDefault();  
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "POST",
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $("#submitBtn").prop('disabled', true);
            },
            success: function(data) {
                if (data.success) {
                    //  
                    $("#submitBtn").prop('disabled', false); 
            
					$('.success').show();
					$('.success').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold"> Updated Successfully</div>');

                
                }
            },
            error: function (err) {
                $.each(err.responseJSON.errors, function(key, value) {
                    $('.error').show();
                    $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+value[0]+'</div>');
                        var el = $(document).find('[name="'+key + '"]');
                        el.after($('<span class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</span>'));
                        
                    });

                    $("#submitBtn").prop('disabled', false);
                    $(".error").show();
                    $(".error").html("<div class='text-white-500  px-2 py-1 text-sm font-semibold'>Some Error Occurred!</div>")

            }
        });
    });
        
   
    const input = document.getElementById("imageInput");
    const preview = document.getElementById("preview");

    input.addEventListener("change", function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

		



</script>
@endsection
