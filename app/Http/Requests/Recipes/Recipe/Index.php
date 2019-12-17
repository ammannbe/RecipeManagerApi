<?php

namespace App\Http\Requests\Recipes\Recipe;

use App\Models\Recipes\Recipe;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class Index extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'filter' => ['array'],
            'filter.cookbook_id'      => ['exists:cookbooks,id'],
            'filter.category_id'      => ['exists:categories,id'],
            'filter.name'             => ['string', 'min:5', 'max:255', ],
            'filter.yield_amount'     => ['numeric', 'max:999'],
            'filter.complexity'       => ['string', Rule::in(Recipe::COMPLEXITY_TYPES)],
            'filter.instructions'     => ['string', 'max:16000000'],
            'filter.preparation_time' => ['string', 'date_format:H:i'],
            'filter.tags'             => ['array'],
            'filter.tags.*'           => ['exists:tags,id'],
            'limit'  => ['integer', 'max:1000'],
            'page'   => ['integer'],
        ];
    }
}
