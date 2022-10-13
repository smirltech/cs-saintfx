<?php

namespace App\Helpers;

use App\Enum\AdmissionStatus;
use App\Mail\SendMail;
use phpseclib3\Math\PrimeField\Integer;


class Helpers
{

    public static function error()
    {
        return abort(404);
    }

    // remove spaces and special characters from a string
    public static function removeSpaceBetween($string)
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

    public static function admissionStatusColor($admissionStatus)
    {

        switch ($admissionStatus) {
            case AdmissionStatus::pending:
                return "info";
            case AdmissionStatus::approved:
                return "success";
            case AdmissionStatus::rejected:
                return "danger";
            case AdmissionStatus::canceled:
                return "secondary";
            default :
                return "primary";
        }
    }
}
