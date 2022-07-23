<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResourse;
use App\libs\Universal;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * Display a listing of the media resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $mediaList = Media::join('categories', 'categories.id', '=', 'media.category_id')
            ->join('users', 'users.id' ,'=', 'media.user_id')
            ->select(
                'media.id as id',
                'media.media_type as media_type',
                'media.media_title as media_title',
                'media.media_order as media_order',
                'media.media_size as media_size',
                'media.extension as extension',
                'media.file_name as file_name',
                'categories.category_title as category_title',
                'categories.slug as category_slug',
                'users.id as user_id',
                'users.name as user_name',
                'users.email as user_email',
            )
            ->get();

        return MediaResourse::collection($mediaList);
    }

    /**
     * Store a newly created meda resource in storage and DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validation($request, Media::$rules);

        if($validator->passes())
        {
            $media = $this->mediaObject($request->media_type);

            $file_info = $media->fileInfo($request->media_file);
            if($media->check_extension(strtolower($file_info['extension'])))
            {
                $media_order = Media::last_order();
                $request->media_file->storeAs('public/' . strtolower(Media::$media_type[$request->media_type]) . '/' . $media_order, $file_info['file_name']);
                Media::create([
                    'media_type' => $request->media_type,
                    'media_title' => $request->media_title,
                    'media_order' => $media_order,
                    'media_size' => $file_info['size'],
                    'extension' => $file_info['extension'],
                    'file_name' =>$file_info['file_name'],
                    'category_id' => $request->category_id,
                    'user_id' => auth()->user()->id,
                ]);
                return response()->json([
                    'status' => Response::HTTP_OK
                ]);
            }
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => __('not_allowed_extension')
            ]);

        }
        return response()->json([
            'status' => Response::HTTP_FORBIDDEN,
            'errors' => $validator->errors()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return MediaResourse
     */
    public function show(Media $medium)
    {
        return new MediaResourse($medium);
    }

    /**
     * Update the specified resource in storage and DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Media $medium)
    {
        $validator = $this->validation($request, Media::$editRules);
        if($validator->passes())
        {
            $media = $this->mediaObject($request->media_type);
            $file_info = ['file_name' => $medium->file_name, 'extension' => $medium->extension, 'size' => $medium->media_size];

            $media_order = $medium->media_order;
            if($request->media_file)
            {
                $file_info = $media->fileInfo($request->media_file);
                if(!$media->check_extension(strtolower($file_info['extension'])))
                    return response()->json([
                        'status' => Response::HTTP_UNAUTHORIZED,
                        'message' => __('not_allowed_extension')
                    ]);

                $file_address = $media->file_address($request->media_type, $media_order);
                $request->media_file->storeAs('public/' . strtolower(Media::$media_type[$request->media_type]) . '/' . $media_order, $file_info['file_name']);
                Storage::delete($file_address . $medium->file_name);
            }
            $medium->update([
                'media_type' => $request->media_type,
                'media_title' => $request->media_title,
                'media_size' => $file_info['size'],
                'extension' => $file_info['extension'],
                'file_name' =>$file_info['file_name'],
                'category_id' => $request->category_id
            ]);
            return response()->json([
                'status' => Response::HTTP_OK
            ]);
        }
        return response()->json([
            'status' => Response::HTTP_FORBIDDEN,
            'errors' => $validator->errors()
        ]);
    }

    /**
     * Remove the specified resource from storage and DB.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Media $medium)
    {
        $media = new Media();
        $file_address = $media->file_address($medium->media_type, $medium->media_order);
        Storage::delete($file_address . $medium->file_name);
        $medium->delete();
        return response()->json([
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    private function validation(Request $request, $rules)
    {
        $message = [
            'category_id.required' => __('category_first'),
            'category_id.exists' => __('category_not_found')
        ];
        $inputs = [
            'media_title' => $request->media_title,
            'media_type' => $request->media_type,
            'category_id' => $request->category_id,
            'media_file' => $request->media_file
        ];
        return Validator::make($inputs, $rules, $message);
    }

    /**
     * @param $media_type
     * @return \App\libs\Games|\App\libs\Movies|\App\libs\Music|Media
     *
     * Create media object from a universal method based on media type
     */
    private function mediaObject($media_type)
    {
        return Universal::mediaObject($media_type);
    }
}
