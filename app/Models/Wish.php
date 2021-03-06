<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Wish extends Model
{
    use BelongsToUser;

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['wishable_id', 'wishable_type', 'user_id'];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'wishable_id' => 'integer',
        'wishable_type' => 'string',
    ];

    /**
     * Get the owner model of the wish.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function wishable(): MorphTo
    {
        return $this->morphTo('wishable', 'wishable_type', 'wishable_id', 'id');
    }
}
