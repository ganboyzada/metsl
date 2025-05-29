@extends('metsl.layouts.master')

@section('header')
<div><h1 class="text-xl mb-0">Edit Company</h1></div>
@endsection

@section('content')

<form action="{{ route('companies.update', $company->id) }}" class="py-10" method="POST">
    @csrf
    @method('PUT')
       <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">

        
        <div class="sm:col-span-1">
            <label for="name" class="block text-sm mb-4 font-medium dark:text-gray-200">Name</label>
            <input type="text" placeholder="X-Construction LLC" value="{{ $company->name }}" name="name" id="name" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
        <div class="sm:col-span-1">
            <label for="specialty" class="block text-sm mb-4 font-medium dark:text-gray-200">Specialty</label>
            <input type="text" placeholder="Construction" value="{{ $company->specialty }}" name="specialty" id="specialty" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200" required>
        </div>
       <div class="sm:col-span-1">
            <label for="phone" class="block text-sm mb-4 font-medium dark:text-gray-200">Phone</label>
            <input type="text" name="phone" placeholder="Enter any phone" value="{{ $company->phone }}"  id="phone" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div class="sm:col-span-1">
            <label for="email" class="block text-sm mb-4 font-medium dark:text-gray-200">Email</label>
            <input type="email" name="email" value="{{ $company->email }}" placeholder="info@xconstruction.com" id="email" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>
        <div class="sm:col-span-1">
            <label for="address" class="block text-sm mb-4 font-medium dark:text-gray-200">Address</label>
            <input type="text" name="address" value="{{ $company->address }}" placeholder="London, UK" id="address" class="w-full px-4 py-2 border dark:bg-gray-800 dark:text-gray-200">
        </div>

   
        <div class="sm:col-span-1">
            <label class="block text-sm mb-4 font-medium dark:text-gray-200">Active</label>
            <div class="checkbox-wrapper-51">
                <input type="checkbox" name="active" id="cbx-51"  {{ $company->active ? 'checked'  : '' }}/>
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
        Update Company
    </button>
</form>

<script>
    	
        document.addEventListener('DOMContentLoaded', () => {
              let packages =  {!! json_encode($packages) !!};
              let selected =  {!! json_encode($selected) !!};
        const allpackages = packages.map(function(item) {
            return {'value' : item.id  , 'label' : item.name ,  'selected': selected.includes(item.id) ? true : false};
        });	
		distribution_obj = populateChoices2('distribution-members',allpackages, true);	

		
    }); 
    

		



</script>
@endsection
