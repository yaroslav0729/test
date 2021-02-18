<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    const ENTRY_FREE = 1;
    const ENTRY_PAID = 2;

    const EVENT_ONLINE = 10;
    const EVENT_LIVE = 11;
    const EVENT_FUNDRAISING = 12;

    const ALL_TYPES_ENTRY = [
        self::ENTRY_FREE => 'Free',
        self::ENTRY_PAID => 'Paid',
    ];

    const ALL_TYPE_EVENT = [
        self::EVENT_ONLINE => 'Webinars',
        self::EVENT_LIVE => 'Live events',
        self::EVENT_FUNDRAISING => 'Fundraising efforts',
    ];

    protected $fillable = [
        'page_id',
        'name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'entry_type',
        'event_type',
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the Page that owns the Event.
     */
    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    /**
     * @param array $data
     * @return array
     */
    public static function fillData(array $data): array
    {
        $dataEvent = [];

        $dataEvent['page_id'] = $data['page_id'];
        $dataEvent['name'] = $data['parameters']['event_title'];
        $dataEvent['start_date'] = $data['parameters']['event_start_date'];
        $dataEvent['start_time'] = $data['parameters']['event_start_time'];
        $dataEvent['location'] = $data['parameters']['preview_position'];
        $dataEvent['entry_type'] = $data['parameters']['event_details_entry'];
        $dataEvent['event_type'] = $data['parameters']['event_type_participate'];

        $dataEvent['end_date'] = $data['parameters']['event_end_date'];
        $dataEvent['end_time'] = $data['parameters']['event_end_time'];

        return $dataEvent;
    }

    public static function getActualEventsQuery()
    {

        $events = Event::with('Page')->whereDate('start_date', '>=', now())
            ->whereHas('Page', function ($query) {
                $query->published();
        });

        return $events;

    }

    /**
     * Create or update a record matching the attributes, and fill it with values.
     *
     * @param array $attributes
     * @param array $values
     * @return static
     */
    public static function updateOrCreate(array $attributes, array $values = [])
    {
        $event = static::firstOrNew($attributes);
        $event->fill(self::fillData($values))->save();

        return $event;
    }

    /**
     * Get the first record matching the attributes or instantiate it.
     *
     * @param array $attributes
     * @return static
     */
    public static function firstOrNew(array $attributes)
    {
        if (!is_null($instance = static::where($attributes)->first())) {
            return $instance;
        }

        return new static($attributes);
    }

    public static function searchByParam(array $params)
    {
        $query = \App\Models\Event::whereDate('start_date', '>=', now());

        $name = $params['name'] ?? '';
        $location = $params['location'] ?? '';
        $date = $params['date'] ?? '';

        if ($name) {
            $query->where('name', 'LIKE', "%$name%");
        }

        if ($location) {
            $query->where('location', 'LIKE', "%$location%");
        }

        $validatorDate = Validator::make(['date' => $date], [
            'date' => 'date',
        ]);

        if ($params['type']) {
            $query->where('entry_type', $params['type']);
        }

        if ($params['participate']) {
            $query->where('event_type', $params['participate']);
        }

        if ($date && !$validatorDate->fails()) {
            $query->whereDate('start_date', '=', $date)
                ->orWhereNotNull('end_date')
                ->where('name', 'LIKE', "%$name%")
                ->where('location', 'LIKE', "%$location%")
                ->where('entry_type', $params['type'])
                ->where('event_type', $params['participate'])
                ->whereDate('start_date', '<=', $date)
                ->whereDate('end_date', '>=', $date);
        }

        $events = $query->orderBy('start_date')->paginate($params['perPage']);

        return $events;
    }
}
