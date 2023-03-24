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

use App\Models\ShingleTypeColor;

class ShingleTypeColorFactory
{
    public static function create(): ShingleTypeColor
    {
        $shingle_type_color = new ShingleTypeColor;
        $shingle_type_color->name = '';
        $shingle_type_color->is_deleted = 0;
        return $shingle_type_color;
    }
}