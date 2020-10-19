<div id="left_menu" class="text-gray-700 bg-gray-400 px-4 py-2 m-2">
    <ul>
        <li><a href="{{ route('admin.index') }}">Users</a></li>
        <li><a href="{{ route('admin.post.index') }}">Posts</a></li>
        <li><a href="{{ route('admin.index') }}">Settings</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Logout
        </button>
    </form>
</div>