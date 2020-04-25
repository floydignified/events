<?php

namespace App\Data\Models\Events;

use App\Data\Models\BaseModel;

class Event extends BaseModel
{
    /**
     * List of fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'event_name',
        'start_date',
        'end_date',
    ];

    /**
     * List of validation rules
     *
     * @var array
     */
    protected $rules = [
        "event_name" => "required|max:100",
        "start_date" => "required|date",
        "end_date" => "required|date",
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
     * Relation for Event -> Event Metas
     *
     * @return void
     */
    public function metas()
    {
        return $this->hasMany('App\Data\Models\Events\EventMeta');
    }
}
