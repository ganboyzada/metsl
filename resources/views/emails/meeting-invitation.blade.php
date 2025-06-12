<!DOCTYPE html>
<html>
<head>
     <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Meeting Summary</title>
 
</head>
<body style="font-family: sans-serif; border: 1px solid black;margin:10px;padding:10px;">
   <div class="meeting-view grid grid-cols-1 lg:grid-cols-4 gap-6">
    <h1 style="text-align:center">{{ session('projectName') }}</h1>
   </br>
        <!-- Meeting Planner Form -->
        <div class="lg:col-span-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" >
  

            <!-- Conference Link -->
            <div class="col-span-1">
                <label for="conference-link" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200"  style="color:red;">Conference Link</label>
                <a href="{{ $meeting->link }}" class="text-xs px-2 py-1 rounded-full bg-blue-200 dark:bg-blue-900 inline-flex items-center gap-2">
                    <i data-feather="video" class="min-w-5 h-5 w-5"></i>{{ $meeting->link }}</a>
            </div>

            </br>

            {{-- <div class="col-span-1">
                <label for="endDate" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Status</label>
                <span class="px-3 py-1 font-bold rounded-full text-xs {{ $meeting->status->color() }} text-white">{{ ($meeting->status->name == 'PUBLISHED'  && $meeting->old_status->value == \App\Enums\MeetingPlanStatusEnum::PLANNED->value) ? 'Ready To '.strtoupper($meeting->status->text()) : strtoupper($meeting->status->text()) }}</span>
            </div>
            </br> --}}

            <!-- Meeting Location -->
            <div class="col-span-1">
                <label for="meeting-location" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Meeting Location:</label>
                <span class="px-3 py-1 font-bold rounded-full text-xs">{{ $meeting->location }}</span>
            </div>
            </br>
            <table>
                <tr>
                    <!-- Planned Date -->
                    <td class="col-span-1" style="width:400px">
                        <label for="planned-date" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Planned Date:</label>
                        <span class="px-3 py-1 font-bold rounded-full text-xs">{{ $meeting->planned_date }}</span>
                    </td>
                

                    <!-- Start Time -->
                    <td class="col-span-1" >
                        <label for="start-time" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Start Time:</label>
                        <span class="px-3 py-1 font-bold rounded-full text-xs">{{ $meeting->start_time }}</span>
                    </td>
                </tr>
            
            </table>
        </br>
            <table>
                <tr>
                    <!-- Planned Date -->
                    <td class="col-span-1" style="width:400px">
                        <label for="duration" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Duration:</label>
                        <span class="px-3 py-1 font-bold rounded-full text-xs">{{$meeting->duration }} minutes</span>
                    </td>
  
            <!-- Time Zone -->
                <td class="col-span-1">
                    <label for="time-zone" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Time Zone:</label>
                    <span class="px-3 py-1 font-bold rounded-full text-xs">{{$meeting->timezone }}</span>
                </td>
            </tr>
        </table>
            </br>

            <!-- Meeting Purpose -->
            <div class="col-span-1">
                <label for="meeting-purpose" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Meeting Agenda:</label>
                <span class="text-xs px-2 py-1 inline-flex items-center gap-1 rounded-full bg-gray-200 dark:bg-gray-800">{!! $meeting->purpose !!}</span>
            </div>

            <!-- Attachments -->
            <!-- Participants -->
            <div class="lg:col-span-2">
                <label for="participants" class="block text-sm mb-2 font-light opacity-75 dark:text-gray-200" style="color:red;">Participants</label>

                <div class="flex flex-wrap gap-3">
                @foreach($meeting->users as $user)
                <p class="text-xs px-2 py-1 inline-flex items-center gap-1 rounded-full bg-gray-200 dark:bg-gray-800">
                    
                    {{ $user->name }}</p>
                @endforeach
                </div>
            </div>

        </div>
        @if ($meeting->notes->count() > 0)
        <hr>
        <div class="lg:col-span-4 rounded-xl bg-gray-100 dark:bg-gray-800 py-5">
            <h3 class="text-xl mb-4 px-5">Meeting Notes</h3>
   
                <div class="overflow-x-auto">
                    <table class="w-full" id="meeting-notes"  style="width:100%;border:1px solid black;    border: 1px solid black;border-collapse: collapse;text-align: center; ">
                        <thead class="bg-gray-200 dark:bg-gray-900/50 text-sm text-left">
                            <tr>
                                <th class="px-2 py-1 font-light" style="   border: 1px solid black;border-collapse: collapse;text-align: center; text-align: left;padding: 8px; ">ID</th>
                                <th class="px-2 py-1 font-light" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">
                                    Note
                                </th>
                                <th class="px-2 py-1 font-light" style="   border: 1px solid black;border-collapse: collapse;text-align: center; text-align: left;padding: 8px; ">Type</th>
                                <th class="px-2 py-1 font-light" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">
                                    Assignee
                                </th>
                                <th class="px-2 py-1 font-light" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">
                                    Deadline
                                </th>
                            </tr>
                        </thead>
                        <tbody>    
                            @if ($meeting->notes->count() > 0)
                                @foreach ($meeting->notes as $index=>$note) 
                                <tr class="meeting-note ">
                                    <td class="px-2 py-2" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">{{ $index + 1 }}</td>
                                    <td class="px-2 py-2" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">
                                        {{ strip_tags($note->note) }}
                                    </td>
                                    <td class="px-2 py-2" style="   border: 1px solid black;border-collapse: collapse;text-align: center; text-align: left;padding: 8px; ">
                                        {{ $note->type == 'action' ? 'Action' : 'Note' }}
                                    </td>
                                    <td class="px-2 py-2" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">
                                        {{ $note->assignee ? $note->assignee->name : '' }}
                                    </td>
                                    <td class="px-2 py-2" style="   border: 1px solid black;border-collapse: collapse;text-align: center;  text-align: left;padding: 8px;">
                                        {{ $note->deadline ?? '' }}
                                        <!-- Will SHOW only when TYPE is ACTION -->

                                    </td>
                                </tr>
                                @endforeach
                 
                            @endif

                        </tbody>
                    </table>
                </div>
               
        </div>
        @endif
    </div>
</body>
</html>