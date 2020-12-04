<!-- Modal -->
<div class="modal fade" id="donate_modal" tabindex="-1" role="dialog" aria-labelledby="donate_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <form action="{{ route('cart.add') }}" method="POST">
          @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="donate_modalLabel">@empty($projHeading) Donate now @else {{ $projHeading }} @endisset</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Select an Amount:</label>
            <div class="col-sm-9">
            <input name="amount" type="text" class="form-control" placeholder="£  Enter amount">
            </div>
          </div>

          <div class="form-group row">
            <input type="hidden" name="campaigns" value="" />
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Donation Type:</label>
            <div class="col-sm-9">
            <select class="form-control" name="categories">
                {{-- will be replaced by js --}}
            </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 col-form-label">Period:</label>
            <div class="col-sm-9">
            <select class="form-control" name="period">
              <option value="{{ \App\Models\CampaignPrice::TYPE_SINGLE }}">Single</option>
              <option value="{{ \App\Models\CampaignPrice::TYPE_MONTHLY }}">Monthly</option>
            </select>
            </div>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </div>
        </form>
      </div>
    </div>
  </div>