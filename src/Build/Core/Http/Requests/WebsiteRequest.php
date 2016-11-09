<?php

namespace Build\Core\Http\Requests;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class WebsiteRequest extends \Illuminate\Foundation\Http\FormRequest
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
        return [
            'name' => 'required',
            'domain' => 'required',
            'language_id' => 'required'
        ];
    }
}
