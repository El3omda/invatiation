<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use ArPHP\I18N\Arabic;
use DateTime;
use Illuminate\Support\Facades\App;
use Hijrian;
use Carbon\Carbon;

class InvitesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('invites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $inputs = [
            'owner' => $request->owner,
            'event' => $request->event,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
        ];

        if ($request->hasFile('photo')) {
            $filename = time() . $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('images', $filename, 'public');
            $inputs['photo'] = '/storage/' . $path;
        }

        // Date Type ( Hijri - Miladi )
        if (!empty($request->dateMiladi)) {
            $inputs['dateType'] = 'Miladi';
        }

        if (!empty($request->dateHijri)) {
            $inputs['dateType'] = 'Hijri';
        }

        // Date
        if (!empty($request->dateMiladi)) {
            $inputs['date'] = $request->dateMiladi;
        }

        if (!empty($request->dateHijri)) {
            $inputs['date'] = $request->dateHijri;
        }

        // User IP
        $inputs['ip'] = request()->ip();

        // Generate Random Link
        function randomLink($length = 5)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        $inputs['link'] = randomLink();

        // Save To DB
        if (Invite::create($inputs)) {
            return redirect('/' . $inputs['link'] . '/' . App::getLocale());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($link, $lang)
    {

        if (count(Invite::where('link', '=', $link)->get()) == 0) {
            return abort(404);
        }

        $invite = Invite::where('link', '=', $link)->get()[0];

        #Check Date Type
        if ($invite->dateType == 'Miladi') {
            $d = DateTime::createFromFormat('Y-m-d H:i', $invite->date . ' ' . $invite->time);
            $timeS = $d->getTimestamp();
        } else {
            $date = Hijrian::gregory($invite->date)->format('Y-m-d');

            $newDate = date('Y-m-d', strtotime($date));

            $d = DateTime::createFromFormat('Y-m-d H:i', $newDate . ' ' . $invite->time);
            $timeS = $d->getTimestamp();
        }

        if ($invite->dateType == 'Hijri') {
            $dd = Hijrian::gregory($invite->date)->translatedFormat('l');
        } else {
            $dd = Carbon::createFromFormat('Y-m-d', $invite->date)->translatedFormat('l');
        }

        return view('invites.show', [
            'invite' => $invite,
            'day' => $dd
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invite $link, $lang)
    {
        if ($link->ip != $_SERVER['REMOTE_ADDR']) {
            return redirect('/?error');
        }
        return view('invites.edit', [
            'invite' => $link
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($lang, Request $request, Invite $link)
    {
        // if ($link->ip != $_SERVER['REMOTE_ADDR']) {
        //     return redirect('/?error');
        // }

        $inputs = [
            'owner' => $request->owner,
            'event' => $request->event,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
        ];

        if ($request->hasFile('photo')) {
            $filename = time() . $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('images', $filename, 'public');
            $inputs['photo'] = '/storage/' . $path;
        }

        // Date Type ( Hijri - Miladi )
        if ($request->dateT == 'Hijri') {
            $inputs['date'] = $request->dateHijri;
            $inputs['dateType'] = 'Hijri';
        } else {
            $inputs['date'] = $request->dateMiladi;
            $inputs['dateType'] = 'Miladi';
        }

        $link->owner = $inputs['owner'];
        $link->event = $inputs['event'];
        $link->description = $inputs['description'];
        $link->dateType = $inputs['dateType'];
        $link->date = $inputs['date'];
        $link->time = $inputs['time'];

        if ($request->hasFile('photo')) {
            @unlink(public_path() . $link->photo);
            $filename = time() . $request->file('photo')->getClientOriginalName();
            $path = $request->file('photo')->storeAs('images', $filename, 'public');
            $link->photo = '/storage/' . $path;
        }

        if ($link->save()) {
            return redirect('/' . $link->link . '/' . App::getLocale());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lang, Invite $link)
    {
        if ($link->ip != $_SERVER['REMOTE_ADDR']) {
            return redirect('/?error');
        }

        if ($link->delete()) {
            return redirect('/?delSuccess');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPhoto($lang, Invite $link)
    {
        if ($link->ip != $_SERVER['REMOTE_ADDR']) {
            return redirect('/?error');
        }

        if (unlink(public_path() . $link->photo)) {
            $link->photo = "";
            if ($link->save()) {
                return redirect()->back();
            }
        }
    }

    public function createPDF($lang, Invite $link)
    {

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $Arabic = new Arabic();

        $owner = $Arabic->utf8Glyphs($link->owner);
        $description = $Arabic->utf8Glyphs($link->description);

        if ($lang == 'ar') {
            $str1 = $Arabic->utf8Glyphs('المناسبة : ');
            $str2 = $Arabic->utf8Glyphs('يوم');
            $str3 = $Arabic->utf8Glyphs('الموافق');
        } else {
            $str1 = $Arabic->utf8Glyphs('Event : ');
            $str2 = 'On';
            $str3 = $Arabic->utf8Glyphs(' At ');
        }

        $event = $Arabic->utf8Glyphs($link->event);

        #Check Date Type
        if ($link->dateType == 'Miladi') {
            $d = DateTime::createFromFormat('Y-m-d H:i', $link->date . ' ' . $link->time);
            $timeS = $d->getTimestamp();
        } else {
            $date = Hijrian::gregory($link->date)->format('Y-m-d');

            $newDate = date('Y-m-d', strtotime($date));

            $d = DateTime::createFromFormat('Y-m-d H:i', $newDate . ' ' . $link->time);
            $timeS = $d->getTimestamp();
        }

        if ($link->dateType == 'Hijri') {
            $dd = Hijrian::gregory($link->date)->translatedFormat('l');
        } else {
            $dd = Carbon::createFromFormat('Y-m-d', $link->date)->translatedFormat('l');
        }


        $ddd = $Arabic->utf8Glyphs($dd);

        if ($link->dateType == 'Miladi') {
            if ($lang == 'ar') {
                $dateT = $Arabic->utf8Glyphs('مـ');
            } else {
                $dateT = 'AD';
            }
        } else {
            if ($lang == 'ar') {
                $dateT = $Arabic->utf8Glyphs('هـ');
            } else {
                $dateT = 'Hijri';
            }
        }

        $dompdf->loadHtml(view('invites.pdf', [
            'invite' =>  $link,
            'owner' => $owner,
            'description' => $description,
            'str1' => $str1,
            'event' => $event,
            'str2' => $str2,
            'day' => $ddd,
            'str3' => $str3,
            'dateT' => $dateT,
        ]));

        $dompdf->setPaper('A4');
        $dompdf->render();
        $dompdf->stream('demo.pdf', ['Attachment' => false]);
        return redirect()->back();
    }

    public static function PDF($lang, Invite $link)
    {

        function HijriToJD($m, $d, $y)
        {
            return (int) ((11 * $y + 3) / 30) + 354 * $y + 30 * $m - (int) (($m - 1) / 2) + $d + 1948440 - 385;
        }

        $owner = $link->owner;
        $description = $link->description;
        $str1 = 'المناسبة : ';
        $event = $link->event;
        $str2 = 'يوم';

        #Check Date Type
        if ($link->dateType == 'Miladi') {
            $d = DateTime::createFromFormat('Y-m-d H:i', $link->date . ' ' . $link->time);
            $timeS = $d->getTimestamp();
        } else {
            $exploadeDate = explode('-', $link->date);

            $date = \GeniusTS\HijriDate\Hijri::convertToGregorian($exploadeDate['2'], $exploadeDate['1'], $exploadeDate['0']);

            $newDate = date('Y-m-d', strtotime($date));

            $d = DateTime::createFromFormat('Y-m-d H:i', $newDate . ' ' . $link->time);
            $timeS = $d->getTimestamp();
        }

        $day = date('l', $timeS);

        if ($day == 'Saturday') {
            $dd = 'السبت';
        } elseif ($day == 'Sunday') {
            $dd = 'الأحد';
        } elseif ($day == 'Monday') {
            $dd = 'الإثنين';
        } elseif ($day == 'Tuesday') {
            $dd = 'الثلاثاء';
        } elseif ($day == 'Wednesday') {
            $dd = 'الأربعاء';
        } elseif ($day == 'Thursday') {
            $dd = 'الخميس';
        } elseif ($day == 'Friday') {
            $dd = 'الجمعة';
        }

        $ddd = $dd;
        $str3 = 'الموافق';

        if ($link->dateType == 'Miladi') {
            $dateT = 'مـ';
        } else {
            $dateT = 'هـ';
        }
        return view('invites.pdf', [
            'invite' =>  $link,
            'owner' => $owner,
            'description' => $description,
            'str1' => $str1,
            'event' => $event,
            'str2' => $str2,
            'day' => $ddd,
            'str3' => $str3,
            'dateT' => $dateT,
        ]);
    }

    public static function HijriToJD($m, $d, $y)
    {
        return (int) ((11 * (int)$y + 3) / 30) + 354 * (int)$y + 30 * (int)$m - (int) (((int)$m - 1) / 2) + (int)$d + 1948440 - 385;
    }

    public static function remove_emoji($string)
    {
        // Match Emoticons
        $regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clear_string = preg_replace($regex_emoticons, '', $string);

        // Match Miscellaneous Symbols and Pictographs
        $regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clear_string = preg_replace($regex_symbols, '', $clear_string);

        // Match Transport And Map Symbols
        $regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clear_string = preg_replace($regex_transport, '', $clear_string);

        // Match Miscellaneous Symbols
        $regex_misc = '/[\x{2600}-\x{26FF}]/u';
        $clear_string = preg_replace($regex_misc, '', $clear_string);

        // Match Dingbats
        $regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
        $clear_string = preg_replace($regex_dingbats, '', $clear_string);

        return $clear_string;
    }
}
