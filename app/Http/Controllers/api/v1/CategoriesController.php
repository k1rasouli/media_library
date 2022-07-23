<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the category resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::with('user')->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created category resource in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validation($request);

        if($validator->passes())
        {
            Category::create($validator->validated());
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
     * Display the specified category resource.
     *
     * @param  \App\Models\Category  $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified category resource in DB.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $validator = $this->validation($request);
        if($validator->passes())
        {
            $category->update($validator->validated());
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
     * Remove the specified category resource from DB.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => Response::HTTP_NO_CONTENT,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     *
     * Validate inputs
     */
    private function validation(Request $request)
    {
        $inputs = [
            'category_title' => $request->category_title,
            'slug' => Str::slug($request->category_title, '-'),
            'user_id' => auth()->user()->id
        ];
        return Validator::make($inputs, Category::$rules);
    }
}
