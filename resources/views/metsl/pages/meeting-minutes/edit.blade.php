@extends('metsl.layouts.master')

@section('title', 'Plan a Meeting')

@section('content')
<div>
    <h1 class="text-2xl font-semibold mb-6 dark:text-gray-200">Meeting: {{ $meeting->name }}</h1>
	<div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold hidden success"></div>
	<div class="bg-red-500 text-white px-2 py-1 text-sm font-semibold hidden error"></div>
    @if(session()->has('success'))
    <div class="bg-green-500 text-white px-2 py-1 text-sm font-semibold">
        {{ session()->get('success') }}
    </div>
    @endif  
    <div class="meeting-view grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Meeting Planner Form -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"  method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="project_id" name="project_id" value="{{ \Session::get('projectID') }}"/>
            <input type="hidden" name="id" value="{{ $meeting_id }}"/> 


            <!-- Conference Link -->
            <div class="col-span-1">
                <label for="conference-link" class="block text-sm mb-2 font-medium dark:text-gray-200">Conference Link</label>
                <a href="{{ $meeting->link }}" class="px-3 py-1 rounded-full bg-blue-200 dark:bg-blue-900 inline-flex gap-2"><i data-feather="video"></i>{{ \Str::limit($meeting->link, 20) }}</a>
            </div>

            <!-- Participants -->
            <div>
                <label for="participants" class="block text-sm mb-2 font-medium dark:text-gray-200">Participants</label>

                <div class="flex flex-wrap gap-4">
                @foreach($meeting->users as $user)
                <span class="px-3 py-1 rounded-full bg-blue-200 dark:bg-blue-900">{{ $user->name }}</span>
                @endforeach
                </div>
            </div>

            <div class="col-span-1">
                <label for="endDate" class="block font-medium text-gray-700 dark:text-gray-200">Status</label>
                <span class="px-3 py-1 rounded-full text-xs {{ $meeting->status->color() }} text-white">{{ $meeting->status->text() }}</span>
            </div>

            <!-- Meeting Location -->
            <div class="col-span-1">
                <label for="meeting-location" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Location:</label>
                <p>{{ $meeting->location }}</p>
            </div>

            <!-- Planned Date -->
            <div class="col-span-1">
                <label for="planned-date" class="block text-sm mb-2 font-medium dark:text-gray-200">Planned Date:</label>
                <p>{{ $meeting->planned_date }}</p>
            </div>

            <!-- Start Time -->
            <div class="col-span-1">
                <label for="start-time" class="block text-sm mb-2 font-medium dark:text-gray-200">Start Time:</label>
                <p>{{ $meeting->start_time }}</p>
            </div>

            <!-- Duration -->
            <div class="col-span-1">
                <label for="duration" class="block text-sm mb-2 font-medium dark:text-gray-200">Duration:</label>
                <p>{{$meeting->duration }} minutes</p>
            </div>

            <!-- Time Zone -->
            <div class="col-span-1">
                <label for="time-zone" class="block text-sm mb-2 font-medium dark:text-gray-200">Time Zone:</label>
                <p>{{$meeting->timezone }}</p>
            </div>

            <!-- Meeting Purpose -->
            <div class="col-span-1">
                <label for="meeting-purpose" class="block text-sm mb-2 font-medium dark:text-gray-200">Meeting Purpose:</label>
                <div>{!! $meeting->purpose !!}</div>
            </div>

            <!-- Attachments -->
            <div class="col-span-1">
            
                <label for="attachments" class="block text-sm mb-2 font-medium dark:text-gray-200">Attachments:</label>

                <div class="flex flex-wrap gap-4">
                @foreach ( $meeting->files as $file )
                    <span class="px-3 py-1 rounded-full bg-gray-200 dark:bg-gray-800 inline-flex gap-2"><i data-feather="download"></i> {{ $file->file }}</span>
                @endforeach
                </div>
                
            </div>

        </div>

        <div class="lg:col-span-2 rounded-xl bg-gray-100 dark:bg-gray-800 p-5">
            <h3 class="text-xl mb-4">Meeting Notes</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200 dark:border-gray-700" id="meeting-notes">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-sm text-left">
                        <tr>
                            <th class="px-2 py-1 font-light">ID</th>
                            <th class="px-2 py-1 font-light">
                                <i data-feather="message-circle" class="inline mr-2 w-5 h-5"></i>
                                Note
                            </th>
                            <th class="px-2 py-1 font-light">Type</th>
                            <th class="px-2 py-1 font-light">
                                <i data-feather="user" class="inline mr-2 w-5 h-5"></i>
                                Assignee
                            </th>
                            <th class="px-2 py-1 font-light">
                                <i data-feather="clock" class="inline mr-2 w-5 h-5"></i>
                                Deadline
                            </th>
                        </tr>
                    </thead>
                    <tbody>    
                        <tr class="meeting-note">
                            <td class="px-2 py-2">1</td>
                            <td class="px-2 py-2">
                                <input type="text" placeholder="Said words ..." name="note" id="note" class="rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white"/>
                            </td>
                            <td class="px-2 py-2">
                                <select name="task_type" id="task_type" class="rounded-full ps-3 pe-5 py-1 border bg-transparent font-bold border-blue-500 text-blue-500">
                                    <option value="0">Note</option>
                                    <option value="0">Action</option>
                                </select>
                            </td>
                            <td class="px-2 py-2">
                            <!-- Will SHOW only when TYPE is ACTION -->
                                <select name="assignee" id="assignee" class="rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                                    <option value="1">Person A</option>
                                    <option value="2">Person B</option>
                                    <option value="3">Person C</option>
                                </select>
                            </td>
                            <td class="px-2 py-2">
                                <!-- Will SHOW only when TYPE is ACTION -->
                                <input type="date" class="rounded-full ps-3 pe-5 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" onclick="addNote()" class="mt-4 w-full py-3 px-4 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-orange-400 flex gap-4 justify-center"><i data-feather="plus-circle"></i>Add Note</button>

            <button type="button" class="mt-6 py-3 px-4 bg-gray-200 dark:bg-gray-700 rounded-xl hover:bg-blue-500 flex gap-4 justify-center"><i data-feather="save"></i>Save Changes</button>

        </div>
    </div>
</div>
@endsection

@push('js')
<script>
function addNote(){
    $('#meeting-notes tbody').append(`
        <tr class="meeting-note">
            <td class="px-2 py-2">1</td>
            <td class="px-2 py-2">
                <input type="text" placeholder="Said words ..." name="note" id="note" class="rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white"/>
            </td>
            <td class="px-2 py-2">
                <select name="task_type" id="task_type" class="rounded-full ps-3 pe-5 py-1 border bg-transparent font-bold border-blue-500 text-blue-500">
                    <option value="0">Note</option>
                    <option value="0">Action</option>
                </select>
            </td>
            <td class="px-2 py-2">
            <!-- Will SHOW only when TYPE is ACTION -->
                <select name="assignee" id="assignee" class="rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                    <option value="1">Person A</option>
                    <option value="2">Person B</option>
                    <option value="3">Person C</option>
                </select>
            </td>
            <td class="px-2 py-2">
                <!-- Will SHOW only when TYPE is ACTION -->
                <input type="date" class="rounded-full ps-3 pe-5 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
            </td>
        </tr>
    `);
}
</script>
@endpush