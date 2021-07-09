<?php
namespace App\Classes;
use App\Models\Admin\APIKeys;

class Instagram
{
    private $get_source;

    function download($url)
    {
        $api_key = APIKeys::findOrFail(1);

        if ( !empty($api_key->instagram_cookies) ) {

            $url = $url = strtok($url, '?');

            if (substr($url, -1) != '/') {

                $url .= "/";

            }

            $this->get_source = ins_get_contents( $url . 'embed/captioned/' );

            preg_match_all('/window.__additionalDataLoaded\(\'extra\',(.*?)\);<\/script>/', $this->get_source, $matches);

            if (!isset($matches[1][0]) || empty($matches[1][0])) {

                return false;
            }

            $data = json_decode($matches[1][0], true);

            $video['links'] = array();

            if (!isset($data['shortcode_media'])) {

                preg_match_all('/<img class="EmbeddedMediaImage" alt=".*" src="(.*?)"/', $this->get_source, $matches);

                if (isset($matches[1][0]) != "") {

                    $video['title'] = get_string_between($this->get_source, '<img class="EmbeddedMediaImage" alt="', '"');

                    $video['source'] = "Instagram";                

                    $media_url = html_entity_decode($matches[1][0]);

                    $thumbnail = file_get_contents( $media_url );

                    $dataBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbnail);

                    $video['thumbnail'] = $dataBase64;

                    $bytes = get_file_size( $media_url );

                    array_push($video['links'], [
                        'url'     => $media_url,
                        'type'    => 'jpg',
                        'bytes'   => $bytes,
                        'size'    => format_size($bytes),
                        'quality' => 'HD',
                        'mute'    => 'no'
                    ]);

                } else return;

            } else {

                //$video['title'] = ($data['shortcode_media']['edge_media_to_caption']['edges'][0]['node']['text']) ? $data['shortcode_media']['edge_media_to_caption']['edges'][0]['node']['text'] : '';

                if (isset($data['shortcode_media']['owner']['username']) != "") {

                    $video['title'] = "Instagram Post from " . $data['shortcode_media']['owner']['username'];

                } else {

                    $video['title'] = "Instagram Post";
                }

                $video['source'] = "Instagram";

                $thumbnail = file_get_contents( $data['shortcode_media']['display_resources'][0]['src'] );

                $dataBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbnail);

                $video['thumbnail'] = $dataBase64;

                if ($data['shortcode_media']['__typename'] == "GraphImage") {

                    $images_data = $data['shortcode_media']['display_resources'];

                    $length = count($images_data);

                    $bytes = get_file_size( $images_data[$length - 1]['src'] );

                    array_push($video['links'], [
                        'url'     => $images_data[$length - 1]['src'],
                        'type'    => 'jpg',
                        'bytes'   => $bytes,
                        'size'    => format_size($bytes),
                        'quality' => 'HD',
                        'mute'    => 'no'
                    ]);

                } else {

                    if ($data['shortcode_media']['__typename'] == "GraphSidecar") {

                        $multiple_data = $data['shortcode_media']['edge_sidecar_to_children']['edges'];

                        foreach ($multiple_data as $media) {

                            if ($media['node']['is_video'] == "true") {

                                $media_url = $media['node']['video_url'];

                                $type = "mp4";

                            } else {
                                $length = count($media['node']['display_resources']);

                                $media_url = $media['node']['display_resources'][$length - 1]['src'];

                                $type = "jpg";
                            }
                            $bytes = get_file_size($media_url);

                            array_push($video['links'], [
                                'url'     => $media_url,
                                'type'    => $type,
                                'bytes'   => $bytes,
                                'size'    => format_size($bytes),
                                'quality' => 'HD',
                                'mute'    => 'no'
                            ]);
                        }
                    } else {
                        if ($data['shortcode_media']['__typename'] == "GraphVideo") {

                            $bytes = get_file_size( $data['shortcode_media']['video_url'] );

                            array_push($video['links'], [
                                'url'     => $data['shortcode_media']['video_url'],
                                'type'    => 'mp4',
                                'bytes'   => $bytes,
                                'size'    => format_size($bytes),
                                'quality' => 'HD',
                                'mute'    => 'no'
                            ]);
                        }
                    }
                }
            }

            return $video;
            
        } else{

            session()->flash('status', 'error');
            session()->flash('message', 'Invalid Cookies!');
            return;
        }

    }

}