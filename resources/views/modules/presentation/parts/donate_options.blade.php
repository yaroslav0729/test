@foreach ($amount as $amountKey => $item)
    @if(isset($item['type']) && ((int)$item['type'] === $donateOptionsType))
        
        @isset($campaignsCountries[$amountKey])

            @if(count($campaignsCountries[$amountKey])>0)
            <label class="item" select-amount data-amount_id={{ $amountKey }}>
                <input type="radio" name="r1">
                <span class="d-flex align-items-center">
                    <span><span>£<b>@isset($item['value']) {{ $item['value'] }} @endisset</b></span><span>JUST ONCE</span></span>
                    <span>@isset($item['text']) {{ $item['text'] }} @endisset</span>
                </span>
            </label>
            @endif

            <div class="form-group d-none" amount-countries data-countries_amount_id={{ $amountKey }}>
                <select class="form-control">
                    <option>Country</option>
                    @foreach ($campaignsCountries[$amountKey] as $campId => $campName)
                        <option value="{{ $campId }}">{{ $campName }}</option>   
                    @endforeach
                </select>
            </div>
        @endisset
    @endif 
@endforeach