<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Komen extends Mailable
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
        if($this->details['status'] == "komen"){
            return $this->subject($this->details['name']. ' Mengomentari Artikel Anda')
            ->view('mail.komen')
            ->with($detailData);
        }
        else if($this->details['status'] == "reply"){
            return $this->subject($this->details['name']. ' Membalas Komentar anda')
            ->view('mail.komen')
            ->with($detailData);
        }
    }
}
