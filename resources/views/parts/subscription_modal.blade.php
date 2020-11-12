<!-- Modal -->
<div class="modal fade" id="subscription_modal" tabindex="-1" role="dialog" aria-labelledby="subscription_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Subscribe to news</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('subscribe') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" id="email" name="email" 
                    class="form-control" placeholder="Enter your email" />
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal" id="subscription_modal_sbmt">Submit</button>
        </div>
      </div>
    </div>
  </div>