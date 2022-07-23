<?php

namespace App\Http\Controllers;

use App\libs\Universal;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Getting categories from API
     */
    public function index()
    {
        $instance = Universal::internalApiCall(route('categories.index'), 'GET', []);
        $categories = collect($instance->data);
        return view('admin.categories.index')
            ->with('categories', $categories->where('user.id' ,'=', auth()->user()->id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * Storing new category via API
     */

    public function store(Request $request)
    {
        $instance = Universal::internalApiCall(route('categories.store'), 'POST', $request->all());

        if($instance->status == Response::HTTP_FORBIDDEN)
            return redirect()->back()
                ->with('errors', $instance->errors);
        return redirect()->back();
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Showing single category from API
     */
    public function show(Category $category)
    {
        return view('admin.categories.edit')
            ->with('category', $category);
    }

    /**
     * @param Category $category
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * Updating single category via API
     */
    public function update(Category $category, Request $request)
    {
        $instance = Universal::internalApiCall(route('categories.update', $category), 'PATCH', $request->all());

        if($instance->status == Response::HTTP_FORBIDDEN)
            return redirect()->back()
                ->with('errors', $instance->errors);
        return redirect(route('CategoriesIndex'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     *
     * Deleting a category from DB via API
     */
    public function destroy(Category $category)
    {
        Universal::internalApiCall(route('categories.destroy', $category), 'DELETE', []);
        return redirect()->back();
    }
}
