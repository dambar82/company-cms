<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsContent;
use Illuminate\Support\Facades\DB;
use MoonShine\Laravel\MoonShineRequest;

class ReorderController extends Controller
{
    public function newsContentReorder(MoonShineRequest $request, $itemId)
    {
        $news = News::find($itemId);

        $caseStatment = $request->str('data')
            ->explode(',')
            ->implode(fn($itemId, $position) => "WHEN $itemId THEN $position+1 ");

        $news->contents->each(fn (NewsContent $newsContent) => $newsContent->update([
            'position' => DB::raw("CASE id $caseStatment END")
        ]));
    }
}
