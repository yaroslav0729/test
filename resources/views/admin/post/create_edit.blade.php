@php
    if (isset($post)) {
        $pageTitle = 'Edit post id: ' . $post->id;
        $actionRoute = route('admin.post.update', ['post' => $post->id]);
        $name = $post->name;
        $slug = $post->slug;
        $title = $post->title;
        $description = $post->description;
        $keywords = $post->keywords;
    } else {
        $pageTitle = 'Create post';
        $actionRoute = route('admin.post.store');
        $name = old('name');
        $slug = old('slug');
        $title = old('title');
        $description = old('description');
        $keywords = old('keywords');
    }
@endphp

@extends('layouts.admin')

@section('head')

    {{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({selector: '.widget_{{ \App\Models\Widget::WIDGET_RICH_TEXT }}' });</script> --}}

@endsection

@section('content')

<div id="admin_content" class="bg-gray-100 flex-auto">
    
    @if ($errors->any())
        <div class="mb-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Validation errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $actionRoute }}" method="post">
            @csrf

            @isset($post)
                @method('PUT')
            @endisset

            <div class="p-5 pb-8 lg:w-1/2">

            <h1>{{ $pageTitle }}</h1> 

            <label for="name">Name</label><br>
            <input id="name" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $name }}" /><br>
            
            <label for="slug">Slug</label><br>
            <input id="slug" name="slug" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $slug }}" /><br>
            
            <label for="title">Title</label><br>
            <input id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $title }}" /><br>

            <label for="description">Description</label><br>
            <textarea class="w-full" name="description" id="description">{{ $description }}</textarea>
            <br>

            <label for="keywords">Keywords</label><br>
            <textarea class="w-full" name="keywords" id="keywords">{{ $keywords }}</textarea>
            <br>

            <label for="groups">Post groups</label>
            <br>

            
            <select id="groups" name="groups[]" multiple class="w-full">
                @foreach ($groups as $group)

                    @php
                        $selected = false;
                        if ((isset($post)) && (in_array($group->id, $post->group_ids))) {
                            $selected = true;
                        }
                    @endphp

                    <option value="{{ $group->id }}" @if($selected) selected @endif>{{ $group->name }}</option>   
                @endforeach
            </select>

            </div>
            <br>

            <input type="hidden" name="widgets" :value="widgetsString" />

            <hr>

            <div class="p-5 pb-8 lg:w-full">
            <h3 class="mb-3">Post content:</h3>

            {{-- @isset($post)
                @foreach ($post->widgets as $widget)
                    {!! $widget->render() !!}
                @endforeach
            @endisset --}}

            <div class="mt-2 mb-3">
                <div v-for="(val, key) in widgets" class="flex mb-2">
                    <div class="flex-initial mr-3">
                        <button @click="widgetDown(key)" type="button" class="bg-green-400 hover:bg-green-500 text-white py-2 px-2 mr-1 rounded"><i class="fas fa-arrow-down"></i></button>
                        <button @click="widgetUp(key)" type="button" class="bg-green-400 hover:bg-green-500 text-white py-2 px-2 mr-1 rounded"><i class="fas fa-arrow-up"></i></button>
                        <button @click="widgetDelete(key)" type="button" class="bg-red-400 hover:bg-red-500 text-white py-2 px-2 mr-1 rounded"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    <div class="mb-2 flex-initial">
                        <div v-bind="{id: 'render_container_' + val.id }"> {{-- rendered widget --}}
                            @{{ val }}
                        </div>

                        <div class="alert alert-warning"> {{-- widget debug info --}}
                            @{{ val }}
                        </div>
                    </div>
                </div>
            </div>

            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Submit
            </button>

            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button"
                data-toggle="modal" data-target="#exampleModal">
                <i class="fas fa-plus"></i> New widget
            </button>

            </div>

        </form>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Select widget type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" id="add_new_widget">
                            @foreach ($widgets as $key => $widget)
                                <option value="{{ $key }}">{{ $widget }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" @click="addWidget">Select</button>
                </div>
            </div>
            </div>
        </div>

        {{-- do not remove this block - for Vue init --}}
        <div id="current_post_items" class="d-none alert alert-warning mt-3" >
            [
            @if (isset($post) && (count($post->widgets) > 0))
                @foreach ($post->widgets as $key => $widget)
                   {
                        "id": {{ $widget->id }}, 
                        "widget_id": {{ $widget->widget_id }},
                        "ordering": {{ $key }},
                        "parameters": "[]"
                    }
                   @if((count($post->widgets) > 1) && ($key+1 !== count($post->widgets))), @endif
                @endforeach
            @endif
            ]
        </div>
        <div id="rendered_post_items" class="d-none">
            @isset($post)
                @foreach ($post->widgets as $widget)
                    <div id="rendered_post_items_{{ $widget->id }}">
                        {!! $widget->render() !!}
                    </div>
                @endforeach
            @endisset
        </div>
        <div id="rendered_widgets" class="d-none">
            @foreach ($widgets as $widgetKey => $widget)
                <div id="rendered_widget_{{ $widgetKey }}">
                    {!! \App\Models\Widget::renderId($widgetKey) !!}
                </div>
            @endforeach
        </div>
</div>

@endsection

@section('scripts')
<script>

function swap (arr, i, j) {
    var temp = arr[i]; //temporarily store original value at i position
    arr[i] = arr[j]; //reassign value at i position to be value at j position
    arr[j] = temp; //reassign value at j position to original value at i position
  
    arr.push(0)//for vue reactivity
    arr.splice(arr.length-1, 1);//for vue reactivity
  
    return arr;
}

var app = new Vue({
  el: '#admin_content',
  data: {
    uniqCou: 0, // uniq for new added widget
    widgets: [],
    savedVidgets: []
  },
  computed: {
    widgetsString() {
        return JSON.stringify(this.widgets)
    }
  },
  created: function() {
    let currentWidgets = $('#current_post_items').html();
    currentWidgets = JSON.parse(currentWidgets)
    this.widgets = currentWidgets
  },
  mounted: function() {
    this.renderPostWidgets()
  },
  updated: function() {
    this.restoreVidgets()
    this.renderNewWidgets()
  },
  methods: {
    addWidget() {
        let widgetId = $('#add_new_widget').val()
        let count = this.widgets.length
        this.uniqCou++
        this.widgets.push({ 
            'id': 'new_' + this.uniqCou,
            'widget_id': widgetId,
            'ordering': count,
            'parameters': '[]',
            'rendered': false
        })
    },
    refreshOrdering() {
        for (let i=0; i<this.widgets.length; i++) {
            this.widgets[i].ordering = i;    
        }
    },
    widgetUp(N) {
        if (N > 0) {
            this.saveVidgetContent()
            swap(this.widgets, N, N-1)
            this.refreshOrdering()
        }  
    },
    widgetDown(N) {
        if (N !== this.widgets.length) {
            this.saveVidgetContent()
            swap(this.widgets, N, N+1) 
            this.refreshOrdering()
        }     
    },
    widgetDelete(N) {
        let ok = confirm("Are you sure want to delete?");
        if (ok) {
            this.widgets.splice(N, 1)
            this.refreshOrdering()
        }
    },
    renderPostWidgets() {

        for (var i=0; i< this.widgets.length; i++) {
            let id = this.widgets[i].id
            let widget = $('#rendered_post_items_' + id)
            let container = $('#render_container_' + id)
            let html = widget.html()
            container.html(html)
        }
        
        return
    },
    saveVidgetContent() {
        this.savedVidgets = []

        for (var i=0; i< this.widgets.length; i++) {
            
            let id = this.widgets[i].id
            let container = $('#render_container_' + id)
            let html = container.html()
            this.savedVidgets[this.widgets[i].id] = html
        }

        console.log(this.savedVidgets)
    },
    restoreVidgets() {
        for (var i=0; i< this.widgets.length; i++) {

            let id = this.widgets[i].id

            let container = $('#render_container_' + id)
            let html = this.savedVidgets[id]
            container.html(html)
        }   
    },
    renderNewWidgets() {
        for (var i=0; i< this.widgets.length; i++) {

            let id = this.widgets[i].id.toString()

            if (id.indexOf('new_') !== -1) {

                let rendered = this.widgets[i].rendered
                let widget_id = this.widgets[i].widget_id

                if (!rendered) {

                    console.log('first render new widget', id)

                    this.widgets[i].rendered = true
                    
                    let container = $('#render_container_' + id)
                    let html = $('#rendered_widget_' + widget_id).html()
                    container.html(html)
                }
            }
        } 
    }
  }
})

</script>
@endsection