<?php

namespace App\Services;


use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * send report to users
     *
     * @param array $users
     * @param string $pathToFile
     */
    public static function sendReport(array $emails, string $pathToFile)
    {
        Mail::send('emails.report', [], function ($m) use ($pathToFile, $emails) {
            //$m->from('Roma');
            $m->to($emails)
                ->subject(Lang::get('translations.mail.report.subject'))
                ->attachFromStorage($pathToFile);
        });
    }
}
