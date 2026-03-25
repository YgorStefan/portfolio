<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        // CONTACT-02: server-side validation
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:100'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        // CONTACT-03: send email to owner
        try {
            Mail::to(config('mail.owner_address'))
                ->send(new ContactFormMail($validated));

            // CONTACT-04: success feedback
            return redirect('/#contact')
                ->with('success', 'Mensagem enviada com sucesso! Responderei em breve.');
        } catch (\Throwable $e) {
            // CONTACT-04: failure feedback
            return redirect('/#contact')
                ->withInput()
                ->with('error', 'Erro ao enviar mensagem. Tente novamente mais tarde.');
        }
    }
}
