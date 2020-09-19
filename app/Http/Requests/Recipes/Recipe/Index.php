<?php

namespace App\Http\Requests\Recipes\Recipe;

use App\Models\Recipes\Recipe;
use Illuminate\Validation\Rule;
use App\Http\Requests\FormRequestRules;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Recipes\TagController;
use App\Http\Controllers\Recipes\CookbookController;

class Index extends FormRequest
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
        $rules = [
            'filter' => ['array'],
            'filter.category_id'      => ['exists:categories,id'],
            'filter.name'             => ['string', 'min:5', 'max:100'],
            'filter.yield_amount'     => ['numeric', 'max:999'],
            'filter.complexity'       => ['string', Rule::in(Recipe::COMPLEXITY_TYPES)],
            'filter.instructions'     => ['string', 'max:16000000'],
            'filter.preparation_time' => ['string', 'date_format:H:i'],
            'limit' => $this->getLimitRule(),
            'page'  => $this->getPageRule(),
        ];

        if (CookbookController::isEnabled()) {
            $rules = array_merge($rules, ['cookbook_id' => ['nullable', 'exists:cookbooks,id']]);
        }

        if (TagController::isEnabled()) {
            $rules = array_merge(
                $rules,
                [
                    'filter.tags'   => ['array'],
                    'filter.tags.*' => ['exists:tags,id']
                ]
            );
        }

        return $rules;
    }
}
