<?php

namespace App\Services;


use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendReport()
    {
        Mail::send('emails.report', [], function ($m) {
            //$m->from('Roma');
            $emails = ['romazabelin1991@gmail.com', 'kirillzabelin15@gmail.com'];

            $m->to()
                ->subject(Lang::get('translations.mail.report.hello'));
        });
    }
}
