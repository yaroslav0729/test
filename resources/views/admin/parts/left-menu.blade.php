<div id="left_menu" class="">
    <ul>
        <li><a class="@if(Request::url() === route('index')) active @endif" href="{{ route('index') }}" target="_blank"><i class="far fa-home"></i>Home page</a></li>
        <li><a class="@if(Request::url() === route('dashboard')) active @endif" href="{{ route('dashboard') }}"><i class="far fa-list-alt"></i>User dashboard</a></li>
        <li><a class="@if(Request::url() === route('admin.index')) active @endif" href="{{ route('admin.index') }}"><i class="fas fa-user-friends"></i>Users</a></li>
        <li><a class="@if(Request::url() === route('admin.menu_items.index')) active @endif" href="{{ route('admin.menu_items.index') }}"><i class="fas fa-tasks"></i>Menu</a></li>
        <li><a class="@if(Request::url() === route('admin.pages.index')) active @endif" href="{{ route('admin.pages.index') }}"><i class="fas fa-file-alt"></i>Pages</a></li>
        <li><a class="@if(Request::url() === route('admin.pages.index', ['template' => \App\Models\Template::EVENT_PAGE])) active @endif" href="{{ route('admin.pages.index', ['template' => \App\Models\Template::EVENT_PAGE]) }}"><i class="fas fa-calendar-star"></i>Events</a></li>
        <li><a class="@if(Request::url() === route('admin.category.index')) active @endif"href="{{ route('admin.category.index') }}"><i class="fas fa-folder-open"></i>Categories</a></li>
        <li><a class="@if(Request::url() === route('admin.campaigns.index')) active @endif" href="{{ route('admin.campaigns.index') }}"><i class="far fa-building"></i>Campaigns</a></li>
        <li><a class="@if(Request::url() === route('admin.campaign_categories.index')) active @endif" href="{{ route('admin.campaign_categories.index') }}"><i class="fas fa-clone"></i>Campaign categories</a></li>
        <li><a class="@if(Request::url() === route('admin.donations.index')) active @endif" href="{{ route('admin.donations.index') }}"><i class="far fa-usd-circle"></i>Donations</a></li>
        <li><a class="@if(Request::url() === route('admin.donations.scheduled-sacrifice')) active @endif" href="{{ route('admin.donations.scheduled-sacrifice') }}"><i class="far fa-usd-circle"></i>Scheduled Qurbani</a></li>
        <li><a class="@if(Request::url() === route('admin.subscription.index')) active @endif" href="{{ route('admin.subscription.index') }}"><i class="fas fa-book"></i>Subscriptions</a></li>
        <li><a class="@if(Request::url() === route('admin.email_logs.index')) active @endif" href="{{ route('admin.email_logs.index') }}"><i class="fas fa-envelope-open-text"></i>Email logs</a></li>
        <li><a class="@if(Request::url() === route('media.index')) active @endif" href="{{ route('media.index') }}"><i class="fas fa-photo-video"></i>Media</a></li>
        <li><a class="@if(Request::url() === route('admin.settings.index')) active @endif" href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i>Settings</a></li>
        <li><a class="@if(Request::url() === route('admin.redirects.index')) active @endif" href="{{ route('admin.redirects.index') }}"><i class="fas fa-directions"></i>Redirects</a></li>
        <li><a class="@if(Request::url() === route('admin.foodpack.index'))) active @endif" href="{{ route('admin.foodpack.index') }}"><i class="fas fa-utensils-alt"></i>FoodPack</a></li>
        <li><a class="@if(Request::url() === route('admin.foodpack-qurbanies.index')) active @endif" href="{{ route('admin.foodpack-qurbanies.index') }}"><i class="fas fa-utensils-alt"></i>FoodPack Qurbani</a></li>
        <li><a class="@if(Request::url() === route('admin.black-list.index')) active @endif" href="{{ route('admin.black-list.index') }}"><i class="fas fa-list"></i>Black List</a></li>
        <li><a class="@if(Request::url() === route('admin.banner.create_or_edit')) active @endif" href="{{ route('admin.banner.create_or_edit') }}"><i class="fas fa-ad"></i>Banner</a></li>
        <li><a class="@if(Request::url() === route('admin.upsells.create_or_edit')) active @endif" href="{{ route('admin.upsells.create_or_edit') }}"><i class="fas fa-cart-plus"></i>Upsell</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-secondary" type="submit">
            Logout
        </button>
    </form>
</div>
