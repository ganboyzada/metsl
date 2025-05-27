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
        <div class="lg:col-span-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"  method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="project_id" name="project_id" value="{{ \Session::get('projectID') }}"/>
            <input type="hidden" name="id" value="{{ $meeting_id }}"/> 


            <!-- Conference Link -->
            <div class="col-span-1">
                <label for="conference-link" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Conference Link</label>
                <a href="{{ $meeting->link }}" class="text-xs px-2 py-1 rounded-full bg-blue-200 dark:bg-blue-900 inline-flex items-center gap-2">
                    <i data-feather="video" class="min-w-5 h-5 w-5"></i>{{ \Str::limit($meeting->link, 20) }}</a>
            </div>

            <!-- Participants -->
            <div class="lg:col-span-2">
                <label for="participants" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Participants</label>

                <div class="flex flex-wrap gap-3">
                @foreach($meeting->users as $user)
                <span class="text-xs px-2 py-1 inline-flex items-center gap-1 rounded-full bg-gray-200 dark:bg-gray-800">
                    <i data-feather="user" class="min-w-5 h-5 w-5"></i>
                    {{ $user->name }}</span>
                @endforeach
                </div>
            </div>

            <div class="col-span-1">
                <label for="endDate" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Status</label>
                <span class="px-3 py-1 font-bold rounded-full text-xs {{ $meeting->status->color() }} text-white">{{ ($meeting->status->name == 'PUBLISHED'  && $meeting->old_status->value == \App\Enums\MeetingPlanStatusEnum::PLANNED->value) ? 'Ready To '.strtoupper($meeting->status->text()) : strtoupper($meeting->status->text()) }}</span>
            </div>

            <!-- Meeting Location -->
            <div class="col-span-1">
                <label for="meeting-location" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Meeting Location:</label>
                <p>{{ $meeting->location }}</p>
            </div>

            <!-- Planned Date -->
            <div class="col-span-1">
                <label for="planned-date" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Planned Date:</label>
                <p>{{ $meeting->planned_date }}</p>
            </div>

            <!-- Start Time -->
            <div class="col-span-1">
                <label for="start-time" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Start Time:</label>
                <p>{{ $meeting->start_time }}</p>
            </div>

            <!-- Duration -->
            <div class="col-span-1">
                <label for="duration" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Duration:</label>
                <p>{{$meeting->duration }} minutes</p>
            </div>

            <!-- Time Zone -->
            <div class="col-span-1">
                <label for="time-zone" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Time Zone:</label>
                <p>{{$meeting->timezone }}</p>
            </div>

            <!-- Meeting Purpose -->
            <div class="col-span-1">
                <label for="meeting-purpose" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Meeting Agenda:</label>
                <div>{!! $meeting->purpose !!}</div>
            </div>

            <!-- Attachments -->
            <div class="col-span-1">
            
                <label for="attachments" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200">Attachments:</label>

                <div class="flex flex-wrap gap-4">
                @foreach ( $meeting->files as $file )
                    <a href="{{ asset('storage/project'.$meeting->project_id.'/meeting_planing'.$meeting->id.'/'.$file->file)  }}" target="_blank" class="px-3 py-1 rounded-full bg-gray-200 dark:bg-gray-800 inline-flex gap-2"><i data-feather="download"></i> {{ $file->file }}</a>
                @endforeach
                </div>
                
            </div>

        </div>

        <div class="lg:col-span-4 rounded-xl bg-gray-100 dark:bg-gray-800 py-5">
            <h3 class="text-xl mb-4 px-5">Meeting Notes</h3>
            <form id="meeting-planner-form" method="POST" >
                @csrf
                <input type="hidden" id="project_id" name="project_id" value="{{ \Session::get('projectID') }}"/>
                <input type="hidden" id="meeting_id" name="meeting_id" value="{{ $meeting->id }}"/>
                <div class="overflow-x-auto">
                    <table class="w-full" id="meeting-notes">
                        <thead class="bg-gray-200 dark:bg-gray-900/50 text-sm text-left">
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
                            @if ($meeting->notes->count() > 0)
                                @foreach ($meeting->notes as $index=>$note) 
                                <tr class="meeting-note ">
                                    <td class="px-2 py-2">{{ $index + 1 }}</td>
                                    <td class="px-2 py-2">
                                        <input required value="{{ $note->note }}" type="text" 
                                            placeholder="Your note ..." name="note[]"
                                            class="text-sm rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white"/>
                                    </td>
                                    <td class="px-2 py-2">
                                        <div class="checkbox-wrapper-34">
                                            <input name="type[{{ $index }}]" {{ $note->type == 'action' ? 'checked' : '' }}
                                                    onchange="changeNoteType(event)" class='tgl tgl-ios' id='toggle-{{ $index }}' type='checkbox'>
                                            <label class='tgl-btn' for='toggle-{{ $index }}'></label>
                                        </div>
                                    </td>
                                    <td class="px-2 py-2">
                                    <!-- Will SHOW only when TYPE is ACTION -->
                                        <select name="assign_user_id[]" class="assignee {{ $note->type == 'note' ? 'hidden' : '' }} text-sm rounded-full max-w-48 ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                                            <option value="">Select</option>    
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ $note->assign_user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-2 py-2">
                                        <!-- Will SHOW only when TYPE is ACTION -->
                                        <input type="date" name="deadline[]" value="{{ $note->deadline }}" class="deadline {{ $note->type == 'note' ? 'hidden' : '' }} text-sm rounded-full ps-3 pe-5 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr class="meeting-note">
                                <td class="px-2 py-2">1</td>
                                <td class="px-2 py-2">
                                    <input required type="text" placeholder="your note ..." name="note[]" 
                                        class="text-sm rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white"/>
                                </td>
                                <td class="px-2 py-2">
                                    <div class="checkbox-wrapper-34">
                                        <input name="type[0]" onchange="changeNoteType(event)" 
                                                class='tgl tgl-ios' id='toggle-0' type='checkbox'>
                                        <label class='tgl-btn' for='toggle-0'></label>
                                    </div>
                                </td>
                                <td class="px-2 py-2">
                                <!-- Will SHOW only when TYPE is ACTION -->
                                    <select name="assign_user_id[]" class="assignee hidden rounded-full text-sm ps-3 pe-8 py-1 max-w-48 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                                        <option value="">Select</option>    
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </td>
                                <td class="px-2 py-2">
                                    <!-- Will SHOW only when TYPE is ACTION -->
                                    <input type="date" name="deadline[]" class="deadline hidden text-sm rounded-full ps-3 pe-5 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                                </td>
                            </tr>  
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="px-5">
                    @if ($meeting->old_status->value != \App\Enums\MeetingPlanStatusEnum::PUBLISHED->value)
                    <button type="button" onclick="addNote()" class="mt-4 w-full py-2 px-4 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-blue-500/50 flex gap-4 justify-center"><i data-feather="plus-circle"></i>Add Note</button>
                    @endif
                   @php
                        $planned_date = $meeting->planned_date;
                        $start_time = $meeting->start_time;
                        $duration_minutes = (int)$meeting->duration; // Duration as an integer
                        $meeting_start = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $planned_date.' '.$start_time);
                        $meeting_end = $meeting_start->copy()->addMinutes($duration_minutes);
                        
                        
                    @endphp
                    <input type="hidden" name="status" value="{{ ($now->greaterThan($meeting_end) || $now->between($meeting_start, $meeting_end))? \App\Enums\MeetingPlanStatusEnum::PUBLISHED->value : -1 }}"/>
                    @if($meeting->created_by == auth()->user()->id || auth()->user()->is_admin)
                    @if ($meeting->old_status->value != \App\Enums\MeetingPlanStatusEnum::PUBLISHED->value)
                          <button type="submit" class="submit_planing_meeting_form mt-6 py-3 px-4 bg-gray-200 dark:bg-gray-700 rounded-xl hover:bg-blue-500 flex gap-4 justify-center"><i data-feather="save"></i>
                            @php
                                
                                $now = \Carbon\Carbon::now();
                                if ($now->greaterThan($meeting_end) || $now->between($meeting_start, $meeting_end)){
                                    echo 'Publish';
                                }else{
                                    echo 'Save';
                                }
                            @endphp     
                            
                        
                        </button>                      
                    @endif

                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>

    function changeNoteType(event){
        let meeting_note = $(event.target).closest('tr');
        console.log('RESPONSE: ' + event.target.value);

        if(event.target.checked){
            meeting_note.find('.assignee').show();
            meeting_note.find('.deadline').show();
        } else{    
            meeting_note.find('.assignee').hide();
            meeting_note.find('.deadline').hide();
        }
    }

    $("#meeting-planner-form").on("submit", function(event) {
        //alert('ok');
        const form = document.getElementById("meeting-planner-form");
        const formData = new FormData(form); 
    
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
                url: "{{ route('projects.meetings.store_notes') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $(".submit_planing_meeting_form").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                        
                        $(".submit_planing_meeting_form").prop('disabled', false);
                        
                        $("#meeting-planner-form")[0].reset();
                        
                        window.scrollTo(0,0);

                        $('.success').show();
                        $('.success').html('<div class= "text-white-500 px-2 py-1 text-sm font-semibold">'+data.success+'</div>');  
                        
                        $('#file-list').html('');
                        
                       setInterval(function() {
                                window.location.href="{{ route('home') }}";
                                }, 3000);                        

                    }
                    else if(data.error){
                        $(".submit_planing_meeting_form").prop('disabled', false);

                        $('.error').show();
                        $('.error').html('<div class= "text-white-500  px-2 py-1 text-sm font-semibold">'+data.error+'</div>');
                    }
                },
                error: function (err) {
                    $.each(err.responseJSON.errors, function(key, value) {
                            var el = $(document).find('[name="'+key + '"]');
                            el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">' + value[0] + '</div>'));
                            if(el.length == 0){
                                el = $(document).find('#file-upload');
                                el.after($('<div class= "err-msg text-red-500  px-2 py-1 text-sm font-semibold">the documents must be pdf </div>'));
                                
                            }
                            
                        });

                        $(".submit_planing_meeting_form").prop('disabled', false);


                }
            });
    
    });
    
let noteCount = parseInt({{ $meeting->notes->count() }});

function addNote(){
    noteCount++;
    let users = {!! json_encode($users) !!}
    let html = `
        <tr class="meeting-note">
            <td class="px-2 py-2">${noteCount}</td>
            <td class="px-2 py-2">
                <input required type="text" placeholder="your note ..." name="note[]" id="note" class="text-sm rounded-full ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white"/>
            </td>
            <td class="px-2 py-2">
                <div class="checkbox-wrapper-34">
                    <input name="type[${noteCount}]" onchange="changeNoteType(event)" class='tgl tgl-ios' id='toggle-n${noteCount}' type='checkbox'>
                    <label class='tgl-btn' for='toggle-n${noteCount}'></label>
                </div>
            </td>
            <td class="px-2 py-2">
            <!-- Will SHOW only when TYPE is ACTION -->
                <select name="assign_user_id[]" id="assignee" class="assignee hidden text-sm rounded-full max-w-48 ps-3 pe-8 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
                    <option value="">Select</option>
                    `;
                    @foreach($users as $user)
                        html+= `<option value="{{ $user->id }}">{{ $user->name }}</option>`;
                    @endforeach
                
                html+= `</select>
            </td>
            <td class="px-2 py-2">
                <!-- Will SHOW only when TYPE is ACTION -->
                <input type="date" name="deadline[]" class="deadline hidden text-sm rounded-full ps-3 pe-5 py-1 border-none bg-gray-200 dark:bg-gray-700 dark:text-white">
            </td>
        </tr>
    `;
    $('#meeting-notes tbody').append(html);
}
</script>
@endpush