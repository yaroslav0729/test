<div id="left_menu" class="">
    <ul>
        <li><a href="{{ route('index') }}" target="_blank"><i class="far fa-home"></i>Home page</a></li>
        <li><a href="{{ route('dashboard') }}"><i class="far fa-list-alt"></i>User dashboard</a></li>
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-friends"></i>Users</a></li>
        <li><a href="{{ route('admin.pages.index') }}"><i class="fas fa-file-alt"></i>Pages</a></li>
        <li><a href="{{ route('admin.pages.index', ['filter' => 'events']) }}"><i class="fas fa-file-alt"></i>Events</a></li>
        <li><a href="{{ route('admin.category.index') }}"><i class="fas fa-folder-open"></i>Categories</a></li>
        <li><a href="{{ route('admin.campaigns.index') }}"><i class="far fa-building"></i>Campaigns</a></li>
        <li><a href="{{ route('admin.campaign_categories.index') }}"><i class="fas fa-clone"></i></i>Campaign categories</a></li>
        <li><a href="{{ route('admin.subscription.index') }}"><i class="fas fa-book"></i>Subscriptions</a></li>
        <li><a href="{{ route('media.index') }}"><i class="fas fa-photo-video"></i>Media</a></li>
        <li><a href="{{ route('admin.settings.index') }}"><i class="fas fa-sliders-h"></i>Settings</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-secondary" type="submit">
            Logout
        </button>
    </form>
</div>
