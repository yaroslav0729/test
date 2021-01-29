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

<h1>Successful payment! You will be redirected back after 5 sec</h1>

@php
    use \App\Models\PageInstance;
    use \App\Models\Template;

    $link = PageInstance::where('template', Template::THANK_YOU_DONATE_PAGE)->actual()->first();
@endphp

@empty($link)
@else 
    <a id="redirect_link" href="{{ url($link->slug) }}">Success page</a>

    <script type="text/javascript">
        var link = $('#redirect_link').attr('href')
        console.log(link)

        $(document).ready(function () {
            setTimeout(function () {
                window.location = link;
            }, 5000);
        });

    </script>
@endempty
</body>
</html>