@php

    $tabCalculatorTitle = "";
    $tabWhatZakatTitle = "";

    $whatIsZakatTitle = "";
    $whatIsZakatText = "";

    $whatIsObligatoryTitle = "";
    $whatIsObligatoryText = "";

    $whatIsWhyWeDonateTitle = "";
    $whatIsWhyWeDonateText = "";

    $whatIsReceiveTitle = "";
    $whatIsReceiveText = "";

    $whatIsHowCalculatedTitle = "";
    $whatIsHowCalculatedText = "";

    $whatIsHowNisaabTitle = "";
    $whatIsHowNisaabText = "";

    $whatIsShouldUseTitle = "";
    $whatIsShouldUseText = "";

    $whatIsGoldTitle = "";
    $whatIsGoldText = "";

    $whatIsSilverTitle = "";
    $whatIsSilverText = "";

    $btnTitle = "";
    $btnLink = "";

    $dropdownWhatDoINeedTitle = "";
    $dropdownWhatDoINeedText = "";

    $dropdownLinkTitle = "";
    $dropdownLink = "";

    $priceSilver = "";
    $priceGold = "";

    if (isset($parameters['tab_calc_title'])) {
        $tabCalculatorTitle = $parameters['tab_calc_title'];
    }

    if (isset($parameters['tab_what_zakat_title'])) {
        $tabWhatZakatTitle = $parameters['tab_what_zakat_title'];
    }

    if (isset($parameters['w_i_zakat_title'])) {
        $whatIsZakatTitle = $parameters['w_i_zakat_title'];
    }

    if (isset($parameters['w_i_zakat_text'])) {
        $whatIsZakatText = $parameters['w_i_zakat_text'];
    }


    if (isset($parameters['w_i_obligatory_title'])) {
        $whatIsObligatoryTitle = $parameters['w_i_obligatory_title'];
    }

    if (isset($parameters['w_i_obligatory_text'])) {
        $whatIsObligatoryText = $parameters['w_i_obligatory_text'];
    }


    if (isset($parameters['w_i_donate_title'])) {
        $whatIsWhyWeDonateTitle = $parameters['w_i_donate_title'];
    }

    if (isset($parameters['w_i_donate_text'])) {
        $whatIsWhyWeDonateText = $parameters['w_i_donate_text'];
    }


    if (isset($parameters['w_i_receive_title'])) {
        $whatIsReceiveTitle = $parameters['w_i_receive_title'];
    }

    if (isset($parameters['w_i_receive_text'])) {
        $whatIsReceiveText = $parameters['w_i_receive_text'];
    }


    if (isset($parameters['w_i_calc_title'])) {
        $whatIsHowCalculatedTitle = $parameters['w_i_calc_title'];
    }

    if (isset($parameters['w_i_calc_text'])) {
        $whatIsHowCalculatedText = $parameters['w_i_calc_text'];
    }


    if (isset($parameters['w_i_nisaab_title'])) {
        $whatIsHowNisaabTitle = $parameters['w_i_nisaab_title'];
    }

    if (isset($parameters['w_i_nisaab_text'])) {
        $whatIsHowNisaabText = $parameters['w_i_nisaab_text'];
    }


    if (isset($parameters['w_i_should_title'])) {
        $whatIsShouldUseTitle = $parameters['w_i_should_title'];
    }

    if (isset($parameters['w_i_should_text'])) {
        $whatIsShouldUseText = $parameters['w_i_should_text'];
    }


    if (isset($parameters['w_i_gold_title'])) {
        $whatIsGoldTitle = $parameters['w_i_gold_title'];
    }

    if (isset($parameters['w_i_gold_text'])) {
        $whatIsGoldText = $parameters['w_i_gold_text'];
    }


    if (isset($parameters['w_i_silver_title'])) {
        $whatIsSilverTitle = $parameters['w_i_silver_title'];
    }

    if (isset($parameters['w_i_silver_text'])) {
        $whatIsSilverText = $parameters['w_i_silver_text'];
    }

    if (isset($parameters['w_i_btn_title'])) {
        $btnTitle = $parameters['w_i_btn_title'];
    }

    if (isset($parameters['w_i_btn_link'])) {
        $btnLink = $parameters['w_i_btn_link'];
    }


    if (isset($parameters['dropdown_title'])) {
        $dropdownWhatDoINeedTitle = $parameters['dropdown_title'];
    }

    if (isset($parameters['dropdown_text'])) {
        $dropdownWhatDoINeedText = $parameters['dropdown_text'];
    }

    if (isset($parameters['dropdown_link_title'])) {
        $dropdownLinkTitle = $parameters['dropdown_link_title'];
    }

    if (isset($parameters['dropdown_link'])) {
        $dropdownLink = $parameters['dropdown_link'];
    }

    if (isset($parameters['price_silver'])) {
        $priceSilver = $parameters['price_silver'];
    }

    if (isset($parameters['price_gold'])) {
        $priceGold = $parameters['price_gold'];
    }

@endphp


<section class="calculator">
    <div class="wrap">
        <div class="title">
            <div class="top">
                <div class="row align-items-center">
                    <div class="col-6">
                        <b>Your Zakat Calculator</b>
                    </div>
                    <div class="col-6 text-right">
                        <div class="toggle-title">
                            <div>WHAT DO I NEED? <i class="far fa-chevron-down"></i></div>
                            <div><i class="fal fa-times"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="line"></div>
                <div class="font-size-16"><b>WHAT DO I NEED?</b></div>
                <div class="pt-5"></div>
                <div>
                    <p>Some helper copy here; iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed consequuntur magni dolores eos qui rati voluptate sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit. Perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicab. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit quia voluptas.</p>
                </div>
                <div class="pt-5"></div>
                <div class="text-right">
                    <a href="#" class="text-underline font-size-16 text-white"><b>VISIT FAQS</b></a>
                </div>
            </div>
        </div>
        <nav class="general-content-tabs">
            <ul class="nav nav-tabs nav-fill" id="myTab">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-selected="true">{{ $tabCalculatorTitle }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tab-2-tab" data-toggle="tab" href="#tab-2" role="tab"  aria-selected="false">{{ $tabWhatZakatTitle }}</a>
                </li>
            </ul>
        </nav>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel" >
                <div class="row align-items-end gutter-5">
                    <div class="col-3"></div>
                    <div class="col-5">
                        <div class="form-group mb-0">
                            <label><b>Base value of nisab</b></label>
                            <select class="form-control" id="currency">
                                <option value="{{ $priceSilver }}">Silver</option>
                                <option value="{{ $priceGold }}">Gold</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-1"><button id="btn-currency" class="btn btn-primary h-form-control">£{{ $priceSilver }}</button></div>
                </div>
                <div class="pt-5"></div>

                <div>Enter below, your <b>total</b> assets from the past lunar year, that apply to you. </div>
                <div class="line"></div>
                <div class="text-right text-uppercase"><b>your assets</b></div>
                <div class="pt-5"></div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>value of gold</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>value of silver</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>Cash in hand / in bank accounts</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>cash deposited for future purpose</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*E.g. Saving for Hajj</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>Given out in loans</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>other investments</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*E.g. Business investments, shares, saving certificates, pensions funded by money in ones possesssion</small>
                        </div>
                    </div>
                </div>

                <div class="pt-5"></div>
                <div class="line"></div>
                <div class="text-right text-uppercase"><b>Trade goods</b></div>
                <div class="pt-5"></div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>value of stock</b></label>
                            <input type="number" class="form-control debit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>

                <div class="pt-5"></div>
                <div class="line"></div>
                <div class="text-right text-uppercase"><b>Liabilities</b></div>
                <div class="pt-5"></div>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>Borrowed money / items bought on credit</b></label>
                            <input type="number" class="form-control credit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>wages due to employees</b></label>
                            <input type="number" class="form-control credit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-5">
                        <div class="form-group">
                            <label><b>taxes / rent / utility bills due immediately</b></label>
                            <input type="number" class="form-control credit-money" placeholder="£ 0.00">
                            <small>*Some helper text right here, to assure user of correct decision making.</small>
                        </div>
                    </div>
                </div>
                <div class="pt-5"></div>

                <div class="calc">
                    <div class="line"></div>
                    <div class="pt-5"></div>
                    <div class="font-size-30 mb-4 text-center"><b>Calculate my Zakat</b></div>
                    <div class="text-center mb-5">
                        <button id="btn-reset" class="btn btn-secondary mr-1">Reset</button>
                        <button id="btn-calculate" class="btn btn-info ml-1">Calculate now</button>
                    </div>
                    <div class="item" id="total-assets">
                        <b>Total Assets</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30 money-val"><b>£0.00</b></div>
                        </div>
                    </div>
                    <div class="item" id="zakat-payable">
                        <b>Zakat Payable</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30 money-val"><b>£0.00</b></div>
                        </div>
                    </div>

                    <div class="item bg-primary-light">
                        <b>Total Assets</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30 text-info"><b>£31'030.00</b></div>
                        </div>
                    </div>
                    <div class="item bg-danger-light">
                        <b>Zakat Payable</b>
                        <div class="row align-items-center gutter-0">
                            <div class="col-6">For your lunar year</div>
                            <div class="col-6 text-right font-size-30 text-danger"><b>£775.75</b></div>
                        </div>
                    </div>
                </div>

                <div class="down bg-danger-light">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="total">
                                ZAKAT TOTAL
                                <b>£0.00</b>
                                <b class="text-danger">£755.00</b>
                            </div>
                        </div>
                        <div class="col-6 text-right">
                            <a href="#" class="btn btn-danger">Danate my Zakat</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel">

                <div class="text">
                    <h2>{{ $whatIsZakatTitle }}}</h2>
                    <p>{!! $whatIsZakatText !!}</p>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsObligatoryTitle }}</h2>
                    <p>{!! $whatIsObligatoryText !!}</p>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsWhyWeDonateTitle }}</h2>
                    <p>{!! $whatIsWhyWeDonateText !!}</p>
                    <div class="pt-5"></div>

                    <div class="blockquote">
                        <i>"Quote example perspiciais und omnis iste natus error sit voluptatem accusantium doloremque laudantium."</i>
                        <div>QUOTE REFERENCE</div>
                    </div>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsReceiveTitle }}</h2>
                    <p>{!! $whatIsReceiveText !!}</p>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsHowCalculatedTitle }}</h2>
                    <p>{!! $whatIsHowCalculatedText !!}</p>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsHowNisaabTitle }}</h2>
                    <p>{!! $whatIsHowNisaabText !!}</p>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsShouldUseTitle }}</h2>
                    <p>{!! $whatIsShouldUseText !!}</p>
                    <div class="pt-5"></div>
                </div>

                <div class="bg-primary-light p-5 mb-2 br-5">
                    <p class="font-size-20"><b>{{ $whatIsGoldTitle }}</b></p>
                    <div class="line"></div>
                    <p class="font-size-16">{!! $whatIsGoldText !!}</p>
                </div>

                <div class="bg-primary-light p-5 mb-2 br-5">
                    <p class="font-size-20"><b>{{ $whatIsSilverTitle }}</b></p>
                    <div class="line"></div>
                    <p class="font-size-16">{{ $whatIsSilverText }}</p>
                </div>

                <div class="pt-5"></div>
                <div class="text-center">
                    <a href="{{ $btnLink }}" class="btn btn-info">{{ $btnTitle }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
