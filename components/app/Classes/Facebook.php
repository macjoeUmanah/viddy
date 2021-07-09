<?php
namespace App\Classes;
use App\Models\Admin\APIKeys;

class Facebook
{

    function download($url)
    {

        $api_key = APIKeys::findOrFail(1);

        if ( !empty($api_key->facebook_cookies) ) {

            //$url = get_original_url(remove_mfb($url));
            
            $url = remove_mfb($url);

            $get_source = fb_get_contents($url, $api_key->facebook_cookies);

            preg_match_all('/<script type="application\/ld\+json" nonce="\w{3,10}">(.*?)<\/script><link rel="canonical"/', $get_source, $matches);

            preg_match_all('/"video":{(.*?)},"video_home_www_injection_related_chaining_section"/', $get_source, $matches2);

            preg_match_all('/"playable_url":"(.*?)"/', $get_source, $matches3);

            $video['source'] = 'Facebook';

            $video['duration']  = format_seconds(ISO8601ToSeconds( $this->getDuration($get_source) ) );
            
            $video['links'] = [];

            if (!empty($matches[1][0])) {

                $data = json_decode($matches[1][0], true);

                if (empty($data) || $data['@type'] != 'VideoObject') {

                    //echo 'fail 1';

                    //print_r($matches[1][0]);

                    return false;
                }

                $video['title'] = $data['name'];

                $thumbnail = file_get_contents( $data['thumbnailUrl'] );

                $dataBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbnail);

                $video['thumbnail'] = $dataBase64;

                if (!empty($data['contentUrl'])) {

                    $bytes = get_file_size($data['contentUrl'], false);

                    array_push($video['links'], [
                        'url'     => $data['contentUrl'],
                        'type'    => 'mp4',
                        'bytes'   => $bytes,
                        'size'    => format_size($bytes),
                        'quality' => 'SD',
                        'mute'    => false
                    ]);
                }

                $hd_link = get_string_between($get_source, 'hd_src:"', '"');

                if (!empty($hd_link)) {

                    $bytes = get_file_size($hd_link, false);

                    array_push($video['links'], [
                        'url'     => $hd_link,
                        'type'    => 'mp4',
                        'bytes'   => $bytes,
                        'size'    => format_size($bytes),
                        'quality' => 'HD',
                        'mute'    => false
                    ]);
                }
            } else if (!empty($matches2[1][0])) {

                $json = "{" . $matches2[1][0] . "}";

                $data = json_decode($json, true);

                if (empty($data) || !!empty($data['story']['attachments'][0]['media']['__typename']) || $data['story']['attachments'][0]['media']['__typename'] != 'Video') {
                    //echo 'fail 2';
                    return false;
                }

                $video['title']     = $data['story']['message']['text'];

                $thumbnail = file_get_contents( $data['story']['attachments'][0]['media']['thumbnailImage']['uri'] );

                $dataBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbnail);

                $video['thumbnail'] = $dataBase64;

                if (!empty($data['story']['attachments'][0]['media']['playable_url'])) {

                    $bytes = get_file_size($data['story']['attachments'][0]['media']['playable_url'], false);

                    array_push($video['links'], [
                        'url'     => $data['story']['attachments'][0]['media']['playable_url'],
                        'type'    => 'mp4',
                        'bytes'   => $bytes,
                        'size'    => format_size($bytes),
                        'quality' => 'SD',
                        'mute'    => false
                    ]);
                }
                if (!empty($data['story']['attachments'][0]['media']['playable_url_quality_hd'])) {

                    $bytes = get_file_size($data['story']['attachments'][0]['media']['playable_url_quality_hd'], false);

                    array_push($video['links'], [
                        'url' => $data['story']['attachments'][0]['media']['playable_url_quality_hd'],
                        'type' => 'mp4',
                        'bytes' => $bytes,
                        'size' => format_size($bytes),
                        'quality' => 'HD',
                        'mute' => false
                    ]);
                }
            } else if (!empty($matches3[1][0])) {

                preg_match('/"preferred_thumbnail":{"image":{"uri":"(.*?)"/', $get_source, $thumbnail);

                preg_match_all('/"playable_url_quality_hd":"(.*?)"/', $get_source, $hd_link);

                $video['title'] = 'Facebook Video';

                $thumbnail = file_get_contents( !empty($thumbnail[1]) ? $this->decode_json_text($thumbnail[1]) : '' );

                $dataBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbnail);

                $video['thumbnail'] = $dataBase64;

                $sd_link = $this->decode_json_text($matches3[1][0]);

                $bytes = get_file_size($sd_link, false);

                array_push($video['links'], [
                    'url'     => $sd_link,
                    'type'    => 'mp4',
                    'bytes'   => $bytes,
                    'size'    => format_size($bytes),
                    'quality' => 'SD',
                    'mute'    => false
                ]);

                if (!empty($hd_link[1][0])) {

                    $hd_link = $this->decode_json_text($hd_link[1][0]);

                    $bytes = get_file_size($hd_link, false);

                    array_push($video['links'], [
                        'url'     => $hd_link,
                        'type'    => 'mp4',
                        'bytes'   => $bytes,
                        'size'    => format_size($bytes),
                        'quality' => 'HD',
                        'mute'    => false
                    ]);
                }
            } else {
                //echo 'fail 3';
                return false;
            }

            return $video;

        } else{

            session()->flash('status', 'error');
            session()->flash('message', 'Invalid Cookies!');
            return;
        }

    }

    function decode_json_text($text)
    {
        $json = '{"text":"' . $text . '"}';
        $json = json_decode($json, 1);
        return $json["text"];
    }
    
    function getDuration($curl_content)
    {
        $regexDuration = '/"duration":"(.*?)"/';

        if (preg_match($regexDuration, $curl_content, $match)) {

            return str_replace('\/', '/', $match[1]);

        } else return;
    }

}