<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property int $image_gallery_id
 * @property string $description
 * @property string|null $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Image newModelQuery()
 * @method static Builder|Image newQuery()
 * @method static Builder|Image query()
 * @method static Builder|Image whereCreatedAt($value)
 * @method static Builder|Image whereDescription($value)
 * @method static Builder|Image whereId($value)
 * @method static Builder|Image whereImage($value)
 * @method static Builder|Image whereImageGalleryId($value)
 * @method static Builder|Image whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Image extends Model
{
    protected $table = 'images';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'image',
        'image_galleries_id',
        'description'
    ];

    protected $guarded = array();
}
