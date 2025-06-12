@extends('metsl.layouts.master')
@section('header')
    <div><h1 class="text-xl mb-0">Role Editor</h1></div>
@endsection
@section('content')
<div class="container">
    @if(session()->has('success'))
    <div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
        {{ session()->get('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="flex flex-wrap gap-10 pb-5">
            <div class="w-full">
                <label for="name" class="block text-sm mb-5 font-medium dark:text-gray-200">Role Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="max-w-full w-80 px-4 py-2 border dark:bg-gray-800 dark:text-gray-200"
                    placeholder="Enter Preset Role Name" value="{{ $role->name }}" required
                />
                <button type="submit" class="flex px-4 gap-3 py-2 bg-blue-500 text-white hover:bg-blue-600 mt-4">
                    <i data-feather="save"></i>
                    Save Role
                </button>
            </div>
            <div class="mb-4 space-x-4">
            <label class="leading-snug">
                <input type="radio" name="checkControl" id="checkAll" style="border:1px solid;" />
                Check All
            </label>

            <label class="leading-snug">
                <input type="radio" name="checkControl" id="uncheckAll" style="border:1px solid;" />
                Uncheck All
            </label>
            </div>
            <div>
                <h3 class="block text-sm mb-5 font-medium dark:text-gray-200">Assign Permissions</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6 checkbox-style-1">
                
                    @foreach($permissions as $permission)
                    @if ($permission->name != 'view_all_projects' && $permission->name != 'modify_presets' && $permission->name != 'modify_companies'
                     && $permission->name != 'modify_package' && $permission->name != 'create_projects')
                          
                    <div class="checkbox-wrapper-47">
                        <input type="checkbox" name="permissions[]"  class="perm-checkbox"   value="{{ $permission->id }}" id="p-{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}/>
                        <label for="p-{{ $permission->id }}" class="leading-snug">{{ ucwords(str_replace("_"," ",$permission->name))   }}</label>
                    </div>
                    @endif
                    @endforeach
                    
                </div>

                            </br>

                <h3 class="block text-lg mb-5 font-large dark:text-gray-200"><u>Admin Permissions</u></h3>
                <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-6 checkbox-style-1">
                
                    @foreach($permissions as $permission)
                    @if ($permission->name == 'view_all_projects' || $permission->name == 'modify_presets' || $permission->name == 'modify_companies'
                     || $permission->name == 'modify_package' || $permission->name == 'create_projects')
                          <div class="checkbox-wrapper-47">
                            <input type="checkbox" name="permissions[]" class="perm-checkbox"  value="{{ $permission->id }}" id="p-{{ $permission->id }}"  {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}/>
                            <label for="p-{{ $permission->id }}" class="leading-snug">{{ ucwords(str_replace("_"," ",$permission->name))   }}</label>
                        </div>                      
                    @endif

                    @endforeach
                    
                </div>
            </div>
            
        </div>

        <button type="submit" class="mt-5 px-4 py-2 bg-blue-500 text-white hover:bg-blue-600">Update Role</button>
    </form>
</div>
    <script>
  document.getElementById('checkAll').addEventListener('change', function () {
    if (this.checked) {
      document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true);
    }
  });

  document.getElementById('uncheckAll').addEventListener('change', function () {
    if (this.checked) {
      document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false);
    }
  });
</script>
@endsection
