<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Document;

class UpdateDocument extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $document = Document::find($this->route('id'));

        return $document && $this->user()->can('update', $document);
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
