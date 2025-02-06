<?php

namespace App\Http\Controllers;

use Cachet\Cachet;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class VerificationController
{

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();
        Notification::make()
            ->success()
            ->title(__('E-mail verified successfully!'))
            ->send();

        return redirect()->to(Cachet::dashboardPath());
    }


    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        Notification::make()
            ->success()
            ->title(__('A new verification link has been sent to your email address.'))
            ->send();
        return back();
    }
}
