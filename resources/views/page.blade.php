@extends('layouts.main')

@section('header')
    @include( $configTemplate['headerType'], ['configTemplate' => $configTemplate] )
@endsection

@section('content')

    {!! $html !!}

@endsection


@section('footer')
    @include('parts.footer', ['configTemplate' => $configTemplate])
@endsection

@section('scripts')


    @php
    $thankYouPage = App\Models\Page::getSinglePageUrl(App\Models\Template::THANK_YOU_DONATE_PAGE);
    $thankYouPageParts = explode('/', $thankYouPage);
    $thankYouUrl = $thankYouPageParts[count($thankYouPageParts) - 1];
    @endphp
    @if (request()->route()->slug === $thankYouUrl)
        @php
            $orderId = request()->order;
            $order = null;

            if ($orderId) {
                $order = App\Models\Order::where('order_id', $orderId)->first();
            }
        @endphp
        @if ($order)
            @php
                $gtmOrder = [
                    'transactionId' => $order->order_id,
                    'transactionAffiliation' => 'Islamic Help',
                    'transactionTotal' => $order->getSumAttribute(),
                    'transactionProducts' => [],
                ];

                foreach ($order->donations as $donation) {
                    $gtmOrder['transactionProducts'][] = [
                        'name' => $donation->campaign ? $donation->campaign->name : 'no campaign',
                        'price' => $donation->value,
                    ];
                }

                $gtmOrder = json_encode($gtmOrder);
            @endphp
            <script>
                window.dataLayer = window.dataLayer || [];

                let data = {!! $gtmOrder !!};
                dataLayer.push(data);
            </script>

        @endif
    @endif

@endsection
