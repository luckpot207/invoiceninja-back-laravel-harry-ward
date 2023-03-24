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

use App\Models\Document;
use App\Models\Underlayment;
use App\Utils\Traits\MakesHash;

/**
 * class UnderlaymentTransformer.
 */
class UnderlaymentTransformer extends EntityTransformer
{
    use MakesHash;

    protected $defaultIncludes = [
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
    ];

    // public function includeDocuments(Underlayment $underlayment)
    // {
    //     $transformer = new DocumentTransformer($this->serializer);

    //     return $this->includeCollection($underlayment->documents, $transformer, Document::class);
    // }

    public function transform(Underlayment $underlayment)
    {
        return [
            'id' => (string) $this->encodePrimaryKey($underlayment->id),
            'shingle_type_id' => (string) $this->encodePrimaryKey($underlayment->shingle_type_id),
            'name' => $underlayment->name ?: '',
        ];
    }
}
