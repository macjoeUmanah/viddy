<?php
namespace App\Classes;
class TikTok
{

	private $patterns = ['<link data-react-helmet="true" rel="canonical" href="','"/>','>','</','id="__NEXT_DATA__"'];

    function download($url)
    {

    	$tiktokUrl = trim($url);

        $get_source = tiktok_get_contents($tiktokUrl);

        if(strpos($get_source, $this->patterns[0]) !== false){

            $tiktokUrl = explode($this->patterns[1],explode($this->patterns[0],$get_source)[1])[0];

            $get_source = tiktok_get_contents($tiktokUrl);
        }
    
        $json = explode($this->patterns[2],explode($this->patterns[3],explode($this->patterns[4],$get_source)[1])[0])[1];

        $json = json_decode($json);

        if($json == null){

            return false;
        }

        $videoKey = tiktok_get_key($json->props->pageProps->itemInfo->itemStruct->video->downloadAddr);

        $video['title'] = $json->props->pageProps->seoProps->metaParams->title;

        $video['source'] = "TikTok";

        $thumbnail = file_get_contents( $json->props->pageProps->itemInfo->itemStruct->video->cover );

        $dataBase64 = 'data:image/jpeg;base64,' . base64_encode($thumbnail);
        
        $video['thumbnail'] = $dataBase64;

        $video['duration'] = format_seconds( $json->props->pageProps->itemInfo->itemStruct->video->duration );

        $dlLink = url('/') . '/dl.php?u=' . encode(urlencode($json->props->pageProps->itemInfo->itemStruct->video->downloadAddr)) . '&t=' . strip_tags($json->props->pageProps->itemInfo->itemStruct->video->id) . '&f=v';

        $video['links'][0]['url'] = $dlLink;

        $video['links'][0]['type'] = 'mp4';

        $video['links'][0]['bytes'] = 0;

        $video['links'][0]['size'] = 0;

        $video['links'][0]['quality'] = $json->props->pageProps->itemInfo->itemStruct->video->ratio;

        $video['links'][0]['mute'] = 'no';
  
        return $video;

    }

}