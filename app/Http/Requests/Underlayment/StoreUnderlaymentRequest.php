<?php
/**
 * Invoice Ninja (https://invoiceninja.com).
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2023. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Http\Requests\Underlayment;

use App\Http\Requests\Request;
use App\Models\Client;
use App\Models\Underlayment;
use App\Utils\Traits\MakesHash;
use Illuminate\Validation\Rule;

class StoreUnderlaymentRequest extends Request
{
    use MakesHash;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return auth()->user()->can('create', Underlayment::class);
    }

    public function rules()
    {
        $rules = [];

        $rules['name'] = 'required';
 
        return $this->globalRules($rules);
    }

    public function prepareForValidation()
    {
        $input = $this->decodePrimaryKeys($this->all());

        $this->replace($input);
    }

    // public function getClient($client_id)
    // {
    //     return Client::withTrashed()->find($client_id);
    // }
}
