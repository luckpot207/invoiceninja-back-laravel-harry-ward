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

namespace App\Transformers;

use App\Models\ShingleType;
use App\Utils\Traits\MakesHash;

/**
 * class ShingleTypeTransformer.
 */
class ShingleTypeTransformer extends EntityTransformer
{
    use MakesHash;

    protected $defaultIncludes = [
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
    ];

    public function transform(ShingleType $shingle_type)
    {
        return [
            'id' => (string) $this->encodePrimaryKey($shingle_type->id),
            'name' => $shingle_type->name ?: '',
        ];
    }
}
