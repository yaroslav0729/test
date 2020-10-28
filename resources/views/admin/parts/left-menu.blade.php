<div id="left_menu" class="">
    <ul>
        <li><a href="{{ route('index') }}" target="_blank"><i class="far fa-home"></i>Home page</a></li>
        <li><a href="{{ route('dashboard') }}"><i class="far fa-list-alt"></i>User dashboard</a></li>
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-friends"></i>Users</a></li>
        <li><a href="{{ route('admin.post.index') }}"><i class="fas fa-file-alt"></i>Posts</a></li>
        <li><a href="{{ route('admin.post_group.index') }}"><i class="fas fa-book"></i>Post groups</a></li>
        <li><a href="#"><i class="fas fa-photo-video"></i>Media</a></li>
        <li><a href="#"><i class="fas fa-sliders-h"></i>Settings</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-secondary" type="submit">
            Logout
        </button>
    </form>
</div>