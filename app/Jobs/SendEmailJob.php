<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendMail; 
use App\Models\UserEmail; 
use Mail;
use Auth;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->details;
    
        Mail::to($data['email'])
        ->send(new SendMail($data));

        //Update entry in table
        UserEmail::where('id',$data['user_email_id'])->update(['status'=>'sent']);

    }

    /**
     * Execute the job.
     */
    public function failed(): void
    {
        //Update entry in table
        UserEmail::where('id',$this->details['user_email_id'])->update(['status'=>'failed']);
    }
}
