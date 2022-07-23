<?php

namespace App\Models;

use App\libs\MediaInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model implements MediaInterface
{
    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     *
     * Adding media validation rules
     */
    public static $rules = [
        'media_type' => 'required',
        'media_title' => 'required',
        'media_file' => 'required',
        'category_id' => 'required|exists:categories,id'
    ];

    /**
     * @var string[]
     *
     * Editing media validation rules
     */
    public static $editRules = [
        'media_type' => 'required',
        'media_title' => 'required',
        'category_id' => 'required|exists:categories,id'
    ];

    /**
     * @var array
     * Disabling Mass assignment on media
     */
    protected $guarded = [];

    /**
     * @var string[]
     * List of media type with equal name to classes to make proper objects out of these classes
     */
    public static $media_type = ['Music', 'Movies', 'Games'];

    /**
     * @param string $extension
     * @return bool
     *
     * Implemented form Interface
     */
    public function check_extension(string $extension) : bool
    {
        return true;
    }

    /**
     * @param $uploaded_file
     * @return array
     *
     * Used for type check and adding to DB
     */
    public function fileInfo($uploaded_file): array
    {
        $file_name = $uploaded_file->getClientOriginalName();
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_size = $uploaded_file->getSize();

        return ['file_name' => $file_name, 'extension' => $file_extension, 'size' => $file_size];
    }

    /**
     * @param string $address
     * @return string
     *
     * Implemented form Interface
     */
    public function getLink(string $address) : string
    {
        return '<a href="' . $address . '">' . __('download') . '</a>';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Categories table relation method
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * Users table relation method
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return int
     *
     * Returns new file order number
     */
    public static function last_order()
    {
        $media = self::orderBy('media_order')->get();
        return $media->count() > 0 ? ($media->count() + 1) : 1;
    }

    /**
     * @param $media_type
     * @param $media_order
     * @return string
     *
     * Returns physical address of file
     */
    public function file_address($media_type, $media_order)
    {
        return 'public/' . strtolower(Media::$media_type[array_search($media_type, Media::$media_type)]) . '/' . $media_order . '/';
    }
}
