<?php

namespace App\Http\Requests\Recipes\Recipe;

use App\Models\Recipes\Recipe;
use Illuminate\Validation\Rule;
use App\Http\Requests\FormRequestRules;
use Illuminate\Foundation\Http\FormRequest;

class Search extends FormRequest
{
    use FormRequestRules;

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
     * @return array
     */
    public function rules()
    {
        return [
            'search'                => 'string',
            'filter'                => ['array'],
            'filter.category_id'    => ['exists:categories,id'],
            'limit'                 => $this->getLimitRule(),
            'page'                  => $this->getPageRule(),
        ];
    }
}
