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
        $pageTitle = 'Create post:';
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
        <div class="p-3">
            <div class="alert alert-danger" role="alert">
                <strong class="font-bold">Validation errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
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
            <input required id="slug" name="slug" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-2" type="text" value="{{ $slug }}" /><br>
            
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

            <div class="alert alert-warning">
                <div v-for="(val, key) in widgets" class="mb-3 border rounded p-3">
                    @{{ val }}
                </div>
            </div>

            <div class="mt-2 mb-3">
                <div v-for="(widget, key) in widgets" class="mb-3 border rounded p-3">
                    <div class="mr-3 widget_buttons">
                        <button @click="widgetDown(key)" type="button" class="btn btn-success"><i class="fas fa-arrow-down"></i></button>
                        <button @click="widgetUp(key)" type="button" class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
                        <button @click="widgetDelete(key)" type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    <div class="mb-2 flex-initial">
                        <div v-bind="{id: 'render_container_' + widget.id }"> {{-- rendered widget --}}
                            <h3>@{{ widget.label }}</h3>

                            <div v-for="(param, key) in widget.saved_parameters" class="mb-3 border rounded p-3">
                                <h4>Param name: @{{ param.name  }}</h4>

                                <div v-if="param.type === '{{ \App\Models\WidgetParameters::PARAM_TYPE_BOOLEAN }}'">
                                    <input v-model="param.value" type="radio" value="true">
                                    <label>Enabled</label><br>
                                    <input v-model="param.value" type="radio" value="false">
                                    <label>Disabled</label><br>
                                </div>

                                <div v-if="param.type === '{{ \App\Models\WidgetParameters::PARAM_TYPE_TEXT }}'">
                                    <textarea v-model="param.value"></textarea>
                                </div>

                                <div v-if="param.type === '{{ \App\Models\WidgetParameters::PARAM_TYPE_INPUT_STRING }}'">
                                    <input v-model="param.value" />
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-info" type="submit">
                Submit
            </button>

            <button class="btn btn-success" type="button"
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
                            @foreach (\App\Models\Widget::WIDGET_LABELS as $key => $widget)
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

        <div id="current_post_items" class="d-none alert alert-warning mt-3" >
            @isset($widgetsRestore)
                {{ $widgetsRestore }}
            @endisset
        </div>

        <div id="widget_default_values" class="alert alert-warning mt-3" >
            {{ $widgetDefaultValues }}
        </div>

        <div id="widget_labels" class="alert alert-warning mt-3" >
            {{ $widgetLabels }}
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

jQuery.fn.swapWith = function(to) {
    return this.each(function() {
        var copy_to = $(to).clone(true);
        var copy_from = $(this).clone(true);
        $(to).replaceWith(copy_from);
        $(this).replaceWith(copy_to);
    });
};

var app = new Vue({
  el: '#admin_content',
  data: {
    uniqCou: 0, // uniq for new added widget
    widgets: [],
    savedVidgets: [],
    defaultValues: [],
    widgetLabels: [],
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
    //this.renderPostWidgets()
    this.calcDefaultValues()
    this.setWidgetLabels()
  },
  updated: function() {

  },
  methods: {
    calcDefaultValues() {
        let defaults = $('#widget_default_values').html()
        this.defaultValues = JSON.parse(defaults)
        console.log(this.defaultValues)
    },
    setWidgetLabels() {
        let labels = $('#widget_labels').html()
        this.widgetLabels = JSON.parse(labels)
        console.log('labels', this.widgetLabels)
    },
    addWidget() {
        let widgetId = $('#add_new_widget').val()
        let count = this.widgets.length
        this.uniqCou++
        this.widgets.push({ 
            'id': 'new_' + this.uniqCou,
            'widget_id': widgetId,
            'ordering': count,
            'saved_parameters': this.defaultValues[widgetId],
            'rendered': false,
            'label': this.widgetLabels[widgetId]
        })
    },
    refreshOrdering() {
        for (let i=0; i<this.widgets.length; i++) {
            this.widgets[i].ordering = i;    
        }
    },
    widgetUp(N) {
        if (N > 0) {
            swap(this.widgets, N, N-1)
            this.refreshOrdering()
        }  
    },
    widgetDown(N) {
        if (N !== this.widgets.length) {
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
    swapDomElements(A, B) {
        let id1 = this.widgets[A].id
        let id2 = this.widgets[B].id

        let container1 = $('#render_container_' + id1)
        let container2 = $('#render_container_' + id2)

        $(container1).swapWith(container2);
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