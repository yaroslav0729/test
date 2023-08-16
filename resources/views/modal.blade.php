<div class="modal-dialog @yield('modal-class', 'modal-dialog-centered modal-lg')" role="document" data-backdrop="static"
    @yield('modal-attribute')>
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">@yield('title')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger" style="display: none;">
                <ul id="modal-errors">
                </ul>
            </div>
            <div class="alert alert-success" style="display: none;">
                <span id="modal-message-success">
                </span>
            </div>
            @yield('body')

            <div class="modal-footer">
                @yield('footer')
            </div>

        </div>
    </div>
</div>