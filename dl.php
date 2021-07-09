<?php 

function tiktok_force_download($directUrl, $title, $format){
    if($format != "a" && $format != "v")
    {
        die('File Format Error !');
    }
    $format = ($format == 'v')?'.mp4':'.mp3';
    $ch = curl_init();
    $headers = array(
        'Range: bytes=0-',
    );
    $options = array(
        CURLOPT_URL            => $directUrl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_FOLLOWLOCATION => true,
        CURLINFO_HEADER_OUT    => true,
        CURLOPT_USERAGENT      => 'okhttp',
        CURLOPT_ENCODING       => "utf-8",
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_COOKIEJAR      => 'cookie.txt',
        CURLOPT_COOKIEFILE     => 'cookie.txt',
        CURLOPT_REFERER        => 'https://www.tiktok.com/',
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 30,
        CURLOPT_MAXREDIRS      => 10,
    );
    curl_setopt_array( $ch, $options );

    if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    }
    
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', time()) . ' GMT');
    header('Cache-Control: private', false);
    header('Content-Type: application/force-download');
    header('Content-Disposition: attachment; filename="' . basename($title) . $format);
    header('Content-Transfer-Encoding: binary');
    
    $video = curl_exec($ch);    
    curl_close($ch);

    echo $video;
}

function decode($pData)
{
    $encryption_key = 'themeluxurydotcom';

    $decryption_iv = '9999999999999999';

    $ciphering = "AES-256-CTR"; 
    
    $pData = str_replace(' ','+', $pData);

    $decryption = openssl_decrypt($pData, $ciphering, $encryption_key, 0, $decryption_iv);

    return $decryption;
}

if ( !empty($_GET['u']) && $_GET['t'] && $_GET['f'] ) {

    $directUrl = urldecode( decode( $_GET['u'] ) );

    $title = urldecode($_GET['t']);

    $format = strip_tags( $_GET['f'] );

    tiktok_force_download($directUrl, $title, $format);

} else echo 'Silence is Golden!';


