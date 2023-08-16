<div id="left_menu" class="">
    <ul>
        <li><a class="@if (Request::url()===route('index')) active @endif" href="{{ route('index') }}" target="_blank"><i class="far fa-home"></i>Home page</a></li>
        @role(\App\Models\User::ROLE_ADMIN)
        <li><a href="{{ route('admin.index') }}"><i class="fas fa-user-shield"></i>Admin panel</a></li>
        @endrole
        <li><a class="@if (Request::url()===route('dashboard')) active @endif" href="{{ route('dashboard') }}"><i class="far fa-list-alt"></i>User dashboard</a>
        </li>
        <li><a class="@if (Request::url()===route('profile.show')) active @endif" href="{{ route('profile.show') }}"><i class="fas fa-user"></i>Profile</a></li>
        <li><a class="@if (Request::url()===route('user.donations')) active @endif" href="{{ route('user.donations') }}"><i class="fas fa-usd-circle"></i>My
                donations</a></li>
        @if(!empty(auth()->user()->stripe_customer_id))
            <li><a class="" target="_blank" href="{{ route('stripe.portal') }}"><i class="fas fa-cog"></i>Payment's
                    Settings</a></li>
        @endif
    </ul>
    <br><br>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button class="btn btn-secondary" type="submit">
            Logout
        </button>
    </form>
</div>
