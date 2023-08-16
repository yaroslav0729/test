<select name="currency" class="form-control">
    {{-- @foreach (\App\Models\Currency::getAllCurrencies() as $key => $currency)
        <option value="{{ $key }}" data-sign="{{ $currency['sign'] }}">{{ $currency['code'] }}</option>   
    @endforeach --}}

    <option value="gbp" data-sign="£">GBP</option>
</select>