<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        p {
            font-size: 12px;
        }

        .signature {
            font-style: italic;
        }
    </style>
</head>
<body>
<div>
    <p> Greetings from Metsl TaskTrack
        @if ($pass != '')
        <p>You have just been added to the project “({{ $name }})” as ({{ $job_title }}). A user account is created to fit your customized workflow. You can kindly retrieve the login email and the secure password from below:</p>
        <p>Login email: ({{ $email }})</p>
        <p>Password: ({{ $pass }})</p>  
        <p>** Please do not share this password to eliminate confidential issues</p>     
        @else
        <p>You have just been added to the project “({{ $name }})” as ({{ $job_title }}). A user account is created to fit your customized workflow.</p>

        @endif


    <p>Best regards</p>
</div>
</body>
</html>