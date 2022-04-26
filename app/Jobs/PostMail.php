<?php

namespace App\Jobs;

use App\Mail\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class PostMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $name, $judul, $status, $walpaper, $email, $message;

    public function __construct($details)
    {
        //
        $this->name     = $details['name'];
        $this->judul    = $details['judul'];
        $this->status   = $details['status'];
        $this->email    = $details['email'];
        $this->walpaper = $details['walpaper'];
        $this->message  = $details['message'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $details = [
            'name'      => $this->name,
            'judul'     => $this->judul,
            'status'    => $this->status,
            'email'     => $this->email,
            'walpaper'  => $this->walpaper,
            'messages'  => $this->message
        ];
        Mail::to($this->email)
        ->bcc('irvansulis23@gmail.com')
        ->send(new Post($details));
        Log::info('email terkirim');
    }
}
