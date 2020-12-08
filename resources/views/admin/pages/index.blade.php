@extends('layouts.admin')

@section('content')

<div id="admin_content" class="flex-auto h-screen">
    <div class="p-5 pb-8">
        <h1>Pages:</h1>

        <form action="{{ route('admin.pages.index') }}" method="get">
          <div class="row">
            <div class="form-group col-6">
              <label>Filter name:</label>
              <input class="form-control" @if(!empty($nameFilter)) value="{{ $nameFilter }}" @endif name="search_name" type="text" />
            </div>
            <div class="form-group col-6">
              <label>Filter template:</label>
              <select name="template" class="form-control">
                <option value="0">Not selected</option>
                @foreach (\App\Models\Template::ALL_TEMPLATES as $template)
                    <option value="{{ $template }}"
                    @if((!empty($templateFilter)) && ((int)$templateFilter === $template))
                    selected
                    @endif
                    >{{ \App\Models\Template::getLabel($template) }}</option>
                @endforeach
              </select>
            </div>
            </div>
          <button class="btn btn-primary">Filter</button>
          <a href="{{ route('admin.pages.index') }}"><button class="btn btn-info" type="button">Clear all filters</button></a>
        </form>

        <a href="{{ route('admin.pages.create') }}">
          <button class="btn btn-success mt-3 mb-3" type="button" title="Create post">
            <i class="far fa-plus-square mr-2"></i>Create
          </button>
        </a>

        <table class="table-auto mb-3">
            <thead>
              <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Template</th>
                <th class="px-4 py-2">Url name</th>
                <th class="px-4 py-2">Author</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Created at</th>
                <th class="px-4 py-2">Action</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($pages as $page)
                  @php
                    $pageInstance = $page->actual_page_instance;

                  @endphp
                    @if($pageInstance)
                      <tr>
                          <td class="border px-4 py-2">{{ $page->id }}</td>
                          <td class="border px-4 py-2">{{ $pageInstance->name }}</td>
                          <td class="border px-4 py-2">{{ $pageInstance->template_name }}</td>
                          <td class="border px-4 py-2">
                            @if ($pageInstance->is_published)
                              <a href="{{ url($pageInstance->slug) }}" target="_blank">{{ $pageInstance->slug }}</a>
                            @else
                              {{ $pageInstance->slug }}
                            @endif
                          </td>
                          <td class="border px-4 py-2">@isset($pageInstance->author){{ $pageInstance->author->name }} @else No author @endisset</td>
                          <td class="border px-4 py-2" style="min-width: 250px;">

                            <form method="post" class="form-inline" action="{{ route('admin.pages.save_status', ['id' => $page->id]) }}">
                              @csrf
                              <div class="form-group m-0 mr-2">
                              <select name="status" class="form-control">
                                @foreach (\App\Models\page::POST_STATUS as $statusKey => $status)
                                  <option value="{{ $statusKey }}"
                                  @if($statusKey === $page->status) selected @endif
                                  >{{ $status }}</option>
                                @endforeach
                              </select>
                              </div>
                              <button class="btn btn-inline btn-outline-primary" type="submit"><i class="far fa-save"></i></button>
                            </form>
                          </td>
                          <td class="border px-4 py-2">{{ $pageInstance->created_at->format('d/m/Y') }}</td>
                          <td class="border px-4 py-2 action_td">
                            <a href="{{ route('admin.pages.edit', ['page' => $page->id]) }}">
                              <button class="btn btn-info action-btn" type="button" title="Edit post">
                                <i class="fas fa-edit"></i>
                              </button>
                            </a>
                            <a href="{{ route('admin.pages.history', ['id' => $page->id]) }}" >
                              <button class="btn btn-outline-success action-btn" type="button" title="Watch post history">
                                <i class="fas fa-history"></i>
                              </button>
                            </a>
                            <form method="post" action="{{ route('admin.pages.destroy', ['page' => $page->id]) }}" style="display:inline-block">

                              @csrf
                              @method('DELETE')

                              <button class="btn btn-danger action-btn" type="submit" title="Delete post" onclick="return confirm('Are you sure want to delete?')">
                                <i class="fas fa-trash-alt"></i>
                              </button>
                          </form>

                          </td>
                      </tr>
                    @endif
                @endforeach

            </tbody>
          </table>
          {{ $pages->appends(request()->except('page'))->links() }}
    </div>
</div>

@endsection
