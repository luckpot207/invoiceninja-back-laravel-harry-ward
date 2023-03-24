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
use App\Models\ShingleTypeColor;
use App\Utils\Traits\MakesHash;

/**
 * class ShingleTypeColorTransformer.
 */
class ShingleTypeColorTransformer extends EntityTransformer
{
    use MakesHash;

    protected $defaultIncludes = [
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
    ];

    // public function includeDocuments(ShingleTypeColor $shingle_type_color)
    // {
    //     $transformer = new DocumentTransformer($this->serializer);

    //     return $this->includeCollection($shingle_type_color->documents, $transformer, Document::class);
    // }

    public function transform(ShingleTypeColor $shingle_type_color)
    {
        return [
            'id' => (string) $this->encodePrimaryKey($shingle_type_color->id),
            'shingle_type_id' => (string) $this->encodePrimaryKey($shingle_type_color->shingle_type_id),
            'name' => $shingle_type_color->name ?: '',
        ];
    }
}
