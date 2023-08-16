<html lang="en">

<head>
    <style>
        .donation {
            padding: 15px;
            border: 1px solid #e6e6e6;
        }

        .donation__text {
            font-size: 18px;
        }

        .text-danger {
            color: #be2a2a;
        }

        .text-small {
            font-size: 14px;
        }

        .donation__table {
            width: 100%;
            margin-left: -15px;
            margin-right: -15px;
            margin-bottom: 20px;
        }

        .donation__table th,
        .donation__table td {
            font-size: 12px;
            border: 1px solid #e6e6e6;
            padding: 10px 15px;
            text-align: left;
        }

        .donation__table td {
            background-color: #f4fbef;
            color: #5fac2a;
            vertical-align: middle;
        }

        .type-cell {
            text-transform: capitalize;
        }

    </style>
</head>

<body>
    <div class="donation">
        <p class="donation__text">User email: <span class="text-danger"><b>{{ $order->email }}</b></span></p>
        <p class="donation__text">Total amount: <span class="text-danger"><b>£{{ $order->sum }}</b></span></p>

        <table class="donation__table" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th>
                        Donation
                    </th>
                    <th>
                        Detail
                    </th>
                    <th>
                        Donation Amount
                    </th>
                </tr>
            </thead>
            <tbody>
                @isset($order->donations)
                    @foreach ($order->donations as $donation)
                        <tr>
                            <td class="type-cell">
                                {{ $donation->type_name }} Donation
                            </td>
                            <td>
                                {{ $donation->campaign ? $donation->campaign->name : 'no campaign' }}<br />
                                {{ $donation->campaign_category ? $donation->campaign_category->name : 'no campaign' }}
                            </td>
                            <td>
                                {{ $donation->currrency_sign }}{{ $donation->value }}
                            </td>
                        </tr>
                    @endforeach
                @endisset
            </tbody>
        </table>
        <p class="donation__text text-small">Date of donate: {{ $order->created_at->format('j M Y H:i') }}</p>
        <p class="donation__text text-small">Islamic Help Reference: {{ $order->order_id }}</p>
        <p class="donation__text text-small">Islamic Help ID: IH00{{ $order->id }}</p>

        <br />
        @if ($order->account_number)
            <p class="donation__text text-small"><b>Account Number:</b> {{ $order->account_number }}</p>
            <p class="donation__text text-small"><b>Sort Code:</b> {{ $order->sort_code }}</p>
            <p class="donation__text text-small"><b>Payment Day:</b> {{ $order->pay_day }}</p>
        @endif
    </div>
</body>

</html>
