<?php

namespace App\Models;

use App\Traits\HasStatusColor;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $start_year
 * @property int $end_year
 * @property int $current_step
 * @property int $created_by
 * @property string $status
 * @property int|null $reviewer_id
 * @property string|null $reviewed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\User $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Initiative> $initiatives
 * @property-read int|null $initiatives_count
 * @method static \Database\Factories\PerformanceContractFactory factory($count = null, $state = [])
 * @method static Builder<static>|PerformanceContract newModelQuery()
 * @method static Builder<static>|PerformanceContract newQuery()
 * @method static Builder<static>|PerformanceContract query()
 * @method static Builder<static>|PerformanceContract whereCreatedAt($value)
 * @method static Builder<static>|PerformanceContract whereCreatedBy($value)
 * @method static Builder<static>|PerformanceContract whereCurrentStep($value)
 * @method static Builder<static>|PerformanceContract whereDescription($value)
 * @method static Builder<static>|PerformanceContract whereEndYear($value)
 * @method static Builder<static>|PerformanceContract whereId($value)
 * @method static Builder<static>|PerformanceContract whereReviewedAt($value)
 * @method static Builder<static>|PerformanceContract whereReviewerId($value)
 * @method static Builder<static>|PerformanceContract whereStartYear($value)
 * @method static Builder<static>|PerformanceContract whereStatus($value)
 * @method static Builder<static>|PerformanceContract whereTitle($value)
 * @method static Builder<static>|PerformanceContract whereUpdatedAt($value)
 * @mixin Eloquent
 */
class PerformanceContract extends Model
{
    use HasFactory,HasStatusColor;

    protected $appends = ['status_color'];
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function initiatives(): Builder|HasMany
    {
        return $this->hasMany(Initiative::class);
    }


}
