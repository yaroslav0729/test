<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment result</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" crossorigin="anonymous"></script>
</head>

<body>

    <h1>Successful payment!</h1>

    @php
        use App\Models\PageInstance;
        use App\Models\Template;

        $link = PageInstance::where('template', Template::THANK_YOU_DONATE_PAGE)->first();
        $url = url($link->slug);
        if (isset($order)) {
            $url = $url . '?order=' . $order->order_id;
        }
    @endphp

    @empty($link)
    @else
        <script type="text/javascript">
            var link = '{!! $url !!}'
            console.log(link)

            $(document).ready(function() {
                setTimeout(function() {
                    window.location = link;
                }, 0);
            });
        </script>
    @endempty
</body>

</html>
