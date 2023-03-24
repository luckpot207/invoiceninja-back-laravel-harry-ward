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

namespace App\Factory;

use App\Models\ShingleType;

class ShingleTypeFactory
{
    public static function create(): ShingleType
    {
        $shingle_type = new ShingleType;
        $shingle_type->name = '';
        $shingle_type->is_deleted = 0;
        return $shingle_type;
    }
}