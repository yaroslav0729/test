@php
$categories = \App\Models\CampaignCategory::all();    
@endphp

<div class="wrap">
    <section class="quick-donation" quick-donation>
        <form action="{{ route('cart.add') }}" method="post">
            @csrf
            <div class="row gutter-5 align-items-center">
                <div class="col-12 col-lg-2 text-center"><b class="mb-3 mb-lg-0 d-block">Quick Donation</b></div>
                <div class="col-6 col-lg-3">
                    <div class="form-group mb-3 mb-lg-0">
                        <select class="form-control" name="period">
                            <option value="single">Single donation</option>
                            <option value="monthly">Monthly donation</option>
                        </select>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="form-group mb-3 mb-lg-0">
                        <select class="form-control" name="categories">
                            @foreach ($categories as $category)
                                <option value="{{ $category->name }}"> {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="form-group" currency="£">
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount" oninput="this.value = Math.abs(this.value)" min="5">
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <button type="submit" class="btn_sbmt btn btn-danger w-100">Donate now</button>
                </div>
            </div>
        </form>
    </section>
</div>