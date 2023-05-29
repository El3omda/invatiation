<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PagesController extends Controller
{

    // About Page
    public function about()
    {
        return view('pages.about');
    }

    // Contact Page
    public function contact()
    {
        return view('pages.contact');
    }

    // Send Email Function
    public function sendEmail(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $subject = $request->subject;
        $message = $request->message;

        $msg = "الاسم : " . $name . "\n" . "البريد الإلكتروني : " . $email . "\n" . "موضوع الرسالة : " . $subject . "\n" . "الرسالة : " . $message;

        $msg = wordwrap($msg, 70);

        if (mail("realemadothman@gmail.com", "رسالة من موقع انشاء الدعوات", $msg)) {
            return redirect('/' . App::getLocale() . '/contact?done');
        } else {
            return redirect('/' . App::getLocale() . '/contact?failed');
        }
    }
}
