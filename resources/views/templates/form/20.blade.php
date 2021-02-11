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

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Tab Calculate Title:</label>
            <input class="form-control" name="parameters[tab_calc_title]"
                   placeholder="Tab Calculate Title" value="{{ $tabCalculatorTitle }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Tab What is Zakat Title:</label>
            <input class="form-control" name="parameters[tab_what_zakat_title]"
                   placeholder="Tab What is Zakat Title" value="{{ $tabWhatZakatTitle }}"/>
        </div>
    </div>
</div>
<div class="col-12 mt-5"></div>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-calculate-tab" data-toggle="tab" href="#nav-calculate" role="tab"
           aria-controls="nav-calculate" aria-selected="true">Calculate my Zakat</a>
        <a class="nav-item nav-link" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab"
           aria-controls="nav-description" aria-selected="false">What is Zakat</a>
        <a class="nav-item nav-link" id="nav-dropdown-tab" data-toggle="tab" href="#nav-dropdown" role="tab"
           aria-controls="nav-dropdown" aria-selected="false">What do I need (dropdown)</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-calculate" role="tabpanel" aria-labelledby="nav-home-tab">

        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Base Value of Nisaab title:</label>
                    <input class="form-control" name="parameters[calc_base_value_nisaab_title]"
                           placeholder="Base Value of Nisaab title" value="{{ $calculateBaseValueNisaabTitle }}"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Price Silver:</label>
                    <input type="number" step=0.01 class="form-control" name="parameters[price_silver]"
                           placeholder="0.00" value="{{ $priceSilver }}"/>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Price Gold:</label>
                    <input type="number" step=0.01 class="form-control" name="parameters[price_gold]"
                           placeholder="0.00" value="{{ $priceGold }}"/>
                </div>
            </div>
            <div class="col-12 mt-lg-5">
                <div class="form-group">
                    <label>Enter below, your total assets text:</label>
                    <input class="form-control" name="parameters[calc_below_title]"
                           placeholder="Text" value="{{ $calculateBelowTitle }}"/>
                </div>
                <div class="form-group">
                    <label>Your assets section title:</label>
                    <input class="form-control" name="parameters[calc_your_assets_section_title]"
                           placeholder="Your assets section title" value="{{ $calculateYourAssetsSectionTitle }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Value of Gold title:</label>
                    <input class="form-control" name="parameters[calc_value_gold_title]"
                           placeholder="Value of Gold title" value="{{ $calculateValueOfGoldTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Value of Gold annotation:</label>
                    <input class="form-control" name="parameters[calc_value_gold_annotation]"
                           placeholder="Value of Gold annotation" value="{{ $calculateValueOfGoldAnnotation }}"/>
                </div>
            </div>
            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Value of Silver title:</label>
                    <input class="form-control" name="parameters[calc_value_silver_title]"
                           placeholder="Value of Silver title" value="{{ $calculateValueOfSilverTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Value of Silver annotation:</label>
                    <input class="form-control" name="parameters[calc_value_silver_annotation]"
                           placeholder="Value of Silver annotation" value="{{ $calculateValueOfSilverAnnotation }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Cash in hand/in bank accounts title:</label>
                    <input class="form-control" name="parameters[calc_cash_hand_title]"
                           placeholder="Cash in hand/in bank accounts title" value="{{ $calculateCashInHandTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Cash in hand/in bank accounts annotation:</label>
                    <input class="form-control" name="parameters[calc_cash_hand_annotation]"
                           placeholder="Cash in hand/in bank accounts annotation" value="{{ $calculateCashInHandAnnotation }}"/>
                </div>

            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Cash deposited for future purpose title:</label>
                    <input class="form-control" name="parameters[calc_cash_deposited_title]"
                           placeholder="Cash deposited for future purpose title" value="{{ $calculateCashDepositedTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Cash deposited for future purpose annotation:</label>
                    <input class="form-control" name="parameters[calc_cash_deposited_annotation]"
                           placeholder="Cash deposited for future purpose annotation" value="{{ $calculateCashDepositedAnnotation }}"/>
                </div>

            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Given out in loans title:</label>
                    <input class="form-control" name="parameters[calc_given_title]"
                           placeholder="Given out in loans title" value="{{ $calculateGivenTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Given out in loans annotation:</label>
                    <input class="form-control" name="parameters[calc_given_annotation]"
                           placeholder="Given out in loans annotation" value="{{ $calculateGivenAnnotation }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Other investments title:</label>
                    <input class="form-control" name="parameters[calc_other_title]"
                           placeholder="Other investments title" value="{{ $calculateOtherTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Other investments annotation:</label>
                    <input class="form-control" name="parameters[calc_other_annotation]"
                           placeholder="Other investments annotation" value="{{ $calculateOtherAnnotation }}"/>
                </div>
            </div>

            <div class="col-12 mt-lg-5">
                <div class="form-group">
                    <label>Trade goods section title:</label>
                    <input class="form-control" name="parameters[calc_trade_goods_section_title]"
                           placeholder="Trade goods section title" value="{{ $calculateTradeGoodsSectionTitle }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Value of stock title:</label>
                    <input class="form-control" name="parameters[calc_value_stock_title]"
                           placeholder="Value of stock title" value="{{ $calculateValueOfStockTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Value of stock annotation:</label>
                    <input class="form-control" name="parameters[calc_value_stock_annotation]"
                           placeholder="Value of stock annotation" value="{{ $calculateValueOfStockAnnotation }}"/>
                </div>
            </div>

            <div class="col-12 mt-lg-5">
                <div class="form-group">
                    <label>Liabilities section title:</label>
                    <input class="form-control" name="parameters[calc_liabilities_section_title]"
                           placeholder="Liabilities section title" value="{{ $calculateLiabilitiesSectionTitle }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Borrowed money / items bought on credit title:</label>
                    <input class="form-control" name="parameters[calc_borrowed_title]"
                           placeholder="Borrowed money/items bought on credit title" value="{{ $calculateBorrowedTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Borrowed money / items bought on credit annotation:</label>
                    <input class="form-control" name="parameters[calc_borrowed_annotation]"
                           placeholder="Borrowed money/items bought on credit annotation" value="{{ $calculateBorrowedAnnotation }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Wages due to employees title:</label>
                    <input class="form-control" name="parameters[calc_wages_title]"
                           placeholder="Wages due to employees title" value="{{ $calculateWagesTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Wages due to employees annotation:</label>
                    <input class="form-control" name="parameters[calc_wages_annotation]"
                           placeholder="Wages due to employees annotation" value="{{ $calculateWagesAnnotation }}"/>
                </div>
            </div>

            <div class="col-12 col-lg-6 mt-lg-3">
                <div class="form-group">
                    <label>Taxes / Rent / Utility bills due immediately title:</label>
                    <input class="form-control" name="parameters[calc_taxes_title]"
                           placeholder="Taxes/Rent/Utility bills due immediately title" value="{{ $calculateTaxesTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Taxes / Rent / Utility bills due immediately annotation:</label>
                    <input class="form-control" name="parameters[calc_taxes_annotation]"
                           placeholder="Taxes/Rent/Utility bills due immediately annotation" value="{{ $calculateTaxesAnnotation }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="nav-description" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row mt-5">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>What is Zakat title:</label>
                    <input class="form-control" name="parameters[w_i_zakat_title]"
                           placeholder="What is Zakat title" value="{{ $whatIsZakatTitle }}"/>
                </div>

                <div class="form-group">
                    <label>What is Zakat text:</label>
                    <textarea class="form-control" name="parameters[w_i_zakat_text]"
                              rows="5" placeholder="Text">{!! $whatIsZakatText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Zakat obligatory title:</label>
                    <input class="form-control" name="parameters[w_i_obligatory_title]"
                           placeholder="Zakat obligatory title" value="{{ $whatIsObligatoryTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Zakat obligatory text:</label>
                    <textarea class="form-control" name="parameters[w_i_obligatory_text]"
                              rows="5" placeholder="Zakat obligatory text">{!! $whatIsObligatoryText !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Why do we donate Zakat title:</label>
                    <input class="form-control" name="parameters[w_i_donate_title]"
                           placeholder="Why do we donate Zakat title" value="{{ $whatIsWhyWeDonateTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Why do we donate Zakat text:</label>
                    <textarea class="form-control" name="parameters[w_i_donate_text]"
                              rows="5"
                              placeholder="Why do we donate Zakat text">{!! $whatIsWhyWeDonateText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Who can receive Zakat title:</label>
                    <input class="form-control" name="parameters[w_i_receive_title]"
                           placeholder="Who can receive Zakat title" value="{{ $whatIsReceiveTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Who can receive Zakat text:</label>
                    <textarea class="form-control" name="parameters[w_i_receive_text]"
                              rows="5" placeholder="Who can receive Zakat text">{!! $whatIsReceiveText !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>How is Zakat calculated title:</label>
                    <input class="form-control" name="parameters[w_i_calc_title]"
                           placeholder="How is Zakat calculated title" value="{{ $whatIsHowCalculatedTitle }}"/>
                </div>

                <div class="form-group">
                    <label>How is Zakat calculated text:</label>
                    <textarea class="form-control" name="parameters[w_i_calc_text]"
                              rows="5"
                              placeholder="How is Zakat calculated text">{!! $whatIsHowCalculatedText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>How is Nisaab measured title:</label>
                    <input class="form-control" name="parameters[w_i_nisaab_title]"
                           placeholder="How is Nisaab measured title" value="{{ $whatIsHowNisaabTitle }}"/>
                </div>

                <div class="form-group">
                    <label>How is Nisaab measured text:</label>
                    <textarea class="form-control" name="parameters[w_i_nisaab_text]"
                              rows="5" placeholder="How is Nisaab measured text">{!! $whatIsHowNisaabText !!}</textarea>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Should I use gold/silver to calculate Nisaab title:</label>
                    <input class="form-control" name="parameters[w_i_should_title]"
                           placeholder="Title" value="{{ $whatIsShouldUseTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Should I use gold/silver to calculate Nisaab text:</label>
                    <textarea class="form-control" name="parameters[w_i_should_text]"
                              rows="5" placeholder="Text">{!! $whatIsShouldUseText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Gold title:</label>
                    <input class="form-control" name="parameters[w_i_gold_title]"
                           placeholder="Gold title" value="{{ $whatIsGoldTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Gold text:</label>
                    <textarea class="form-control" name="parameters[w_i_gold_text]"
                              rows="3" placeholder="Gold text">{!! $whatIsGoldText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Silver title:</label>
                    <input class="form-control" name="parameters[w_i_silver_title]"
                           placeholder="Silver title" value="{{ $whatIsSilverTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Silver text:</label>
                    <textarea class="form-control" name="parameters[w_i_silver_text]"
                              rows="3" placeholder="Silver text">{!! $whatIsSilverText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Calculate Zakat button Title:</label>
                    <input class="form-control" name="parameters[w_i_btn_title]"
                           placeholder="Calculate Zakat button Title" value="{{ $btnTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Calculate Zakat button link:</label>
                    <input class="form-control" name="parameters[w_i_btn_link]"
                           placeholder="Calculate Zakat button link" value="{{ $btnLink }}"/>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="nav-dropdown" role="tabpanel" aria-labelledby="nav-profile-tab">
        <div class="row mt-4">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>What do I need title:</label>
                    <input class="form-control" name="parameters[dropdown_title]"
                           placeholder="What do I need title" value="{{ $dropdownWhatDoINeedTitle }}"/>
                </div>

                <div class="form-group">
                    <label>What do I need text:</label>
                    <textarea class="form-control" name="parameters[dropdown_text]"
                              rows="7" placeholder="Text">{!! $dropdownWhatDoINeedText !!}</textarea>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label>Link title:</label>
                    <input class="form-control" name="parameters[dropdown_link_title]"
                           placeholder="Link title" value="{{ $dropdownLinkTitle }}"/>
                </div>

                <div class="form-group">
                    <label>Link:</label>
                    <input class="form-control" name="parameters[dropdown_link]"
                           placeholder="Link" value="{{ $dropdownLink }}"/>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mt-4"></div>

@include('modules.admin.projects_related', [
    'parameters' => $parameters,
])




