<div id="left_menu" class="">
    <ul>
        <li><a href="{{ route('index') }}" target="_blank"><i class="far fa-home"></i>Home page</a></li>
        <li><a href="{{ route('dashboard') }}"><i class="far fa-list-alt"></i>User dashboard</a></li>
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-friends"></i>Users</a></li>
        <li><a href="{{ route('admin.menu_items.index', ['menuSlug' =>'header']) }}"><i class="fas fa-bars"></i>Header Menu</a></li>
        <li><a href="{{ route('admin.menu_items.index', ['menuSlug' =>'additional-header']) }}"><i class="fas fa-bars"></i>Additional header Menu</a></li>
        <li><a href="{{ route('admin.menu_items.index', ['menuSlug' =>'footer']) }}"><i class="fas fa-bars"></i>Footer Menu</a></li>
        <li><a href="{{ route('admin.pages.index') }}"><i class="fas fa-file-alt"></i>Pages</a></li>
        <li><a href="{{ route('admin.pages.index', ['template' => \App\Models\Template::EVENTS_PAGE]) }}"><i class="fas fa-calendar-star"></i>Events</a></li>
        <li><a href="{{ route('admin.category.index') }}"><i class="fas fa-folder-open"></i>Categories</a></li>
        <li><a href="{{ route('admin.campaigns.index') }}"><i class="far fa-building"></i>Campaigns</a></li>
        <li><a href="{{ route('admin.campaign_categories.index') }}"><i class="fas fa-clone"></i>Campaign categories</a></li>
        <li><a href="{{ route('admin.donations.index') }}"><i class="far fa-usd-circle"></i>Donations</a></li>
        <li><a href="{{ route('admin.subscription.index') }}"><i class="fas fa-book"></i>Subscriptions</a></li>
        <li><a href="{{ route('admin.email_logs.index') }}"><i class="fas fa-envelope-open-text"></i>Email logs</a></li>
        <li><a href="{{ route('media.index') }}"><i class="fas fa-photo-video"></i>Media</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-secondary" type="submit">
            Logout
        </button>
    </form>
</div>
