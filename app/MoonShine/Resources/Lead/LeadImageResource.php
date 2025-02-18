<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Lead;

use App\Models\LeadImage;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<LeadImage>
 */
class LeadImageResource extends ModelResource
{
    protected string $model = LeadImage::class;

    protected string $title = 'LeadImages';

    /**
     * @return Field
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
            ]),
        ];
    }

    /**
     * @param LeadImage $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
