<section class="donate-today">
    <div class="wrap">
        <div class="title">
            <div class="row align-items-center">
                <div class="col-6">
                    <p class="font-size-60"><b>Donate today</b></p>
                </div>
                <div class="col-6 text-right">
                    <a href="#" class="text-underline text-uppercase text-dark"><b>calculate my zakat</b></a>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-6">
                    <p class="font-size-16">Make your donation here of which 100ch ut perspiciatis unde omnis iste natus demiour sit voluptatem.</p>
                </div>
            </div>
        </div>

        @include('modules.presentation.projects_donate', [
            'parameters' => $parameters,
            'useAppeal' => true
        ])

    </div>
</section>


<section class="donate-projects-list">
    <div class="title">
        <div class="wrap">
            <div class="row">
                <div class="col-6">
                    <p class="font-size-30"><b>Donate to a project too?</b></p>
                    <p class="font-size-16">You could also join the journey to support our causes that empower those in need each month/single donation 100ch.</p>

                </div>
            </div>
        </div>
    </div>

    @include('modules.presentation.projects_tiles')

</section>

<section class="about-donation">
    <div class="wrap">

        <div class="body no-donate">
            <div class="row align-items-center gutter-0">
                <div class="col-6">
                    <div class="row align-items-center gutter-0">
                        <div class="col-7 text-center">
                            <p class="font-size-20 mb-0"><b>Your donation so far...</b></p>
                        </div>
                        <div class="col-5 text-center">
                            <div class="price">£0.00</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 line">
                    <p class="mb-0">No matter the amount, your support could mean everything to someone...</p>
                </div>
            </div>
        </div>

        <div class="body donated">
            <div class="row align-items-center">
                <div class="col-7">
                    <p class="font-size-20 mb-0"><b>Your donation so far...</b></p>
                </div>
                <div class="col-5 text-right">
                    <div class="price">£300.00</div>
                </div>
            </div>
            <div class="black-line"></div>
            <div class="pt-4"></div>
            <div class="item">
                <div class="row gutter-0">
                    <div class="col-5">
                        <div>
                            <p class="font-size-20 mb-0"><b>General Charity</b></p>
                            <a href="#" class="btn-remove"> <i class="fal fa-times"></i> REMOVE</a>
                        </div>
                    </div>
                    <div class="col-7">
                        <div>
                            <table class="w-100">
                                <tr>
                                    <td><p class="font-size-20 mb-0">Single payment</p></td>
                                    <td><input type="number" value="1" min="0" max="1000" step="1" class="color-danger"/></td>
                                    <td class="text-right"><p class="font-size-20 mb-0"><b>£50.00</b></p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="row gutter-0">
                    <div class="col-5">
                        <div>
                            <span>+Sadiqah</span>
                            <p class="font-size-20 mb-0"><b>General Charity</b></p>
                            <a href="#" class="btn-remove"> <i class="fal fa-times"></i> REMOVE</a>
                        </div>
                    </div>
                    <div class="col-7 d-flex align-items-center">
                        <div>
                            <table class="w-100">
                                <tr>
                                    <td><p class="font-size-20 mb-0">Single payment</p></td>
                                    <td><input type="number" value="1" min="0" max="1000" step="1" class="color-danger"/></td>
                                    <td class="text-right"><p class="font-size-20 mb-0"><b>£50.00</b></p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4"></div>
            <div class="down-bar">
                <div class="row align-items-center">
                    <div class="col-7">
                        <p>Thank you, this donation could help empower 512 people!</p>
                    </div>
                    <div class="col-5 text-right">
                        <a href="#" class="btn  btn-danger">Checkout <i class="far fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>


        <div class="text-center mb-4">
            <img src="img/payments-image.png" alt="" class="img-fluid">

        </div>
    </div>
</section>

<section class="other-way-give">
    <div class="wrap">
        <div class="mb-5 text-center">
            <p class="font-size-30"><b>Other ways to give:</b></p>
        </div>
        <div class="row">
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-telephone.png)"></span>
                    <p><b>Call Us</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-bank-transfer.png)"></span>
                    <p><b>Bank Transfer</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-Paym.png)"></span>
                    <p><b>By Mobile</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
            <div class="col-3">
                <a href="#">
                    <span style="background-image: url(img/ico-Paypal.png)"></span>
                    <p><b>Paypal</b></p>
                    <i href="#">MORE DETAILS</i>
                </a>
            </div>
        </div>
    </div>
</section>


<div class="added-to-cart-snackbar">
    <i class="fal fa-shopping-cart"></i>
    <div class="price">£250</div>
    <span>This Monthly Donation has been added to your cart!</span>
</div>

<div class="pt-5"></div>

