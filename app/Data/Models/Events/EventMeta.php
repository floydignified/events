<?php

namespace App\Data\Models\Events;

use App\Data\Models\BaseModel;

class EventMeta extends BaseModel
{
    /**
     * List of fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'repeat_start_date',
        'interval',
    ];

    /**
     * List of validation rules
     *
     * @var array
     */
    protected $rules = [
        "event_id" => "required|integer",
        "repeat_start_date" => "required|date",
        "interval" => "sometimes|required|in:daily,weekly,monthly,yearly'",
    ];

    /**
     * List of hidden fields
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Relation for Event Metas -> Event
     *
     * @return void
     */
    public function event()
    {
        return $this->belongsTo('App\Data\Models\Events\Event');
    }
}
