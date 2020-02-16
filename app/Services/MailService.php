<?php

namespace App\Services;


use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public static function sendReport()
    {
        Mail::send('emails.report', ['user' => 'romazabelin1991@gmail.com'], function ($m) {
            //$m->from('Roma');
            $m->to('romazabelin1991@gmail.com')->subject(Lang::get('translations.report.hello'));
        });
    }
}
