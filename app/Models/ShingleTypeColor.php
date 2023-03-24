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
 * @property int|null $shingle_type_id
 * @property int $is_deleted
 * @property-read \App\Models\Client|null $client
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read mixed $hashed_id
 * @property-read ShingleTypeColor|null $shingle_type_color
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel company()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel exclude($columns)
 * @method static \Database\Factories\ShingleTypeColorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor filter(\App\Filters\QueryFilters $filters)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel scope()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereAssignedUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereBudgetedHours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereCustomValue1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereCustomValue2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereCustomValue3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereCustomValue4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor wherePrivateNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor wherePublicNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereTaskRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ShingleTypeColor withoutTrashed()
 * @mixin \Eloquent
 */
class ShingleTypeColor extends BaseModel
{
    use SoftDeletes;
    use PresentableTrait;
    use Filterable;


    protected $fillable = [
        'name',
        'shingle_type_id'
    ];


    public function shingle_type()
    {
        return $this->belongsTo(ShingleTypeColor::class);
    }

    public function company()
    {
        return auth()->user()->company();
    }

}
