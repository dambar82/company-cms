<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $title
 * @property string|null $caption
 * @property bool $is_visible
 * @property string|null $short_description
 * @property string|null $full_content
 * @property string $date
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string $url
 * @property bool $can_comment
 * @property bool $can_like
 * @property array|null $images
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Page active()
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page query()
 * @method static Builder|Page whereCanComment($value)
 * @method static Builder|Page whereCanLike($value)
 * @method static Builder|Page whereCaption($value)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereDate($value)
 * @method static Builder|Page whereFullContent($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereImages($value)
 * @method static Builder|Page whereIsVisible($value)
 * @method static Builder|Page whereMetaDescription($value)
 * @method static Builder|Page whereMetaTitle($value)
 * @method static Builder|Page whereShortDescription($value)
 * @method static Builder|Page whereTitle($value)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page whereUrl($value)
 * @mixin Eloquent
 */
class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'is_visible',
        'short_description',
        'full_content',
        'date',
        'meta_title',
        'meta_description',
        'url',
        'can_comment',
        'can_like',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
        'is_visible' => 'boolean',
        'can_comment' => 'boolean',
        'can_like' => 'boolean',
    ];
}
