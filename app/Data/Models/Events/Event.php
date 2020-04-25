<?php

namespace App\Data\Models\Events;

use App\Data\Models\BaseModel;
use Carbon\Carbon;

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
     * List of appended fields
     *
     * @var array
     */
    protected $appends = [
        'event_dates',
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

    /**
     * Event dates accessor
     *
     * List of all dates with event
     * To remove computation/overhead from frontend
     */
    protected function getEventDatesAttribute()
    {
        //initialize event dates array
        $event_dates = [];

        //loop through all metas
        foreach ($this->metas as $meta) {
            $event_dates = array_merge(
                $event_dates,
                Carbon::parse($meta->repeat_start_date)
                    ->toPeriod($this->end_date, '1 week')
                    ->toArray()
            );
        }

        return $event_dates;
    }
}
