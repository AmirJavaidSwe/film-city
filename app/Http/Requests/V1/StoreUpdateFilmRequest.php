<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateFilmRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'release_date' => 'required|date|date_format:Y-m-d',
            'rating' => 'required|numeric',
            'ticket_price' => 'required|numeric',
            'country' => 'required|string|max:255',
            'photo' => 'required_if:photoSrc,null|image',
            'genre' => 'required',
        ];
    }
}
