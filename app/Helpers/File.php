<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class File
{
    public static function mkdirsWithTime($startedWithSeparator = true, $endedWithSeparator = true, $year = true, $month = true, $day = true)
    {
        $startedWithSeparator ? $dir = DIRECTORY_SEPARATOR : '';
        if ($year) {
            $dir .= date('Y') . DIRECTORY_SEPARATOR;
        }

        if ($month) {
            $dir .= date('m') . DIRECTORY_SEPARATOR;
        }

        if ($day) {
            $dir .= date('d') . DIRECTORY_SEPARATOR;
        }

        if (!$endedWithSeparator) {
            $dir = str_replace_last(DIRECTORY_SEPARATOR, '', $dir);
        }

        return $dir;
    }

    /**
     * @param UploadedFile $file
     * @param string $addition
     * @param bool $originalName
     * @param bool $time
     * @param string $separator
     * @return null|string
     */
    public static function newName(UploadedFile $file, $addition = '', $originalName = true, $time = true, $separator = '-')
    {
        $newFileName = '';
        if ($originalName && $time) {
            $newFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . $separator;
        } elseif ($originalName && !$time) {
            return $file->getClientOriginalName();
        }

        if ($addition) {
            $newFileName .= $addition . ($time ? $separator : '');
        }

        if ($time) {
            $newFileName .= time();
        }

        $newFileName .= '.' . $file->getClientOriginalExtension();

        return $newFileName;
    }

    public static function removeFile($filePath)
    {
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }
    }

    /**
     * @param UploadedFile $file
     * @param $publicDir
     * @param $fileName
     * @param bool $originalName
     * @param bool $time
     * @return string
     */
    public static function uploadFile(UploadedFile $file, $publicDir, $fileName, $originalName = false, $time = true)
    {
        $fileName = File::newName($file, $fileName, $originalName, $time);
        $timeDir = File::mkdirsWithTime();
        $destinationPath = public_path($publicDir . $timeDir);
        $file->move($destinationPath, $fileName);

        return $timeDir . $fileName;
    }

    /**
     * @param $fileName
     * @param $publicDir
     */
    public static function removePublicFile($fileName, $publicDir)
    {
        $fileName = str_replace('/', DIRECTORY_SEPARATOR, $fileName);
        $filePath = public_path($publicDir . DIRECTORY_SEPARATOR . $fileName);
        self::removeFile($filePath);
    }
}
