<?php

namespace App\Http\Requests\Ratings\Rating;

use App\Http\Requests\FormRequestRules;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'filter' => ['array'],
            'filter.recipe_id'  => ['exists:recipes,id'],
            'filter.user_id'    => ['exists:users,id'],
            'limit' => $this->getLimitRule(),
            'page'  => $this->getPageRule(),
        ];
    }
}
