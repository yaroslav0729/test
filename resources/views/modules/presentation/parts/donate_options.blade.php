@foreach ($amount as $amountKey => $item)
    @if(isset($item['type']) && ((int)$item['type'] === $donateOptionsType))
        
        @isset($campaignsCountries[$amountKey])

            @if(count($campaignsCountries[$amountKey])>0)

            <label class="item @isset($class) {{ $class }} @endisset" select-amount data-amount_id={{ $amountKey }}>
                <input type="radio" name="price" value="{{ $item['value'] }}">
                <span class="d-flex align-items-center">
                    <span>
                        <span>
                            <object class="currency_sign">£</object>
                            <b>@isset($item['value']) {{ $item['value'] }} @endisset</b>
                        </span>
                    @if($donateOptionsType === \App\Models\CampaignPrice::TYPE_SINGLE)
                        <span>JUST ONCE</span>
                    @elseif($donateOptionsType === \App\Models\CampaignPrice::TYPE_MONTHLY)
                        <span>MONTH</span>
                    @endif
                </span>
                    <span>@isset($item['text']) {{ $item['text'] }} @endisset</span>
                </span>
            </label>
            @endif

            <div class="form-group d-none" amount-countries data-amount_id={{ $amountKey }}>
                <select class="form-control" name="campaign">
                    @foreach ($campaignsCountries[$amountKey] as $campId => $campName)
                        <option value="{{ $campId }}">{{ $campName }}</option>   
                    @endforeach
                </select>
            </div>

        @endisset
    @endif 
@endforeach