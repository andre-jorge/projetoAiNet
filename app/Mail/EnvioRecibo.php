<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnvioRecibo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $recibo;

    public function __construct($recibo)
    {
        $this->recibo = $recibo;
    }

    public function build()
    {
        return $this->from('noreply@cinemagic.com')
            ->subject('A sua compra foi efetuada com sucesso')
            ->view('emails.compra.sucesso')
            ->with('recibo', $recibo)
            // ->with([
            //     'reciboId' => 1,
            //     'reciboName' => 'John Doe',
            //     'reciboPrice' => 126.5,
            // ])
            ->attachFromStorage('pdf_recibos/1.pdf');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
}
