<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Document;

class StoreDocument extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Document::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payload' => 'nullable|json'
        ];
    }
}
