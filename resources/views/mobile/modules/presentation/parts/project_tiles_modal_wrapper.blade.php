<!-- Modal -->
<div class="modal fade" id="proj_tiles_modal_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Donation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @foreach ($projects as $projKey => $project)

      @php
          $projInstance = $project->actual_page_instance;
      @endphp

      @include('modules.presentation.parts.projects_tiles_popup', ['popupKey' => $projInstance->id])

      @endforeach
      </div>
    </div>
  </div>
</div>