@php
$pageInstance = \App\Models\PageInstance::where('slug', 'qurbani-2024')->where('actual', true)->firstOrFail();
$amount = $pageInstance->parameters['amount'];
$campaignIds = [];
foreach ($amount as $item) {
    $campaignIds = array_merge($campaignIds, $item['campaigns']);
}
$campaigns = \App\Models\Campaign::whereIn('id', $campaignIds)->get();
$campaignsCategories = \App\Models\Project::getProjectCampaignsCateg($pageInstance);
$campaignsCountries = \App\Models\Project::getProjectCampaignsCountries($pageInstance);

$startDate = \Carbon\Carbon::today();
$endDate = \Carbon\Carbon::createFromDate(null, 6, 9)->endOfDay();
$availableDates = [];

for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
    $availableDates[$date->format('jS \\of F')] = $date->hour(10)->timestamp;
}

$pricesList = \App\Models\FoodPacksQurbaniesPrice::with('country', 'types')->get();
$amount = collect($amount);

$cart = \App\Models\CartItem::getCart();
$cartSum = \App\Models\CartItem::getCartSum();
$hasSingleDonations = \App\Models\CartItem::hasSingleDonations();
$hasMonthlyDonations = \App\Models\CartItem::hasMonthlyDonations();
@endphp

@section('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemap.map_key') }}&libraries=places&language=EN"
        defer>
    </script>
    {!! NoCaptcha::renderJs() !!}
@endsection

<div >
    <div id="donate_module_options" class="alert alert-warning d-none">
        {{ json_encode($campaignsCategories) }}
    </div>
    <section class="box scheduled-qurbani-box" style="padding-bottom: 0;">
        <div class="wrap">
            <form id="qurbani-form" action="{{ route('schedule-qurbani.schedule') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="qurbani-options qurbani-options">
                            <div class="col-12 row mb-2 qurbani-options__types">
                                <div class="col-md-4">
                                </div>
                                <div class="qurbani-row col-md-8 col-12">
                                    <div class="col-md-6 col-6 text-center">
                                        <img class="qurbani-options__image mx-auto d-block"
                                            src="https://islamichelp.org.uk/storage/cow.png">
                                        <p class="mt-2">1/7 cow share</p>
                                    </div>
                                    <div class="col-md-6 col-6 text-center">
                                        <img class="qurbani-options__image mx-auto d-block"
                                            src="https://islamichelp.org.uk/storage/goat.png">
                                        <p class="mt-2">goat/sheep</p>
                                    </div>
                                </div>
                            </div>
                            @foreach($pricesList as $price)
                            <div class="mt-4 qurbani-options__item align-middle">
                                <div class="text-xs-center xs-align-center qurbani-options__item-country">
                                    <label class="align-middle" style="display: table-cell;">
                                        <input type="checkbox" name="countries[]" value="{{ $price->id }}">
                                        <i class="fas fa-check-circle"></i>
                                        <span class="qurbani-options__name">{{ $price->country->name }}</span>
                                    </label>
                                </div>
                                @foreach($price->types as $type)
                                    @if($type->pivot->price > 0)
                                        <div class="text-center">
                                            <div class="qurbani-options__quantity-selector">
                                                <div class="qurbani-options__price">£{{ $type->pivot->price }}</div>
                                                @php
                                                    $priceFromAmount = $amount->firstWhere('value', $type->pivot->price);
                                                    $campaignsIds = $priceFromAmount ? $priceFromAmount['campaigns'] : [];
                                                    $filteredCampaigns = $campaigns->whereIn('id', $campaignsIds);
                                                    $campaign = $price->campaigns[0];
                                                    $campaignName = $campaign ? $campaign->name : '';
                                                    $mainCampaignName = $campaignName; // Default to full name
                                                    $parenthesisPosition = strpos($campaignName, ' (');
                                                    if ($parenthesisPosition !== false) {
                                                        $mainCampaignName = substr($campaignName, 0, $parenthesisPosition);
                                                    }
                                                    $mainCampaignName = $mainCampaignName . ' | ' . $price->country->name. ' | ' . $type->name. ' | £' . $type->pivot->price  ;
                                                @endphp
                                                <div class="qurbani-options__number">
                                                    @if($type->name === 'Cow')
                                                        <div class="qurbani-options__number-image-container">
                                                            <img class="qurbani-options__number-image"
                                                            src="https://islamichelp.org.uk/storage/cow.png">
                                                        </div>
                                                    @else
                                                        <div class="qurbani-options__number-image-container">
                                                            <img class="qurbani-options__number-image"
                                                            src="https://islamichelp.org.uk/storage/goat.png">
                                                        </div>
                                                    @endif
                                                    <input type="number"
                                                        input_number_spinner_food
                                                        data-id="{{ $type->id }}"
                                                        data-campaign="{{ $campaign ? $campaign->id : '' }}"
                                                        data-campaign-name="{{ $mainCampaignName }}"
                                                        value="0"
                                                        data-type="{{ $type->id }}"
                                                        data-type-name="{{ $type->name }}"
                                                        data-price="{{ $type->pivot->price }}"
                                                        data-country="{{ $price->country ? $price->country->id : '' }}"
                                                        min="0" max="1000"
                                                        step="1"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center"></div>
                                    @endif
                                @endforeach
                            </div>
                            @endforeach
                            @foreach($pricesList as $price)
                                <div class="mt-4 qurbani-options__item qurbani-options__item-mobile">
                                    <div class="qurbani-options__item-header">
                                        <div class="qurbani-country" style="display: flex; align-items: center; justify-content: space-between;">
                                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                <div class="">
                                                    <img class="qurbani-options__image mx-auto d-block" width="50px" src="https://islamichelp.org.uk/storage/cow.png" style="filter: brightness(0) invert(1);">
                                                </div>
                                                <div style="font-size: 0.5rem; font-weight: bold;">1/7 cow share</div>
                                            </div>
                                            <div class="qurbani-options__name">
                                                {{ $price->country ? $price->country->name : 'Unknown Country' }}
                                            </div>
                                            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                <div class="">
                                                    <img class="qurbani-options__image mx-auto d-block" width="50px" src="https://islamichelp.org.uk/storage/goat.png" style="filter: brightness(0) invert(1);">
                                                </div>
                                                <div style="font-size: 0.5rem; font-weight: bold;">goat</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="qurbani-selectors" id="{{ $price->id }}">
                                        @foreach($price->types as $key => $type)
                                            @if($type->pivot->price > 0)
                                                <div class="text-center qurbani-options__quantity-selector-container {{$key}}">
                                                    <div class="qurbani-options__quantity-selector">
                                                        <span class="qurbani-options__price">£{{ $type->pivot->price }}</span>
                                                        @php
                                                            $priceFromAmount = $amount->firstWhere('value', $type->pivot->price);
                                                            $campaignsIds = $priceFromAmount ? $priceFromAmount['campaigns'] : [];
                                                            $filteredCampaigns = $campaigns->whereIn('id', $campaignsIds);
                                                            $campaign = $price->campaigns[0];
                                                            $campaignName = $campaign ? $campaign->name : '';
                                                            $mainCampaignName = $campaignName; // Default to full name
                                                            $parenthesisPosition = strpos($campaignName, ' (');
                                                            if ($parenthesisPosition !== false) {
                                                                $mainCampaignName = substr($campaignName, 0, $parenthesisPosition);
                                                            }
                                                            $mainCampaignName = $mainCampaignName . ' | ' . $price->country->name. ' | ' . $type->name. ' | £' . $type->pivot->price  ;
                                                        @endphp
                                                        <div class="qurbani-options__number">
                                                            <input type="number"
                                                                input_number_spinner_food
                                                                data-id="{{ $type->id }}"
                                                                data-campaign="{{ $campaign ? $campaign->id : '' }}"
                                                                data-campaign-name="{{ $mainCampaignName }}"
                                                                value="0"
                                                                data-type="{{ $type->id }}"
                                                                data-type-name="{{ $type->name }}"
                                                                data-price="{{ $type->pivot->price }}"
                                                                data-country="{{ $price->country ? $price->country->id : '' }}"
                                                                min="0" max="1000"
                                                                step="1"
                                                                class="color-danger"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-center qurbani-options__quantity-selector-container"></div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label id="total-amount" style="font-size: 1.2em;"></label>
                        </div>
                    </div>
                </div>
                <div id="qurbani-names" class="d-none">
                    <div class="text-right pb-3"><b>PLEASE GIVE US THE NAMES FOR YOUR QURBANI(S)</b></div>
                    <div class="black-line"></div>
                    <div class="pt-5"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div id="donation-notes"></div>
                        </div>
                    </div>
                </div>
                <div class="text-right pb-5 mt-3"><b>Total Amount: £<span id="total-amount-value">0</span></b></div>
                <div class="text-right pb-3"><b>YOUR DETAILS</b></div>
                <div class="black-line"></div>
                <div class="pt-5"></div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <p>
                            And now for some quick details...
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b>TITLE</b> (OPTIONAL)</label>
                            <select class="form-control" required name="title">
                                <option value="mr">Mr</option>
                                <option value="mrs">Mrs</option>
                                <option value="miss">Miss</option>
                                <option value="ms">Ms</option>
                                <option value="dr">Dr</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="@error('first_name') text-danger @enderror"><b>FIRST NAME</b></label>
                            <input type="text" name="first_name" required placeholder="Enter first name..."
                                class="form-control @error('first_name') border-danger @enderror"
                                value="{{ old('first_name') }}">
                        </div>
                        @error('first_name')
                        <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="pt-3"></div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="@error('last_name') text-danger @enderror"><b>LAST NAME</b></label>
                            <input type="text" name="last_name" required placeholder="Enter last name..."
                                class="form-control @error('last_name') border-danger @enderror"
                                value="{{ old('last_name') }}">
                        </div>
                        @error('last_name')
                        <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="@error('email') text-danger @enderror"><b>EMAIL</b></label>
                            <input type="text" name="email" required placeholder="enter email"
                                class="form-control @error('email') border-danger @enderror"
                                value="{{ old('email') }}">
                        </div>
                        @error('email')
                        <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="pt-5"></div>

                <div class="text-right pb-3"><b>ADDRESS & CONTACT</b></div>
                <div class="black-line height-1"></div>
                <div class="pt-5"></div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group postcode-finder-container">
                            <label><b>ENTER YOUR POSTCODE</b></label>
                            <input type="text" id="postcode-finder" required class="form-control" name="some_adr"
                                autocomplete="off" placeholder="Type postcode...">

                            <div id="postcode-results" class="postcode-results d-none">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label><b>CONTACT NUMBER</b> (OPTIONAL)</label>
                            <input type="text" placeholder="Enter the phone number..." name="phone"
                                class="form-control">
                        </div>
                    </div>
                </div>

                <div class="manual-address" style="display: block">
                    <div class="pt-3"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('address_1') text-danger @enderror"><b>ADDRESS</b> (LINE 1)</label>
                                <input 
                                    id="route" 
                                    type="text" 
                                    required 
                                    name="address_1"
                                    class="form-control auto-address @error('address_1') border-danger @enderror"
                                    value="{{ old('address_1') }}"
                                    placeholder="Enter the address..."
                                />
                            </div>
                            @error('address_1')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label><b>ADDRESS</b> (LINE 2)</label>
                                <input 
                                    type="text" 
                                    name="address_2" 
                                    placeholder="Enter the address..."
                                    class="form-control auto-address"
                                    value="{{ old('address_2') }}"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('city') text-danger @enderror"><b>CITY</b></label>
                                <input type="text" id="postal_town" required name="city"
                                    placeholder="Enter the city..."
                                    class="form-control auto-address @error('city') border-danger @enderror"
                                    value="{{ old('city') }}"
                                >
                            </div>
                            @error('city')
                                <p class="text-danger ml-3 font-size-14">*{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label><b>COUNTY</b></label>
                                <input type="text" id="administrative_area_level_2"
                                    class="form-control auto-address"
                                    name="county" value="{{ old('county') }}"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="pt-3"></div>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="@error('post_code') text-danger @enderror"><b>POST CODE</b></label>
                                <input type="text" required id="postal_code"
                                    class="form-control auto-address @error('post_code') border-danger @enderror"
                                    name="post_code" placeholder="Enter postcode..."
                                    value="{{ old('post_code') }}">
                            </div>
                            @error('post_code')
                                <p class="text-danger ml-3">*{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label><b>COUNTRY</b></label>
                                <select class="form-control" id="country" required name="country">
                                    @foreach (\App\Models\Country::getAllEnabled() as $country)
                                        <option value="{{ $country->id }}"
                                            @if (old('country'))
                                                @if ($country->id==old('country'))selected="selected" @endif
                                            @else
                                                @if ($country->id == 187)selected="selected" @endif
                                            @endif
                                        >
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3"></div>

                </div>
                <div class="pt-2"></div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-12 d-flex justify-content-center mt-3">
                        <button style="transform: translateY(50%);" type="submit" id="qurbani-pay" class="btn btn-danger">PAY NOW</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>


<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        crossorigin="anonymous"></script>
<script>
    const amount = {!! json_encode($amount) !!};
</script>