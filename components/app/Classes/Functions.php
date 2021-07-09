<?php 

    function url_get_contents($url)
    {
        $process = curl_init($url); 
        curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36'); 
        curl_setopt($process, CURLOPT_TIMEOUT, 60); 
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

    function vlive_get_contents($url)
    {
        $process = curl_init($url); 
        curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36'); 
        curl_setopt($process, CURLOPT_REFERER, 'https://www.vlive.tv/');
        curl_setopt($process, CURLOPT_TIMEOUT, 60); 
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

    function fb_get_contents($url, $cookie)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'authority: www.facebook.com',
                'cache-control: max-age=0',
                'sec-ch-ua: "Google Chrome";v="89", "Chromium";v="89", ";Not A Brand";v="99"',
                'sec-ch-ua-mobile: ?0',
                'upgrade-insecure-requests: 1',
                'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36',
                'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                'sec-fetch-site: none',
                'sec-fetch-mode: navigate',
                'sec-fetch-user: ?1',
                'sec-fetch-dest: document',
                'accept-language: en-GB,en;q=0.9,tr-TR;q=0.8,tr;q=0.7,en-US;q=0.6',
                'cookie: ' . $cookie
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    function ins_get_contents($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'ig-cookie.txt');
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    function get_original_url($url, $max_redirs = 3)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, $max_redirs);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.105 Safari/537.36');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        return $url;
    }

    function remove_mfb($url)
    {
        $url = str_replace("m.facebook.com", "www.facebook.com", $url);
        return $url;
    }

    function tiktok_get_contents($url, $geturl = false)
    {

        $url = trim($url);   
        $ch = curl_init();
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.111 Mobile Safari/537.36',
            CURLOPT_ENCODING       => "utf-8",
            CURLOPT_AUTOREFERER    => false,
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
        $resp = curl_exec($ch);
        curl_close($ch);
        return $resp;

    }

	function tiktok_get_key($playable)
	{
	  	$ch = curl_init();
	  	$headers = [
	        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
	        'Accept-Encoding: gzip, deflate, br',
	        'Accept-Language: en-US,en;q=0.9',
	        'Range: bytes=0-200000'
	    ];

	    $options = array(
	        CURLOPT_URL            => $playable,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HEADER         => false,
	        CURLOPT_HTTPHEADER     => $headers,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0',
	        CURLOPT_ENCODING       => "utf-8",
	        CURLOPT_AUTOREFERER    => false,
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

	  $data = curl_exec($ch);

	  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	  curl_close($ch);

	  $tmp = explode("vid:", $data);

	  if(count($tmp) > 1){
	     $key = trim(explode("%", $tmp[1])[0]);
	 }
	 else $key = "";

	 return $key;
	}

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

    function url_post_contents($url,$data) {
        $headers = [
            'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg',
            'Connection: Keep-Alive',
            'Content-type: application/x-www-form-urlencoded;charset=UTF-',
            'Range: bytes=0-200000'
        ];
        $process = curl_init($url);
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($process, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.3');
        curl_setopt($process, CURLOPT_COOKIEFILE, 'cookie.txt');
        curl_setopt($process, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($process, CURLOPT_TIMEOUT, 60);
        curl_setopt($process, CURLOPT_POSTFIELDS, $data);
        curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($process, CURLOPT_POST, 1);
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($process,CURLOPT_CAINFO, NULL); 
        curl_setopt($process,CURLOPT_CAPATH, NULL); 
        $return = curl_exec($process);
        curl_close($process);
        return $return;
    }

	function ISO8601ToSeconds($ISO8601)
	{
	    preg_match('/\d{1,2}[H]/', $ISO8601, $hours);
	    preg_match('/\d{1,2}[M]/', $ISO8601, $minutes);
	    preg_match('/\d{1,2}[S]/', $ISO8601, $seconds);
	    
	    $duration = [
	        'hours'   => $hours ? $hours[0] : 0,
	        'minutes' => $minutes ? $minutes[0] : 0,
	        'seconds' => $seconds ? $seconds[0] : 0,
	    ];

	    if ( !empty($duration['hours']) ) {
	    	$hours   = substr($duration['hours'], 0, -1);
	    } else $hours = 0;

	    if ( !empty($duration['minutes']) ) {
	    	$minutes   = substr($duration['minutes'], 0, -1);
	    } else $minutes = 0;

	    if ( !empty($duration['seconds']) ) {
	    	$seconds   = substr($duration['seconds'], 0, -1);
	    } else $seconds = 0;

	    $toltalSeconds = ($hours * 60 * 60) + ($minutes * 60) + $seconds;

	    return $toltalSeconds;
	}

    function cleanStr($str)
    {
        return html_entity_decode(strip_tags($str), ENT_QUOTES, 'UTF-8');
    }

	function get_string_between($string, $start, $end)
	{
	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);
	}

	function format_seconds($seconds)
	{
	    return gmdate(($seconds > 3600 ? "H:i:s" : "i:s"), $seconds);
	}

	function sort_by_quality($a, $b)
	{
	    return (int)$a['quality'] - (int)$b['quality'];
	}

    function get_file_size( $url ) {
      
        $headers = get_headers( $url, 1);

        if ( isset($headers['Content-Length']) ) {

            $size = $headers['Content-Length'];
        }
        else {

            $size = 0;
        }

        return $size;
    }

    function format_size($bytes)
    {
        switch ($bytes) {
            case $bytes < 1024:
                $size = $bytes . " B";
                break;
            case $bytes < 1048576:
                $size = round($bytes / 1024, 2) . " KB";
                break;
            case $bytes < 1073741824:
                $size = round($bytes / 1048576, 2) . " MB";
                break;
            case $bytes < 1099511627776:
                $size = round($bytes / 1073741824, 2) . " GB";
                break;
        }
        if (!empty($size)) {
            return $size;
        } else {
            return "";
        }
    }

    function get_client_ip()
    {
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    		$ip = $_SERVER['HTTP_CLIENT_IP'];
    	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    	} else {
    		$ip = $_SERVER['REMOTE_ADDR'];
    	}
    	return $ip;
    }

    function encode($pData)
    {
        $encryption_key = 'themeluxurydotcom';

        $encryption_iv = '9999999999999999';

        $ciphering = "AES-256-CTR"; 
          
        $encryption = openssl_encrypt($pData, $ciphering, $encryption_key, 0, $encryption_iv);

        return $encryption;  

    }
