<?php

namespace App\Http\Traits;

use App\Models\ForbiddenWord;

trait CheckForbiddenWordTrait
{
    /**
     * @param string $data
     *
     * @return bool
     */
    public function checkForbiddenWord(string $data): bool
    {
        $forbiddenWords = ForbiddenWord::get()->pluck('word')->toArray();

        $escapedForbiddenWords = array_map('preg_quote', $forbiddenWords);

        $pattern = '/\b(' . implode('|', $escapedForbiddenWords) . ')\b/iu';

        if (preg_match($pattern, $data)) {
            return false;
        }

        return true;
    }
}
