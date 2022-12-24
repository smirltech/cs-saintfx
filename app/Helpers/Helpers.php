<?php

namespace App\Helpers;

use App\Enums\InscriptionStatus;


class Helpers
{

    public static function error()
    {
        return abort(404);
    }

    // remove spaces and special characters from a string
    public static function removeSpaceBetween($string): array|string|null
    {
        return preg_replace('/\s+/', '', $string);
    }

    public static function humanPermission($permission)
    {
        return $permission;
    }

    // formatBytes
    public static function formatBytes($bytes, $precision = 1): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public static function currencyFormat($amount, $decimal = 0, $symbol = ''): string
    {

        return number_format($amount, $decimal) . ' ' . $symbol;

    }

    public static function fakePicsum($user_id, $width = 50, $height = 50): string
    {
        /*$req = Http::get("https://picsum.photos/id/{$user_id}/info");
        return json_decode($req->body())->download_url;*/

        return "https://picsum.photos/id/{$user_id}/{$width}/{$height}";

    }

    public static function admissionStatusColor($admissionStatus): string
    {

        switch ($admissionStatus) {
            case InscriptionStatus::pending:
                return "info";
            case InscriptionStatus::approved:
                return "success";
            case InscriptionStatus::rejected:
                return "danger";
            case InscriptionStatus::canceled:
                return "secondary";
            default :
                return "primary";
        }
    }

    // fetchAvatar
    public static function fetchAvatar($name, $width = 50, $height = 50): string
    {
        $name = str_replace(' ', '+', $name);
        return "https://ui-avatars.com/api/?name={$name}&background=random&size={$width}x{$height}&color=random";
    }

    // pad
    public static function pad($number, $length = 2): string
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }
}
