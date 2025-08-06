<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $total_annual_leave_days
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LeaveRequest> $leaveRequests
 * @property-read int|null $leave_requests_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Employee query()
 * @mixin \Eloquent
 */
class Employee extends Model
{
    protected $fillable = ['name', 'hire_date'];

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function getTotalAnnualLeaveDaysAttribute(): int
    {
        $years = now()->diffInYears($this->hire_date);
        return 22 + intdiv($years, 3);
    }
}
