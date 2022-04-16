<?php

/**
 * **get_content_mime_type
 * 
 * @param  string $content, the content or the file whose mime type you want to know.
 * @return string 
 */
function get_content_mime_type($content)
{
    $url = 'http://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types';
    $url_live = false;
    $handle = curl_init($url);
    curl_setopt_array($handle, array(
        CURLOPT_FOLLOWLOCATION => TRUE,
        CURLOPT_NOBODY => TRUE,
        CURLOPT_HEADER => FALSE,
        CURLOPT_RETURNTRANSFER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE,
        CURLOPT_SSL_VERIFYPEER => FALSE
    ));
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_EFFECTIVE_URL);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if ($httpCode == 200) {
        $url_live = true;
    }
    $url_live = $url_live;
    curl_close($handle);
    $mimes = array();
    if ($url_live) {
        $mimes_file = file_get_contents($url);
        preg_match_all('#^([^\s]{2,}?)\s+(.+?)$#ism', $mimes_file, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $exts = explode(" ", $match[2]);
            foreach ($exts as $ext) {
                $mimes[$ext] = $match[1];
            }
        }
    } else {
        $mimes = array(
            'txt'  => 'text/plain',
            'htm'  => 'text/html',
            'html' => 'text/html',
            'php'  => 'text/html',
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'xml'  => 'application/xml',
            'swf'  => 'application/x-shockwave-flash',
            'flv'  => 'video/x-flv',
            // images
            'png'  => 'image/png',
            'jpe'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg'  => 'image/jpeg',
            'gif'  => 'image/gif',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif'  => 'image/tiff',
            'svg'  => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            // archives
            'zip'  => 'application/zip',
            'rar'  => 'application/x-rar-compressed',
            'exe'  => 'application/x-msdownload',
            'msi'  => 'application/x-msdownload',
            'cab'  => 'application/vnd.ms-cab-compressed',
            // audio/video
            'mp3'  => 'audio/mpeg',
            'qt'   => 'video/quicktime',
            'mov'  => 'video/quicktime',
            // adobe
            'pdf'  => 'application/pdf',
            'psd'  => 'image/vnd.adobe.photoshop',
            'ai'   => 'application/postscript',
            'eps'  => 'application/postscript',
            'ps'   => 'application/postscript',
            // ms office
            'doc'  => 'application/msword',
            'rtf'  => 'application/rtf',
            'xls'  => 'application/vnd.ms-excel',
            'ppt'  => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',
            // open office
            'odt'  => 'application/vnd.oasis.opendocument.text',
            'ods'  => 'application/vnd.oasis.opendocument.spreadsheet',
        );
    }
    $content_mime = 'unknown';
    if (is_file($content)) {
        if (isset(pathinfo($content)['extension'])) {
            $content_ext = pathinfo($content)['extension'];
            if (isset($mimes[$content_ext])) {
                $content_mime = $mimes[$content_ext];
            } else {
                if (is_readable($content) && is_executable($content)) {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $content_mime = finfo_file($finfo, $content);
                    if ($content_mime === null || $content_mime === "") {
                        $content_mime = "application/octet-stream";
                    } else {
                        $content_mime = $content_mime;
                    }
                    finfo_close($finfo);
                } else {
                    $content_mime = "application/octet-stream";
                }
            }
        }
    } else {
        // return whatever you want
        // $content_mime = 'unknown';
    }
    $content_mime = $content_mime;
    return $content_mime;
}
