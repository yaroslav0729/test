@php
    $tabCalculatorTitle = "";
       $tabWhatZakatTitle = "";

       $calculateBaseValueNisaabTitle = "";

       $calculateBelowTitle = "";
       $calculateYourAssetsSectionTitle = "";

       $calculateValueOfGoldTitle = "";
       $calculateValueOfGoldAnnotation = "";

       $calculateValueOfSilverTitle = "";
       $calculateValueOfSilverAnnotation = "";

       $calculateCashInHandTitle = "";
       $calculateCashInHandAnnotation = "";

       $calculateCashDepositedTitle = "";
       $calculateCashDepositedAnnotation = "";

       $calculateGivenTitle = "";
       $calculateGivenAnnotation = "";

       $calculateOtherTitle = "";
       $calculateOtherAnnotation = "";

       $calculateTradeGoodsSectionTitle = "";

       $calculateValueOfStockTitle = "";
       $calculateValueOfStockAnnotation = "";

       $calculateLiabilitiesSectionTitle = "";

       $calculateBorrowedTitle = "";
       $calculateBorrowedAnnotation = "";

       $calculateWagesTitle = "";
       $calculateWagesAnnotation = "";

       $calculateTaxesTitle = "";
       $calculateTaxesAnnotation = "";

       $whatIsZakatTitle = "";
       $whatIsZakatText = "";

       $whatIsObligatoryTitle = "";
       $whatIsObligatoryText = "";

       $whatIsWhyWeDonateTitle = "";
       $whatIsWhyWeDonateText = "";

       $whatIsWhenWeDonateTitle = "";
       $whatIsWhenWeDonateText = "";

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

       if (isset($parameters['calc_base_value_nisaab_title'])) {
           $calculateBaseValueNisaabTitle = $parameters['calc_base_value_nisaab_title'];
       }

       if (isset($parameters['calc_below_title'])) {
           $calculateBelowTitle = $parameters['calc_below_title'];
       }

       if (isset($parameters['calc_your_assets_section_title'])) {
           $calculateYourAssetsSectionTitle = $parameters['calc_your_assets_section_title'];
       }

       if (isset($parameters['calc_value_gold_title'])) {
           $calculateValueOfGoldTitle = $parameters['calc_value_gold_title'];
       }

       if (isset($parameters['calc_value_gold_annotation'])) {
           $calculateValueOfGoldAnnotation = $parameters['calc_value_gold_annotation'];
       }

       if (isset($parameters['calc_value_silver_title'])) {
           $calculateValueOfSilverTitle = $parameters['calc_value_silver_title'];
       }

       if (isset($parameters['calc_value_silver_annotation'])) {
           $calculateValueOfSilverAnnotation = $parameters['calc_value_silver_annotation'];
       }

       if (isset($parameters['calc_cash_hand_title'])) {
           $calculateCashInHandTitle = $parameters['calc_cash_hand_title'];
       }

       if (isset($parameters['calc_cash_hand_annotation'])) {
           $calculateCashInHandAnnotation = $parameters['calc_cash_hand_annotation'];
       }

       if (isset($parameters['calc_cash_deposited_title'])) {
           $calculateCashDepositedTitle = $parameters['calc_cash_deposited_title'];
       }

       if (isset($parameters['calc_cash_deposited_annotation'])) {
           $calculateCashDepositedAnnotation = $parameters['calc_cash_deposited_annotation'];
       }

       if (isset($parameters['calc_given_title'])) {
           $calculateGivenTitle = $parameters['calc_given_title'];
       }

       if (isset($parameters['calc_given_annotation'])) {
           $calculateGivenAnnotation = $parameters['calc_given_annotation'];
       }

       if (isset($parameters['calc_other_title'])) {
           $calculateOtherTitle = $parameters['calc_other_title'];
       }

       if (isset($parameters['calc_other_annotation'])) {
           $calculateOtherAnnotation = $parameters['calc_other_annotation'];
       }

       if (isset($parameters['calc_trade_goods_section_title'])) {
           $calculateTradeGoodsSectionTitle = $parameters['calc_trade_goods_section_title'];
       }

       if (isset($parameters['calc_value_stock_title'])) {
           $calculateValueOfStockTitle = $parameters['calc_value_stock_title'];
       }

       if (isset($parameters['calc_value_stock_annotation'])) {
           $calculateValueOfStockAnnotation = $parameters['calc_value_stock_annotation'];
       }

       if (isset($parameters['calc_liabilities_section_title'])) {
           $calculateLiabilitiesSectionTitle = $parameters['calc_liabilities_section_title'];
       }

       if (isset($parameters['calc_borrowed_title'])) {
           $calculateBorrowedTitle = $parameters['calc_borrowed_title'];
       }

       if (isset($parameters['calc_borrowed_annotation'])) {
           $calculateBorrowedAnnotation = $parameters['calc_borrowed_annotation'];
       }

       if (isset($parameters['calc_wages_title'])) {
           $calculateWagesTitle = $parameters['calc_wages_title'];
       }

       if (isset($parameters['calc_wages_annotation'])) {
           $calculateWagesAnnotation = $parameters['calc_wages_annotation'];
       }

       if (isset($parameters['calc_taxes_title'])) {
           $calculateTaxesTitle = $parameters['calc_taxes_title'];
       }

       if (isset($parameters['calc_taxes_annotation'])) {
           $calculateTaxesAnnotation = $parameters['calc_taxes_annotation'];
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

       if (isset($parameters['w_i_when_donate_title'])) {
            $whatIsWhenWeDonateTitle = $parameters['w_i_when_donate_title'];
       }

        if (isset($parameters['w_i_when_donate_text'])) {
            $whatIsWhenWeDonateText = $parameters['w_i_when_donate_text'];
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

    $projects = \App\Models\Project::getAllProjects();

    $pagesShuffled = $projects->shuffle();
    $pagesSliced = $pagesShuffled->slice(0,3);


@endphp

<section class="calculator">
    <div class="wrap">
        <div class="title">
            <div class="top">
                <b>Your Zakat Calculator</b>
                <div class="toggle-title">
                    <div class="text-uppercase"><i class="far fa-chevron-down"></i>{{ $dropdownWhatDoINeedTitle }}</div>
                </div>
            </div>
            <div class="bottom">
                <div class="line"></div>
                <div class="font-size-14 mb-3 text-uppercase"><b>{{ $dropdownWhatDoINeedTitle }}</b></div>
                <div>
                    <p>{!! $dropdownWhatDoINeedText !!}</p>
                </div>
                <div class="pt-4"></div>
                <div>
                    <span class="toggle-title font-size-14 text-white">
                        <i class="far fa-chevron-up mr-2 font-size-20"></i> CLOSE</span>
                </div>
            </div>
        </div>
        <nav class="general-content-tabs">
            <ul class="nav nav-tabs nav-fill" id="myTab">
                <li class="nav-item col-6 pl-0 pr-0">
                    <a class="nav-link active letter-spacing-0" id="tab-1-tab" data-toggle="tab" href="#tab-1" role="tab"
                       aria-selected="true">Calculator</a>
                </li>
                <li class="nav-item col-6 pl-0 pr-0" role="presentation">
                    <a class="nav-link letter-spacing-0" id="tab-2-tab" data-toggle="tab" href="#tab-2" role="tab"
                       aria-selected="false">{{ $tabWhatZakatTitle }}</a>
                </li>
            </ul>
        </nav>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
                <div class="row align-items-end gutter-5 base-value">
                    <div class="col-7">
                        <div class="form-group mb-0">
                            <label><b class="letter-spacing-1">{{ $calculateBaseValueNisaabTitle }}</b></label>
                            <select class="form-control" id="currency">
                                <option value="{{ $priceSilver }}">Silver</option>
                                <option value="{{ $priceGold }}">Gold</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <button id="btn-currency" class="btn btn-primary h-form-control">£{{ $priceSilver }}</button>
                    </div>
                </div>
                <div class="pt-5"></div>

                <div class="pb-4">{!! $calculateBelowTitle !!}</div>
                <div class="black-line mb-4"></div>
                <div class="text-uppercase pl-4 pr-3 letter-spacing-1 font-size-16"><b>{{ $calculateYourAssetsSectionTitle }}</b></div>
                <div class="pt-3"></div>

                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateValueOfGoldTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateValueOfGoldAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateValueOfSilverTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateValueOfSilverAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateCashInHandTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateCashInHandAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateCashDepositedTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateCashDepositedAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateGivenTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateGivenAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateOtherTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateOtherAnnotation }}</small>
                    </div>
                </div>

                <div class="pt-4"></div>
                <div class="black-line mb-4"></div>
                <div class="text-uppercase pl-4 pr-3 letter-spacing-1 font-size-16"><b>{{ $calculateTradeGoodsSectionTitle }}</b></div>
                <div class="pt-3"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b class="letter-spacing-1">{{ $calculateValueOfStockTitle }}</b></label>
                    <input type="number" class="form-control debit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateValueOfStockAnnotation }}</small>
                    </div>
                </div>

                <div class="pt-4"></div>
                <div class="black-line mb-4"></div>
                <div class="text-uppercase pl-4 pr-3 letter-spacing-1 font-size-16"><b>{{ $calculateLiabilitiesSectionTitle }}</b></div>
                <div class="pt-3"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b>{{ $calculateBorrowedTitle }}</b></label>
                    <input type="number" class="form-control credit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateBorrowedAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b>{{ $calculateWagesTitle }}</b></label>
                    <input type="number" class="form-control credit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateWagesAnnotation }}</small>
                    </div>
                </div>
                <div class="line"></div>
                <div class="form-group pt-2 pb-2" currency="£">
                    <label><b>{{ $calculateTaxesTitle }}</b></label>
                    <input type="number" class="form-control credit-money" placeholder="0.00">
                    <div class="pl-3 text-secondary mt-2">
                        <small class="font-size-14">{{ $calculateTaxesAnnotation }}</small>
                    </div>
                </div>
                <div class="pt-4"></div>

                <div class="calc">
                    <div class="line"></div>
                    <div class="pt-5"></div>
                    <div class="font-size-25 mb-5 text-center"><b>Calculate my Zakat</b></div>
                    <div class="text-center mb-3 position-relative">
                        <button id="btn-reset" class="btn btn-secondary mr-1">Reset</button>
                        <button id="btn-calculate" class="btn btn-info ml-1">Calculate now</button>
                    </div>
                    <div class="item" id="total-assets">
                        <div><b>Total Assets</b><br>
                            For your lunar year
                        </div>
                        <div class="text-right font-size-20 money-val"><b>£0.00</b></div>
                    </div>
                    <div class="item zakat-payable" id="zakat-pay">
                        <div><b>Zakat Payable</b><br>
                            For your lunar year
                        </div>
                        <div class="text-right font-size-20 money-val"><b>£0.00</b></div>
                    </div>
                </div>

                <div class="down">
                    <div class="bg-danger-light pt-4 pb-4 pl-4 pr-4 mb-4 zakat-payable">
                        <div class="total">
                            <div>ZAKAT TOTAL</div>
                            <div class="money-val">
                                <b>£0.00</b>
                                <input name="zakat_value" type="hidden">
                            </div>
                        </div>
                    </div>
                    <div class="pl-4 pr-4">
                        <a id="btn-donate-mobile" href="#" class="btn btn-danger w-100 disabled" zakat-donate-btn>Donate
                            my Zakat<i class="moon-icons-arrow-right"></i></a>
                    </div>
                </div>
                <br>
                <br>
            </div>
            <div class="tab-pane fade" id="tab-2" role="tabpanel">

                <div class="text">
                    <h2>{{ $whatIsZakatTitle }}</h2>
                    <p>{!! $whatIsZakatText !!}</p>
                    <div class="pt-5"></div>

                    <h2>{{ $whatIsObligatoryTitle }}</h2>
                    <p>{!! $whatIsObligatoryText !!}</p>
                    <div class="pt-4"></div>

                    <h2>{{ $whatIsWhyWeDonateTitle }}</h2>
                    <p>{!! $whatIsWhyWeDonateText !!}</p>
                    <div class="pt-4"></div>

                    <h2>{{ $whatIsWhenWeDonateTitle }}</h2>
                    <p>{!! $whatIsWhenWeDonateText !!}</p>
                    <div class="pt-4"></div>

                    <h2>{{ $whatIsReceiveTitle }}</h2>
                    <p>{!! $whatIsReceiveText !!}</p>
                    <div class="pt-4"></div>

                    <h2>{{ $whatIsHowCalculatedTitle }}</h2>
                    <p>{!! $whatIsHowCalculatedText !!}</p>
                    <div class="pt-4"></div>

                    <h2>{{ $whatIsHowNisaabTitle }}</h2>
                    <p>{!! $whatIsHowNisaabText !!}</p>
                    <div class="pt-4"></div>

                    <h2>{{ $whatIsShouldUseTitle }}</h2>
                    <p>{!! $whatIsShouldUseText !!}</p>
                    <div class="pt-4"></div>
                </div>

                <div class="bg-primary-light p-5 mb-3 ml-n5 mr-n5">
                    <p class="font-size-25"><b>{{ $whatIsGoldTitle }}</b></p>
                    <p class="font-size-16">{!! $whatIsGoldText !!}
                    </p>
                </div>

                <div class="bg-primary-light p-5 ml-n5 mr-n5">
                    <p class="font-size-25"><b>{{ $whatIsSilverTitle }}</b></p>
                    <p class="font-size-16">{!! $whatIsSilverText !!}</p>
                    <br>
                </div>
                <div class="last-btn">
                    <a href="{{ $btnLink }}" class="btn btn-info">{{ $btnTitle }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.projects_related', [
    'parameters' => $parameters,
    'projects' => $pagesSliced,
])
