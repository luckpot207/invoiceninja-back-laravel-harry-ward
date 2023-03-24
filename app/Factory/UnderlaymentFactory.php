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

use App\Models\Underlayment;

class UnderlaymentFactory
{
    public static function create(): Underlayment
    {
        $underlayment = new Underlayment;
        $underlayment->name = '';
        $underlayment->is_deleted = 0;
        return $underlayment;
    }
}