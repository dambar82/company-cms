<?php

namespace App\Models;

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
 * @method static Builder|Pages active()
 * @method static Builder|Pages newModelQuery()
 * @method static Builder|Pages newQuery()
 * @method static Builder|Pages query()
 * @method static Builder|Pages whereCanComment($value)
 * @method static Builder|Pages whereCanLike($value)
 * @method static Builder|Pages whereCaption($value)
 * @method static Builder|Pages whereCreatedAt($value)
 * @method static Builder|Pages whereDate($value)
 * @method static Builder|Pages whereFullContent($value)
 * @method static Builder|Pages whereId($value)
 * @method static Builder|Pages whereImages($value)
 * @method static Builder|Pages whereIsVisible($value)
 * @method static Builder|Pages whereMetaDescription($value)
 * @method static Builder|Pages whereMetaTitle($value)
 * @method static Builder|Pages whereShortDescription($value)
 * @method static Builder|Pages whereTitle($value)
 * @method static Builder|Pages whereUpdatedAt($value)
 * @method static Builder|Pages whereUrl($value)
 * @mixin \Eloquent
 */
class Pages extends Model
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
