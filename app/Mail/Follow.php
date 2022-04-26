<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Follow extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $details;
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $detailData = [
            'name'      => $this->details['name'],
            'judul'     => $this->details['judul'],
            'status'    => $this->details['status'],
            'walpaper'  => url('img/user/'.$this->details['walpaper']),
            'messages'  => $this->details['messages']
        ];
        if($this->details['status'] == "follow"){
            return $this->subject($this->details['name']. ' Mulai Mengikuti Anda')
            ->view('mail.follow')
            ->with($detailData);
        }
        else if($this->details['status'] == "unfollow"){
            return $this->subject($this->details['name']. ' Berhenti Mengikuti anda')
            ->view('mail.follow')
            ->with($detailData);
        }
    }
}
