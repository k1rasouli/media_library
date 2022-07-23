<?php

namespace App\libs;

use App\Models\Media;
use App\libs\Games;
use App\libs\Movies;
use App\libs\Music;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class Universal
{
    /**
     * This Class contains some static methods that are required in several parts of application
     */


    /**
     * @param $route
     * @param $method
     * @param $data
     * @return mixed
     *
     * is method is for calling APIs in web controllers
     */
    public static function internalApiCall($route, $method, $data)
    {
        $req = Request::create($route, $method,$data);
        return json_decode(Route::dispatch($req)->getContent());
    }

    /**
     * @param $media_type
     * @return \App\libs\Games|\App\libs\Movies|\App\libs\Music|Media
     *
     * This method is for making proper objects out of classes based on media type
     */
    public static function mediaObject($media_type)
    {
        $media = new Media();
        switch ($media_type)
        {
            case 0:
                $media = new Music();
                break;
            case 1:
                $media = new Movies();
                break;
            case 2:
                $media = new Games();
                break;
        }
        return $media;
    }

    /**
     * @param $media_type
     * @param $media_order
     * @param $file_name
     * @return string
     *
     * Based on media type, proper media link is generated in this method
     */
    public static function mediaLink($media_type, $media_order, $file_name)
    {
        $mediaObject = self::mediaObject(array_search($media_type, Media::$media_type));
        return $mediaObject->getLink($mediaObject->file_address($media_type, $media_order) . $file_name);
    }
}
