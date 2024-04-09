@extends('layouts.admin')

@section('scripts')
    <script src="{{ mix('js/donations.js') }}"></script>
@endsection

@section('content')

    <div id="admin_content" class="flex-auto px-0">
        <div class="p-5 pb-8">
            <h1 class="admin-page__title">Donations:</h1>

            <form id="filters" action="{{ route('admin.donations.index') }}" method="get">
                <div class="row">
                    <div class="form-group col-md-3 col-12">
                        <label>Keyword:</label>
                        <input class="form-control" @if (!empty($keyword)) value="{{ $keyword }}" @endif name="keyword" type="text" />
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Status:</label>
                        <select class="form-control" name="status">
                            <option value>All</option>
                            @foreach (\App\Models\Donation::getStatuses() as $statusData)
                                <option value="{{ $statusData['id'] }}" @if (!is_null($status) && intval($status) === $statusData['id']) selected @endif>
                                    {{ $statusData['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Type:</label>
                        <select class="form-control" name="type" style="text-transform: capitalize;">
                            <option value>All</option>
                            @foreach (\App\Models\Donation::getTypes() as $typeData)
                                <option value="{{ $typeData['id'] }}" @if (!is_null($type) && intval($type) === $typeData['id']) selected @endif>
                                    {{ $typeData['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3 col-12">
                        <label>Date:</label>
                        <input class="form-control" type="text" name="daterange" value="{{ $daterange }}"
                            autocomplete="off" />
                    </div>
                </div>
                <button class="btn btn-primary">Filter</button>
                <a href="{{ route('admin.donations.index') }}"><button class="btn btn-info" type="button">Clear all
                        filters</button></a>
            </form>

            <a id="export" href="{{ route('donations.export') }}">
                <button class="btn btn-success mt-3 mb-3">Export to CSV</button>
            </a>

            <div class="table-card">
                <div class="table-wrapper">
                    <table class="table-auto mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Id</th>
                                <th class="px-4 py-2">Value</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Campaign</th>
                                <th class="px-4 py-2">User / Email</th>
                                <th class="px-4 py-2">Date</th>
                                <th class="px-4 py-2">Ip</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sign = '';
                            @endphp
                            @foreach ($donations as $donation)
                                @php
                                    if (empty($sign)) {
                                        $sign = $donation->currrency_sign;
                                    }
                                @endphp
                                <tr>
                                    <td class="px-4">{{ $donation->id }}</td>
                                    <td class="px-4">
                                        {{ $donation->currrency_sign }}{{ $donation->value }}
                                        @if ($donation->order && $donation->order->gift_aid)
                                            <br />
                                            Gift&nbsp;aid:&nbsp;+&nbsp;{{ $donation->currrency_sign }}{{ round($donation->value * 0.25, 2) }}
                                        @endif
                                        @if ($donation->commission)
                                            <br />
                                            Commission:&nbsp;+&nbsp;{{ $donation->currrency_sign }}{{ round($donation->commission, 2) }}
                                        @endif
                                    </td>
                                    <td class="px-4">{{ $donation->type_name }}</td>
                                    <td class="px-4" style="min-width: 250px;">

                                        <form method="post" class="form-inline"
                                              action="{{ route('admin.donations.save_status', [$donation->id]) }}">
                                            @csrf
                                            <div class="form-group m-0 mr-2">
                                                <select name="status" class="form-control">
                                                    @foreach(\App\Models\Donation::getStatuses() as $item)
                                                        <option class="{{ $item['class'] }}" value="{{ $item['id'] }}" @if ($donation->status === $item['id']) selected @endif>{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-inline btn-outline-primary" title="Save status" type="submit"><i
                                                    class="far fa-save"></i></button>
                                        </form>
                                    </td>
                                    <td class="px-4">
                                        @if(isset($donation->campaign))
                                            {{$donation->campaign->name}}
                                        @elseif(isset($donation->foodpack))
                                            {{$donation->foodpack->country->name. " FoodPack"}}
                                        @elseif(isset($donation->foodpackqurbani))
                                            {{$donation->foodpackqurbani->country->name. " Qurbani (" . $donation->foodpackqurbanitype->name . ")"}}
                                        @elseif($donation->upsell)
                                            {{ $donation->name ?? "Provide Rice This Eid" }}
                                        @else
                                            'no campaign'
                                        @endif
                                    </td>
                                    <td class="px-4">
                                        @if (isset($donation->user))
                                            {{ $donation->user->name }}
                                        @elseif (isset($donation->email))
                                            {{ $donation->email }}
                                        @else
                                            no user
                                        @endif
                                    </td>
                                    <td class="px-4">{{ $donation->created_at->format('d/m/Y h:i:s A') }}</td>
                                    <td class="px-4">{{ $donation->ip }}</td>
                                    <td class="px-4 action_td">
                                        <a
                                            href="{{ route('admin.donations.export_pdf', ['donation' => $donation->id]) }}">
                                            <button class="btn btn-outline-success action-btn" type="submit"
                                                title="Export pdf">
                                                <i class="fas fa-file-download"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('admin.donations.show', ['donation' => $donation->id]) }}">
                                            <button class="btn btn-info action-btn" type="submit" title="Show donation">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </a>
                                        <form method="post"
                                              action="{{ route('admin.donations.resend-mail', ['donation' => $donation->id]) }}"
                                              style="display:inline-block">
                                            @csrf
                                            <button class="btn btn-success action-btn" type="submit" title="Resend email"
                                                    onclick="return confirm('Are you sure want to resend email?')">
                                                <i class="fas fa-share-square"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                {{ $donations->links() }}
                <strong style="font-size: 20px;">Total: {{ $sign }}{{ $total }} (Gift Aid:
                    +{{ $sign }}{{ $totalGiftAid }})</strong>
            </div>
        </div>
    </div>

@endsection
