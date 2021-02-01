@php
    if ((isset($isColorInfo)) && ($isColorInfo == true))    {
        $class = 'active-color-info';
    }
@endphp

@foreach ($amount as $amountKey => $item)
    @if(isset($item['type']) && ((int)$item['type'] === $donateOptionsType))

        @isset($campaignsCountries[$amountKey])
            @if(count($campaignsCountries[$amountKey])>0)

            @if((isset($isEmergency)) && ($isEmergency === true))
                @php $class = 'active-color-red' @endphp
            @endif

            @php $smallSize = '' @endphp
            @if($item['value'] > 100)
                @php $smallSize = "font-size: 16px" @endphp
            @endif

            <label class="item @isset($class) {{ $class }} @endisset" select-amount data-amount_id={{ $amountKey }}>
                <input type="radio" name="price" value="{{ $item['value'] }}">
                <span class="d-flex align-items-center">
                    <span><span style="{{$smallSize}}">
                        <i  class="moon-icons-plus decor-plus"></i>

                        <object class="currency_sign">£</object>
                        <b>@isset($item['value']) {{ $item['value'] }} @endisset</b></span></span>
                    <span>@isset($item['text']) {{ $item['text'] }} @endisset</span>
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