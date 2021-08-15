<?php

namespace App\Http\Requests\Users\User;

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
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'limit' => $this->getLimitRule(),
            'page'  => $this->getPageRule(),
            'trashed' => $this->getTrashedRule(),
        ];
    }
}
