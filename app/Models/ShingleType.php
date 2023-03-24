<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laracasts\Presenter\PresentableTrait;

/**
 * Class ShingleType.
 *
 * @property int $id
 * @property string $name
 * @property int $is_deleted
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read mixed $hashed_id
 * @property-read ShingleType|null $shingle_type
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel company()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($columns)
 * @method static \Database\Factories\ShingleTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType filter(\App\Filters\QueryFilters $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel scope()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereAssignedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereBudgetedHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereCustomValue1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereCustomValue2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereCustomValue3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereCustomValue4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType wherePrivateNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType wherePublicNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereTaskRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleType withoutTrashed()
 * @mixin \Eloquent
 */
class ShingleType extends BaseModel
{
    use SoftDeletes;

    use PresentableTrait;
    use Filterable;

    protected $fillable = [
        'name',
    ];


    public function colors()
    {
        return $this->hasMany(ShingleTypeColor::class);
    }

    public function company()
    {
        return auth()->user()->company();
    }
}
