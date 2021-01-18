<div id="left_menu" class="">
    <ul>
        <li><a href="{{ route('index') }}" target="_blank"><i class="far fa-home"></i>Home page</a></li>
        @role(\App\Models\User::ROLE_ADMIN)
            <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i>Admin panel</a></li>
        @endrole
        <li><a href="{{ route('dashboard') }}"><i class="far fa-list-alt"></i>User dashboard</a></li>
        <li><a href="{{ route('profile.show') }}"><i class="fas fa-user"></i>Profile</a></li>
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-secondary" type="submit">
            Logout
        </button>
    </form>
</div>