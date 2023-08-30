@php
    if (!isset($optionKey)) {
        $optionKey = '{new}';
    } // will be replaced by js
@endphp

<div class="row border border-secondary option rounded p-2 mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label>Donation amount</label><br>
            <input name="parameters[amount][{{ $optionKey }}][value]" type="number"
                @isset($donationValue) value={{ $donationValue }} @endisset placeholder="Enter amount"
                class="form-control" />
            <input name="parameters[amount][{{ $optionKey }}][type]" type="hidden" value="{{ $donationType }}"
                class="form-control" />
        </div>
    </div>

    @if ($donationType === 20)
        <div class="col-md-6">
            <div class="form-group">
                <label>Campaign goal</label><br>
                <input name="parameters[amount][{{ $optionKey }}][campaign_goal]" type="number"
                    @isset($campaignGoal) value="{{ $campaignGoal }}" @endisset
                    placeholder="Enter campaign goal..." class="form-control" />
            </div>
        </div>
    @endif

    <div class="@if ($donationType === 20) col-md-12 @else col-md-6 @endif">
        <div class="form-group">
            <label>Donation text</label><br>
            <input name="parameters[amount][{{ $optionKey }}][text]" type="text" placeholder="Enter text here..."
                value="@isset($donationText){{ $donationText }}@endisset" class="form-control" />
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Selected campaigns</label><br>
            <select name="parameters[amount][{{ $optionKey }}][campaigns][]" multiple class="form-control">
                @foreach (\App\Models\Campaign::Active()->get() as $campaign)
                    @php
                        if (isset($donationCampaigns) && in_array($campaign->id, $donationCampaigns)) {
                            $selected = true;
                        } else {
                            $selected = false;
                        }
                    @endphp

                    <option value="{{ $campaign->id }}" @if ($selected) selected @endif>
                        {{ $campaign->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <button type="button" option-delete class="btn btn-small btn-danger"><i class="far fa-trash-alt"></i></button>
    </div>
</div>
