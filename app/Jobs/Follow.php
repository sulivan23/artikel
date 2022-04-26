<?php

namespace App\Jobs;

use App\Mail\Follow as MailFollow;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Follow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $name, $judul, $walpaper, $email, $message, $status;

    public function __construct($details)
    {
        $this->name     = $details['name'];
        $this->judul    = $details['judul'];
        $this->email    = $details['email'];
        $this->walpaper = $details['walpaper'];
        $this->message  = $details['message'];
        $this->status  = $details['status'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $details = [
            'name'      => $this->name,
            'judul'     => $this->judul,
            'email'     => $this->email,
            'walpaper'  => $this->walpaper,
            'messages'  => $this->message,
            'status'    => $this->status
        ];
        Mail::to($this->email)
        ->bcc('irvansulis23@gmail.com')
        ->send(new MailFollow($details));
        Log::info('email terkirim');
    }
}
