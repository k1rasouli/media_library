<?php

namespace App\Http\Controllers;

use App\libs\Universal;
use App\Models\Media;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Store media via API
     */
    public function store(Request $request)
    {
        try
        {
            $instance = Universal::internalApiCall(route('media.store'), 'POST', $request->all());
            if($instance->status == Response::HTTP_FORBIDDEN)
                return redirect()->back()
                    ->with('errors', $instance->errors);
            elseif ($instance->status == Response::HTTP_UNAUTHORIZED)
                return redirect()->back()
                    ->with('message', $instance->message);
        }
        catch (\Exception $exception)
        {
            return redirect()->back()
                ->with('message', __('file_large_exception'));
        }


        return redirect()->back();
    }

    /**
     * @param Media $media
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * retrieving media info via api and send it to proper view
     */
    public function show(Media $media)
    {
        $instance = Universal::internalApiCall(route('categories.index'), 'GET', []);
        $categories = collect($instance->data);
        return view('admin.edit')
            ->with('categories', $categories->where('user.id' ,'=', auth()->user()->id))
            ->with('media', $media);
    }

    /**
     * @param Media $media
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Updating media via API
     */
    public function update(Media $media, Request $request)
    {
        try
        {
            $instance = Universal::internalApiCall(route('media.update', ['medium' => $media->id]), 'PATCH', $request->all());

            if($instance->status == Response::HTTP_FORBIDDEN)
                return redirect()->back()
                    ->with('errors', $instance->errors);
            elseif ($instance->status == Response::HTTP_UNAUTHORIZED)
                return redirect()->back()
                    ->with('message', $instance->message);
            return redirect(route('AdminIndex'));
        }
        catch (\Exception $exception)
        {
            return redirect()->back()
                ->with('message', __('file_large_exception'));
        }
    }

    /**
     * @param Media $media
     * @return \Illuminate\Http\RedirectResponse
     *
     * Deliting media from DB and storage
     */
    public function destroy(Media $media)
    {
        Universal::internalApiCall(route('media.destroy', $media), 'DELETE', []);
        return redirect()->back();
    }
}
