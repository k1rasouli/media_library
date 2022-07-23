<?php

namespace App\Http\Controllers;

use App\libs\Universal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $instance = Universal::internalApiCall(route('media.index'), 'GET', []);
        $media = collect($instance->data);
        $instance = Universal::internalApiCall(route('categories.index'), 'GET', []);
        $categories = collect($instance->data);
        return view('admin.index')
            ->with('media_list', $media->where('user_id' ,'=', auth()->user()->id))
            ->with('categories', $categories->where('user.id' ,'=', auth()->user()->id));
    }
}
