@php
$categories = \App\Models\CampaignCategory::all();    
@endphp

<div class="wrap">
    <section class="quick-donation" quick-donation>
        <form action="{{ route('cart.add') }}" method="post">
            @csrf
            <div class="row gutter-5 align-items-center">
                <div class="col-2 text-center"><b>Quick Donation</b></div>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" name="period">
                            <option value="single">Single donation</option>
                            <option value="monthly">Monthly donation</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" name="categories">
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}"> {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <input type="text" name="amount" class="form-control" placeholder="£  Enter amount">
                    </div>
                </div>
                <div class="col-2">
                    <button type="submit" class="btn_sbmt btn btn-danger">Donate now</button>
                </div>
            </div>
        </form>
    </section>
</div>