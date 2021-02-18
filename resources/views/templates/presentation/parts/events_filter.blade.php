<div class="list">
    <div class="row">
        @foreach($events as $event)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="item">
                    <a href="{{ url($event->page->getActualPageInstanceAttribute()->slug) }}"
                       class="img d-block"
                       style="background-image: url({{ $event->page->getActualPageInstanceAttribute()->preview_img }})">
                        <span class="price text-uppercase">
                            @if($event->entry_type === \App\Models\Event::ENTRY_PAID)
                                £{{ $event->page->getActualPageInstanceAttribute()->parameters['event_entry_price'] }}
                            @else
                                {{ \App\Models\Event::ALL_TYPES_ENTRY[$event->entry_type] }}
                            @endif
                        </span>
                    </a>
                    <a href="{{ url($event->page->getActualPageInstanceAttribute()->slug) }}"
                       class="tl d-block">{{ $event->name }}</a>
                    <span class="time d-block ml-4">{{ \Carbon\Carbon::parse($event->start_time)->format('h:ia') }}</span>
                    <span class="row">
                        <span class="col-7">
                            <span class="place"><i class="fal fa-map-marker-alt"></i>{{ $event->location }}</span>
                        </span>
                        <span class="col-5 text-right">
                            <span
                                class="date">{{ $event->start_date->format('M') }}<span>{{ $event->start_date->format('d') }}</span></span>
                        </span>
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>
<div class="pagination justify-content-center">
    {{ $events->appends(request()->except('page'))->links() }}
</div>
