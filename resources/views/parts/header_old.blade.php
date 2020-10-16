<div class="bg-gray-100">
    <div class="container mx-auto text-right">
        @guest
            <a class="mr-2" href="{{ route('login') }}">login</a>
            <a href="{{ route('register') }}">register</a>
        @else
            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 underline">Dashboard</a>
        @endguest
    </div>
</div>
<div id="header" class="container mx-auto box-border align-middle">
    <div id="logo">Islamic Help</div>
</div>