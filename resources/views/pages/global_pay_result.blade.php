<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment result</title>
</head>
<body>

<h1>Successful payment! You will be redirected back</h1>

@php
    use \App\Models\PageInstance;
    use \App\Models\Template;

    $link = PageInstance::where('template', Template::THANK_YOU_DONATE_PAGE)->actual()->first();
@endphp

@empty($link)
@else 
    <a href="{{ url($link->slug) }}">Success page</a>
@endempty
</body>
</html>