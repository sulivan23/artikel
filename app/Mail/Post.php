<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Post extends Mailable
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
            'walpaper'  => url('img/article/walpaper/'.$this->details['walpaper']),
            'messages'   => $this->details['messages']
        ];
        if($this->details['status'] == "approve"){
            return $this->subject('Artikel kamu telah di setujui oleh admin!')
            ->view('mail.post')
            ->with($detailData);
        }
        else if($this->details['status'] == "reject"){
            return $this->subject('Mohon Maaf, Artikel Kamu Tidak Disetujui Oleh Admin :(')
            ->view('mail.post')
            ->with($detailData);
        }
        else if($this->details['status'] == "unpublish"){
            return $this->subject('Artikel Telah Di Unpublish')
            ->view('mail.post')
            ->with($detailData);
        }
    }
}
