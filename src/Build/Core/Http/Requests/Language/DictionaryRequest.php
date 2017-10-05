<?php

namespace Build\Core\Http\Requests\Language;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class DictionaryRequest extends \Illuminate\Foundation\Http\FormRequest
{

    /**
     * Pre-authorize the user.
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
        switch ($this->getMethod()) {
            case 'PUT':
            case 'PATCH':
                $dictionary = $this->route('dictionary');
                 return [
                    'label' => 'required|unique:language_dictionaries,label,'.$dictionary->id
                ];
            default:
                return [
                    'label' => 'required|unique:language_dictionaries,label'
                ];
        }
        
    }
}
