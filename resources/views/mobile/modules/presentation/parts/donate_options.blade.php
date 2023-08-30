@php
    if (isset($isColorInfo) && $isColorInfo == true) {
        $class = 'active-color-info';
    }
    
    $collection = collect($amount)->transform(function ($item, $key) use ($campaignsCountries) {
        $item['id'] = $key;
        return $item;
    });
@endphp

@if ($collection->count() >= 15)
    @php
        $pricesGrouped = [
            [
                'min' => 25,
                'max' => 100,
            ],
            [
                'min' => 105,
                'max' => 150,
            ],
            [
                'min' => 200,
                'max' => 390,
            ],
        ];
        
        $maxGrouped = collect($pricesGrouped)->max('max');
        
        $min = $collection->min('value');
        $max = $collection->max('value');
    @endphp
    @foreach ($pricesGrouped as $group)
        @php
            $items = $collection->whereBetween('value', [$group['min'], $group['max']]);
        @endphp

        <div class="accordion">
            <label class="item accordion-header collapsed active-color-info text-center" select-amount=""
                data-amount_id="0" style="background: aliceblue;padding: 31px;" data-toggle="collapse"
                href="#collapse{{ $loop->iteration }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                <span>
                    <h5><b>Give from £{{ $group['min'] }} to £{{ $group['max'] }}</b></h5>
                </span>
            </label>

            <div class="collapse" id="collapse{{ $loop->iteration }}">
                @foreach ($items->sortBy('value') as $item)
                    @if (isset($item['type']) && (int) $item['type'] === $donateOptionsType)
                        @isset($campaignsCountries[$item['id']])
                            @if (count($campaignsCountries[$item['id']]) > 0)
                                @if (isset($isEmergency) && $isEmergency === true)
                                    @php $class = 'active-color-red' @endphp
                                @endif

                                <label class="item @isset($class) {{ $class }} @endisset"
                                    select-amount data-amount_id={{ $item['id'] }}>
                                    <input type="{{ isset($useCheckbox) && $useCheckbox === true ? 'checkbox' : 'radio' }}"
                                        name="price" value="{{ $item['value'] }}">
                                    <span class="d-flex align-items-center">
                                        <span><span>
                                                <i class="moon-icons-plus decor-plus"></i>
                                                <i class="moon-icons-check"></i>

                                                <object class="currency_sign">£</object>
                                                <b>
                                                    @isset($item['value'])
                                                        {{ $item['value'] }}
                                                    @endisset
                                                </b></span></span>
                                        <span>
                                            @isset($item['text'])
                                                {{ $item['text'] }}
                                            @endisset
                                        </span>
                                    </span>
                                </label>
                            @endif

                            <div class="form-group d-none" amount-countries data-amount_id={{ $item['id'] }}>
                                <select class="form-control"
                                    name="{{ isset($useCheckbox) && $useCheckbox === true ? 'campaigns_' . $item['id'] : 'campaigns' }}">
                                    @foreach ($campaignsCountries[$item['id']] as $campId => $campName)
                                        <option value="{{ $campId }}">{{ $campName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
@else
    @foreach ($amount as $amountKey => $item)
        @if (isset($item['type']) && (int) $item['type'] === $donateOptionsType)
            @isset($campaignsCountries[$amountKey])
                @php
                    switch (mb_strlen($item['value'])) {
                        case 0:
                        case 1:
                        case 2:
                        case 3:
                        case 4:
                        case 5:
                        case 6:
                        default:
                            $smallSize = '';
                    }
                @endphp

                @if (count($campaignsCountries[$amountKey]) > 0)
                    @if (isset($isEmergency) && $isEmergency === true)
                        @php $class = 'active-color-red' @endphp
                    @endif

                    <label class="item @isset($class) {{ $class }} @endisset" select-amount
                        data-amount_id={{ $amountKey }}
                        data-campaign_goal="@isset($item['campaign_goal']){{ $item['campaign_goal'] }}@endisset">
                        <input type="radio" name="price" value="{{ $item['value'] }}">
                        <span class="d-flex align-items-center">
                            <span>
                                <span>
                                    <object class="currency_sign" style="{{ $smallSize }}">£</object>
                                    <b style="{{ $smallSize }}">
                                        @isset($item['value'])
                                            {{ $item['value'] }}
                                        @endisset
                                    </b>
                                </span>
                                @if ($donateOptionsType === \App\Models\CampaignPrice::TYPE_SINGLE)
                                    <span>JUST ONCE</span>
                                @elseif($donateOptionsType === \App\Models\CampaignPrice::TYPE_MONTHLY)
                                    <span>MONTH</span>
                                @endif
                            </span>
                            <span>
                                @isset($item['text'])
                                    {{ $item['text'] }}
                                @endisset
                            </span>
                        </span>
                    </label>
                @endif

                <div class="form-group d-none" amount-countries data-amount_id={{ $amountKey }}>
                    <select class="form-control" name="campaigns">
                        @foreach ($campaignsCountries[$amountKey] as $campId => $campName)
                            <option value="{{ $campId }}">{{ $campName }}</option>
                        @endforeach
                    </select>
                </div>
            @endisset
        @endif
    @endforeach
@endif
