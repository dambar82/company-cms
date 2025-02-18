<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Lead;

use App\Models\LeadContent;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Decorations\Block;
use MoonShine\Fields\Field;
use MoonShine\Fields\ID;
use MoonShine\Resources\ModelResource;

/**
 * @extends ModelResource<LeadContent>
 */
class LeadContentResource extends ModelResource
{
    protected string $model = LeadContent::class;

    protected string $title = 'LeadContents';

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
     * @param LeadContent $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [];
    }
}
