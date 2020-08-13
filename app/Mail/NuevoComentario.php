<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevoComentario extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $content)
    {
        $this->name    = $name;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name       = $this->name;
        $content    = $this->content;
        return $this->subject("Nuevo comentario en tu publicación")
        ->markdown('emails.notifications.comment', compact('name', 'content'));
    }
}
