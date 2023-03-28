<?php

namespace App\Helpers;

use App\Enums\ESmsType;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class MyHelper
{
    static function getUTCOffset($timezone)
    {
        $current = timezone_open($timezone);
        $utcTime = new \DateTime('now', new \DateTimeZone('UTC'));
        $offsetInSecs = timezone_offset_get($current, $utcTime);
        $hoursAndSec = gmdate('H:i', abs($offsetInSecs));
        return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}";
    }
    static function getNormaliazedTime($time, $with_day = 0)
    {
        [$d1, $d2] = explode(" ", $time);
        $unix = strtotime($time);
        if (date("d") == date("d", $unix)) {
            return ($with_day ? "Today " : "") . $d2;
        } elseif (date("d", strtotime("-1 days")) == date("d", $unix)) {
            return "Yesterday " . $d2;
        } else {
            return $time;
        }
    }
    static function fa_to_en($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
    static function due($order, $normal = false)
    {

        if ($normal) {
            $diff = time() - strtotime($order->created_at);
            $diff_hour = $diff / 3600;
            if ($diff_hour >= 24) {
                return round($diff_hour / 24) . " day(s) ago";
            }
            if ($diff_hour < 1) {
                if (round($diff / 60) == 0) {
                    return "now";
                }
                return round($diff / 60) . " minutes ago";
            }
            return round($diff_hour) . " hours ago";
        }


        return date("Y-m-d H:i", $order->expires_at);
    }
    static function sendSMS($type, $data)
    {
        return 1;
        $admins = Admin::role('admin')->get();

        $user = $data["user"];
        $user_fullname = urlencode($user->first_name . " " . $user->last_name);
       



        foreach ($admins as $admin) {
            $phone = $admin->phone;
            if(!in_array($type, json_decode($admin->sms))){
                continue;
            }

            if (!$phone) {
                Log::error('super admin phone is not found');
            }
            $append = "";
           

            switch ($type) {
                case ESmsType::Order:
                    $pattern = "6ikckh3xul3v5l6";
                    $order = $data["order"];
                    $append = "&pid={$pattern}&fnum=5000125475&tnum={$phone}&p1=name&v1={$user_fullname}&p2=email&v2={$user->email}&p3=number&v3={$order->id}";
                    break;

                case ESmsType::Ticket:
                    $pattern = "6okn0v670keil05";
                    $ticket = $data["ticket"];
                    $append = "&pid={$pattern}&fnum=5000125475&tnum={$phone}&p1=name&v1={$user_fullname}&p2=email&v2={$user->email}&p3=title&v3={$ticket->title}";
                    break;

                case ESmsType::Request:
                    $pattern = "1tkf5tsf0az008f";
                    $request = $data["request"];
                    $request_name = urlencode($request->name);
                    $service = urlencode($data["service"]->type);
                    $append = "&pid={$pattern}&fnum=5000125475&tnum={$phone}&p1=name&v1={$user_fullname}&p2=email&v2={$user->email}&p3=request&v3={$request_name}&p4=service&v4={$service}";
                    break;
            }
           


            try {
                $url = "http://ippanel.com:8080/?apikey=" . env("FARAZ_SMS_API_KEY") . $append;
                $handler = curl_init($url);
                curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
                $response2 = curl_exec($handler);

                Log::debug($url);

                 $response2;
            } catch (\Exception $e) {
                Log::warning("send sms " . $e->getMessage());
            }
        }
    }
   
    static function dateOfMonths()
    {
        $month = (new Shamsi)->jNumber()[1];
        $year = (new Shamsi)->jNumber()[0];
        $out = [];
        foreach (range(1, 30) as $day) {
            $out[] = (object)[
                "date" => $year . "/" . $month . "/" . $day,
                "weekday" => __(date("D", strtotime((new Shamsi)->jalali_to_gregorian($year . "/" . $month . "/" . $day)))),
                "index" => date("w", strtotime((new Shamsi)->jalali_to_gregorian($year . "/" . $month . "/" . $day))),
                "unix" => strtotime((new Shamsi)->jalali_to_gregorian($year . "/" . $month . "/" . $day))
            ];
        }
        return $out;
    }
    static function mt_($num)
    {
        return bcdiv($num / 10000000, 2);
    }
    static function nice_number2($n)
    {
        return round($n / 10000000, 2);
    }
    static function nice_number($n)
    {
        // first strip any formatting;
        $n = (0 + str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) {
            return false;
        }

        // now filter it;
        if ($n > 1000000000000) {
            return round(($n / 1000000000000), 2) . 'T';
        } elseif ($n > 1000000000) {
            return round(($n / 1000000000), 2) . 'B';
        } elseif ($n > 1000000) {
            return round(($n / 1000000), 2) . 'M';
        } elseif ($n > 1000) {
            return round(($n / 1000), 2) . 'K';
        }

        return number_format($n);
    }
}
