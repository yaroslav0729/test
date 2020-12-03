@if ($errors->any())
    <div class="p-3">
        <div class="alert alert-danger" role="alert">
            <strong class="font-weight-bold">Validation errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success" role="alert">
        <div class="flex">
            <div>
                <p class="font-weight-bold">Success</p>
                <p class="text-sm">{{ session('status') }}</p>
            </div>
        </div>
    </div>
@endif
