<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Amina;

use App\MoonShine\Pages\AminaNews\AminaNewsDetailPage;
use App\Models\News;
use App\Models\NewsContent;
use App\MoonShine\Pages\AminaNews\AminaNewsFormPage;
use App\MoonShine\Pages\AminaNews\AminaNewsIndexPage;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\File as Load;
use Illuminate\Support\Facades\Storage;
use MoonShine\Laravel\Http\Responses\MoonShineJsonResponse;
use MoonShine\Laravel\MoonShineRequest;
use MoonShine\Laravel\Pages\Page;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\Support\Enums\PageType;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Div;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Layout\LineBreak;
use MoonShine\UI\Fields\File;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Url;

/**
 * @extends ModelResource<AminaNewsResource, AminaNewsIndexPage, AminaNewsFormPage, AminaNewsDetailPage>
 */
class AminaNewsResource extends ModelResource
{
    protected bool $stickyTable = true;

    protected string $model = News::class;

    protected string $title = 'Новости Амина';

    protected SortDirection $sortDirection = SortDirection::ASC;

    protected ?ClickAction $clickAction = ClickAction::EDIT;

    protected ?PageType $redirectAfterSave = PageType::FORM;

    /**
     * @return Page
     */
    protected function pages(): array
    {
        return [
            AminaNewsIndexPage::class,
            AminaNewsFormPage::class,
            AminaNewsDetailPage::class,
        ];
    }

    public function addText(MoonShineRequest $request): MoonShineJsonResponse
    {
        $data = $request->validate([
            'key' => ['string', 'required']
        ]);
        return MoonShineJsonResponse::make()->html((string)
        Div::make([
            Box::make([
                Flex::make([
                    TinyMce::make('Текст', $data['key']),
                    ActionButton::make('')->icon('trash')
                        ->error()
                        ->onClick(fn() => 'deleteElement()')
                    //   ->onClick(fn() => "alert('Пример')", 'prevent')
                ])->itemsAlign('end')
            ]),
            LineBreak::make()
        ])
        );
    }
    public function addImage(MoonShineRequest $request): MoonShineJsonResponse
    {
        $data = $request->validate([
            'key' => ['string', 'required']
        ]);
        return MoonShineJsonResponse::make()->html((string)
        Div::make([
            Box::make([
                Flex::make([
                    Image::make('Фото', $data['key'])
                        ->allowedExtensions(['png', 'jpg', 'jpeg']),
                    ActionButton::make('')
                        ->icon('trash')
                        ->error()
                        ->onClick(fn() => 'deleteElement()')
                ])->itemsAlign('end'),
            ]),
            LineBreak::make()
        ])
        );
    }

    public function addVideo(MoonShineRequest $request): MoonShineJsonResponse
    {
        $data = $request->validate([
            'key' => ['string', 'required']
        ]);
        return MoonShineJsonResponse::make()->html((string)
        Div::make([
            Box::make([
                Flex::make([
                    File::make('Видео', 'video[]')
                        ->allowedExtensions(['mp4']),
                    Url::make('Ссылка на видео','link[]')->blank(),
                    ActionButton::make('')
                        ->icon('trash')
                        ->error()
                        ->onClick(fn() => 'deleteElement()')
                ])
                    ->justifyAlign('between')
                    ->itemsAlign('end')
            ]),
            LineBreak::make()
        ])
        );
    }

    protected function afterUpdated(mixed $item): mixed
    {
        $this->createTextContent();
        $this->createImageContent();
        $this->createVideoContent();
        $this->createLinkContent();

        return $item;
    }

    public function createContent(string $itemId, string $field, string $value): void
    {
        $position = NewsContent::where('news_id', $itemId)->max('position');

        NewsContent::create([
            'news_id' => $this->getItemID(),
            'position' => $position ? $position + 1 : 1,
            $field => $value
        ]);
    }

    public function createTextContent(): void
    {
        if (!empty(request()->input('text'))) {
            $texts = request()->input('text');

            foreach ($texts as $text) {
                $this->createContent($this->getItemID(), 'text', $text);
            }
        }
    }

    public function createImageContent(): void
    {
        if (!empty($_FILES['name']['tmp_name'])) {
            foreach ($_FILES['name']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['name']['error'][$key] === UPLOAD_ERR_OK) {
                    $originalName = $_FILES['name']['name'][$key];

                    // Создаем новое имя для сохранения
                    $filename = time() . '_' . $originalName;

                    Storage::putFileAs('public/news/images', new Load($tmp_name), $filename);

                    $this->createContent($this->getItemID(), 'image', 'news/images/' . $filename);
                }
            }
        }
    }

    public function createVideoContent(): void
    {
        if (!empty($_FILES['video']['tmp_name'])) {
            foreach ($_FILES['video']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['video']['error'][$key] === UPLOAD_ERR_OK) {
                    $originalName = $_FILES['video']['name'][$key];

                    // Создаем новое имя для сохранения
                    $filename = time() . '_' . $originalName;

                    Storage::putFileAs('public/news/videos', new Load($tmp_name), $filename);

                    $this->createContent($this->getItemID(), 'video', 'news/videos/' . $filename);
                }
            }
        }
    }

    public function createLinkContent(): void
    {
        if (!empty(request()->input('link'))) {
            $links = request()->input('link');

            foreach ($links as $link) {
                if ($link != null) {
                    $this->createContent($this->getItemID(), 'link', $link);
                }
            }
        }
    }

    public function modifyQueryBuilder(Builder $builder): Builder
    {
        return $builder
            ->join('news_project as np', 'news.id', '=', 'np.news_id')
            ->join('projects as p', 'p.id', '=', 'np.project_id')
            ->where('p.id', 1)
            ->select('news.*');
    }
}
