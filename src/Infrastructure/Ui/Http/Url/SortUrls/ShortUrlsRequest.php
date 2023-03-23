<?php

namespace Kaira\Infrastructure\Ui\Http\Url\SortUrls;

use Illuminate\Foundation\Http\FormRequest;


class ShortUrlsRequest extends FormRequest
{
    const URL = 'url';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
             self::URL => 'required|string'

        ];
    }

    public function url(): string
    {
        return $this->url;
    }

}
