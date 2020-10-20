<div id="left_menu" class="text-gray-700 bg-gray-500 px-4 py-2">
    <ul>
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-friends"></i>Users</a></li>
        <li><a href="{{ route('admin.post.index') }}"><i class="fas fa-file-alt"></i>Posts</a></li>
        <li><a href="{{ route('admin.post_group.index') }}"><i class="fas fa-book"></i>Post groups</a></li>
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-photo-video"></i>Media</a></li>
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-sliders-h"></i>Settings</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Logout
        </button>
    </form>
</div>