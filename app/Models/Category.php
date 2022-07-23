<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     *
     * Adding and editing validation rules
     */
    public static $rules = [
        'category_title' => 'required',
        'slug' => 'unique:categories,slug',
        'user_id' => 'exists:users,id'
    ];
    /**
     * @var string[]
     *
     * Enabling Mass assignment for named fields
     */
    protected $fillable = ['category_title', 'slug', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Users table relation method
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
