<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $performance_contract_id
 * @property string $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Kpi> $kpis
 * @property-read int|null $kpis_count
 * @property-read \App\Models\PerformanceContract $performanceContract
 * @method static Builder<static>|Initiative newModelQuery()
 * @method static Builder<static>|Initiative newQuery()
 * @method static Builder<static>|Initiative query()
 * @method static Builder<static>|Initiative whereCreatedAt($value)
 * @method static Builder<static>|Initiative whereId($value)
 * @method static Builder<static>|Initiative wherePerformanceContractId($value)
 * @method static Builder<static>|Initiative whereTitle($value)
 * @method static Builder<static>|Initiative whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Initiative extends Model
{
    public function kpis(): Builder|HasMany
    {
        return $this->hasMany(Kpi::class);
    }

    public function performanceContract(): BelongsTo
    {
        return $this->belongsTo(PerformanceContract::class);
    }
}
