<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use App\Models\Sessao;
use App\Models\Lugares;
use App\Models\Recibo;
use App\Models\Bilhetes;
use App\Models\Carrinho;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Services\Payment;

class EmailController extends Controller
{
    public function index()
    {
        return view('email_index')->with('pageTitle', 'E-Mail');
    }

    public function send_email_with_notification1()
    {
        // SEND EMAIL WITH USER MODEL
        $invoice = null;
        // Send to user:
        $userinfo = auth()->user();
        $user = User::findOrFail($userinfo->id);
        $user->notify(new ReciboPago($invoice));
        return redirect()->route('email.home')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'E-Mail sent with success (using Notifications)');
    }

    public function send_email_with_mailable()
    {
        // SEND EMAIL WITH MAILABLE CLASS
        $order = null;
        // Send to user:
        $user = User::findOrFail(2);

        Mail::to($user)
            ->send(new OrderShipped($order));

        return redirect()->route('carrinho.carrinhoValidado')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'E-Mail sent with success (using Mailable)');
    }

}
