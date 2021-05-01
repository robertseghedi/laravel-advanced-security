<?php

namespace RobertSeghedi\LAS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory, Cache;
use Illuminate\Database\Eloquent\Model, Request;
use Illuminate\Support\Facades\Crypt, Illuminate\Contracts\Encryption\DecryptException;
use RobertSeghedi\LAS\Models\SecureLog;

class LAS extends Model
{
        public static function ip($type = 0)
        {
            if($type == 0)
            {
                $ip = Request::ip();
            }
            else if($type == 1)
            {
                $ip = Crypt::encrypt(Request::ip());
            }
            return $ip;
        }
        public static function purify($data)
        {
            $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
            $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
            $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
            $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
            $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
            $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
            $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
            $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
            do
            {
                $rodata = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|div|noscript|marquee|svg|polygon|plaintext|isindex|img|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
            }
            while ($rodata !== $data);
            return mb_convert_encoding($data, 'UTF-8', 'Windows-1252');
        }
        public static function os() {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $os_platform =   "Bilinmeyen İşletim Sistemi";
            $os_array =   array(
            '/windows nt 10/i'      =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
            );
            foreach ( $os_array as $regex => $value ) {
                if ( preg_match($regex, $user_agent ) ) {
                    $os_platform = $value;
                }
            }
            return $os_platform;
        }
        public static function browser() {
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            $browser        = "Bilinmeyen Tarayıcı";
            $browser_array  = array(
                '/msie/i'       =>  'Internet Explorer',
                '/firefox/i'    =>  'Firefox',
                '/safari/i'     =>  'Safari',
                '/chrome/i'     =>  'Chrome',
                '/edge/i'       =>  'Edge',
                '/opera/i'      =>  'Opera',
                '/netscape/i'   =>  'Netscape',
                '/maxthon/i'    =>  'Maxthon',
                '/konqueror/i'  =>  'Konqueror',
                '/mobile/i'     =>  'Handheld Browser'
            );
            foreach ( $browser_array as $regex => $value ) {
                if ( preg_match( $regex, $user_agent ) ) {
                    $browser = $value;
                }
            }
            return $browser;
        }
        public static function file_size($size)
        {
            $filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
            return $size ? round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) .$filesizename[$i] : '0 Bytes';
        }
        public static function password($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        public static function pin($length = 4) {
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        public static function isSSL()
        {
            if(!empty($_SERVER['https']))
            {
                return 'secure';
            }
            elseif(!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            {
                return 'secure';
            }
            else
            {
                return 'not secure';
            }
        }
        public static function log($user, $text)
        {
            $securelog = new SecureLog();
            $securelog->user = $user;
            $securelog->string = Crypt::encrypt($text);
            $securelog->ip = Crypt::encrypt(LAS::ip());
            $securelog->os = Crypt::encrypt(LAS::os());
            $securelog->browser = Crypt::encrypt(LAS::browser());
            $saved_secure_log = $securelog->save();

            return $saved_secure_log;
        }
        public static function logs($user, $results = 'none', $time = 1800)
        {
            if($results == 'none')
            {
                Cache::forget("userlogs_$user");
                $ao = Cache::remember("userlogs_$user", $time, function () use ($user) {
                    $ao = SecureLog::where('user', $user)->get()->lazy()->each(function($a){
                        $a->text = Crypt::decrypt($a->string);
                    });
                    return (object) $ao;
                });
                return json_encode($ao);
            }
            elseif($results != 'none')
            {
                Cache::forget("userlogs_$user");
                $ao = Cache::remember("userlogs_$user", $time, function () use ($user, $results) {
                    $ao = SecureLog::where('user', $user)->take($results)->get();
                    foreach($ao as $a)
                    {
                        $a->text = Crypt::decrypt($a->string);
                    }
                    return (object) $ao;
                });
                return json_encode($ao);
            }
        }
        public static function all_logs($results = 'none', $time = 1800)
        {
            if($results == 'none')
            {
                Cache::forget("user_alllogs");
                $ao = Cache::remember("user_alllogs", $time, function () {
                    $ao = SecureLog::all()->lazy()->each(function($a){
                        $a->text = Crypt::decrypt($a->string);
                    });
                    return (object) $ao;
                });
                return json_encode($ao);
            }
        }
}
