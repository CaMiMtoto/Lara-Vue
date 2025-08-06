<?php

namespace App\Traits;

trait HasStatusColor
{
    public function getStatusColorAttribute(): string
    {
        return match (strtolower($this->status)) {
            'draft' => 'bg-yellow-100 text-yellow-900',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'submitted' => 'bg-blue-100 text-blue-800',
            'pending' => 'bg-gray-100 text-gray-800',
            'completed' => 'bg-purple-100 text-purple-800',
            default => 'gray',
        };
    }
}
