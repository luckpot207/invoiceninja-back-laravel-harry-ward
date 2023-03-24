<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

/**
 * Class Project.
 *
 * @property int $id
 * @property string $name
 * @property int $is_deleted
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read mixed $hashed_id
 * @property-read Underlayment|null $underlayment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel company()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($columns)
 * @method static \Database\Factories\UnderlaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment filter(\App\Filters\QueryFilters $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel scope()
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereAssignedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereBudgetedHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereCustomValue1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereCustomValue2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereCustomValue3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereCustomValue4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment wherePrivateNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment wherePublicNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereTaskRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Underlayment withoutTrashed()
 * @mixin \Eloquent
 */
class Underlayment extends BaseModel
{
    use SoftDeletes;
    use PresentableTrait;
    use Filterable;


    protected $fillable = [
        'name',
    ];

    public function company()
    {
        return auth()->user()->company();
    }

}
