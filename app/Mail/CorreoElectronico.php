<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorreoElectronico extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('example@example.com') 
                    ->view('mails.correo')
                    ->text('mails.texto') 
                    ->with(
                      [
                            'titulo' => 'Tienda',
                            'texto' => 'Texto de ejemplo',
                      ])
                      ->attach(public_path('/recursos').'/laravel-red.png', [
                              'as' => 'laravel-red.png',
                              'mime' => 'image/png',
                      ]);
    }
}

