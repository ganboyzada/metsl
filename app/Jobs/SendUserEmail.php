<?php

namespace App\Jobs;

use App\Mail\StakholderEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $project_name;
    protected $job_title;
    protected $pass;

    public function __construct($email, $project_name, $job_title, $pass)
    {
        $this->email = $email;
        $this->project_name = $project_name;
        $this->job_title = $job_title;
        $this->pass = $pass;
    }

    public function handle()
    {
        Mail::to('marina3mad100@gmail.com')->send(new StakholderEmail($this->project_name , $this->job_title , $this->email ,$this->pass));
    }
}
