@extends('metsl.layouts.master')

@section('title', 'Punch List - Create')

@section('content')
<style>
    [type=radio]:checked+img{
        border: 4px solid red !important;
    }
    </style>

<style>
.choices__list--dropdown {
  z-index: 9999 !important; /* اجعلها قيمة كبيرة لتكون فوق المحرر */
}
.choices {
  position: relative;
 z-index: 9999 !important; 
}

  </style>

<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Add a Compnay</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>



	<form action="{{ route('companies.store') }}" class="py-10" method="POST">

		@csrf
        <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">

        
        <div class="sm:col-span-1">
            <label for="name" class="block text-sm mb-4 font-medium dark:text-gray-200">Name</label>
            <input type="text" placeholder="X-Construction LLC" name="name" id="name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
        <div class="sm:col-span-1">
            <label for="specialty" class="block text-sm mb-4 font-medium dark:text-gray-200">Specialty</label>
            <input type="text" placeholder="Construction" name="specialty" id="specialty" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
       <div class="sm:col-span-1">
            <label for="phone" class="block text-sm mb-4 font-medium dark:text-gray-200">Phone</label>
            <input type="text" name="phone" placeholder="Enter any phone"  id="phone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div class="sm:col-span-1">
            <label for="email" class="block text-sm mb-4 font-medium dark:text-gray-200">Email</label>
            <input type="email" name="email" placeholder="info@xconstruction.com" id="email" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div class="sm:col-span-1">
            <label for="address" class="block text-sm mb-4 font-medium dark:text-gray-200">Address</label>
            <input type="text" name="address" placeholder="London, UK" id="address" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>

   
        <div class="sm:col-span-1">
            <label class="block text-sm mb-4 font-medium dark:text-gray-200">Active</label>
            <div class="checkbox-wrapper-51">
                <input type="checkbox" name="active" id="cbx-51" checked/>
                <label for="cbx-51" class="toggle">
                    <span>
                    <svg width="10px" height="10px" viewBox="0 0 10 10">
                        <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                    </svg>
                    </span>
                </label>
            </div>
        </div>


        <div class="sm:col-span-2">
                    <label for="distribution-members" class="block text-sm mb-2 font-medium dark:text-gray-200"> Work Packges</label>
                    <select id="distribution-members"  name="work_packages[]" multiple class="choices w-full border dark:bg-gray-800 dark:text-gray-200">
                
                    </select>
        </div>  
        </div>

        

           
          
     

            <div class="flex flex-wrap md:flex-nowrap items-start gap-6">

          



                <!-- Attachments (Dropzone) -->
                <div  class=" w-full md:w-2/5 mb-4 hidden">
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


   

      
       <button type="submit" class="flex px-4 gap-3 py-2 bg-blue-500 text-white hover:bg-blue-600 mt-4">
        <i data-feather="save"></i>
        Save Company
    </button>

    </form>



</div>


<script>
    	
        document.addEventListener('DOMContentLoaded', () => {
              let packages =  {!! json_encode($packages) !!};
        const allpackages = packages.map(function(item) {
            return {'value' : item.id  , 'label' : item.name};
        });	
		distribution_obj = populateChoices2('distribution-members',allpackages, true);	

		
    }); 
    

		



</script>
@endsection