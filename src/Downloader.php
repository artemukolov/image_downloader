<?php

/*
 * This is image downloader script
 *
 * (c) Artem Ukolov <artem@ukolov.info>
 *
 */

namespace ArtemUkolov\ImageDownloader;

/**
 * Class DownLoader
 *
 */

class DownLoader
{
     /** @var allowed file formats */
    private static $allowedFormats = ["image/jpeg", "image/gif", "image/png"];

     /** @var local folder for files */
    private static $localFolder = __DIR__."/files/";

    /**
     * Main function for downloading
     *
     * @param string $url source image address
     *
     * @return string or boolean Return path of downloaded file or false, if we take some error
     */
    public function get($url)
    {
        $fileinfo  = @get_headers($url, true);

        if (!$fileinfo){
            throw new \Exception('Remote file does not exist!');    
            return false;
        }

        if (!in_array($fileinfo['Content-Type'], self::$allowedFormats)){
            throw new \Exception('Format of remote file not allowed!');    
            return false;
        }

        $localFile = self::$localFolder.basename($url);
        if (file_exists($localFile)){
            throw new \Exception('File is already downloaded!');    
            return false;
        }

        file_put_contents($localFile, file_get_contents($url));
        if (!file_exists($localFile)){
            throw new \Exception('Error to save local file!');    
            return false;
        }
        return $localFile;
    }
}
