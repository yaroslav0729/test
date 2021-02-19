@extends('layouts.main')

@section('header')
    @include( $configTemplate['headerType'], ['configTemplate' => $configTemplate] )
@endsection

@section('content')
    <section class="mt-5">
        @foreach($pages as $page )
        <div class="row mb-2">
            <div class="col-12">
                <div class="card flex-md-row mb-4 box-shadow h-md-200">
                    <img class="card-img-right flex-auto d-none d-md-block"
                         data-src="holder.js/200x150?theme=thumb" alt="/storage/images/Praying-mosque-background.jpg" style="width: 250px; height: 200px;"
                    @if (empty($page->getActualPageInstanceAttribute()->preview_img))
                         src="/storage/images/Praying-mosque-background.jpg"
                    @else
                         src="{{ $page->getActualPageInstanceAttribute()->preview_img }}"
                    @endif
              {{--      {{ $page->getActualPageInstanceAttribute()->preview_img ?? '/storage/images/Praying-mosque-background.jpg' }} "--}}
                         data-holder-rendered="true">
                    <div class="card-body d-flex flex-column align-items-start">
                        <h3 class="mb-0">
                            <a class="text-dark" href="{{ $page->getActualPageInstanceAttribute()->slug ?? '' }}">{{ $page->getActualPageInstanceAttribute()->name ?? '' }}</a>
                        </h3>
                        <div class="mb-1 text-muted mt-3">
                            {{ Illuminate\Support\Carbon::parse($page->published_at)->format('jS F Y') }}
                        </div>
                        <p class="card-text mb-auto  mt-3">{{ $page->getActualPageInstanceAttribute()->preview_text }}</p>
                        <a href="{{ $page->getActualPageInstanceAttribute()->slug ?? '' }}" class="text-blue">Continue reading</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </section>



@endsection

@section('footer')
    @include('parts.footer', ['configTemplate' => $configTemplate])
@endsection
