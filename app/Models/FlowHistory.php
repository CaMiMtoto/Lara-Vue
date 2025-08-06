<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string $status
 * @property int|null $done_by
 * @property bool $is_comment
 * @property string $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereDoneBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereIsComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FlowHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FlowHistory extends Model
{
    //
}
