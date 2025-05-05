$(function() {
    $('[input_number_spinner_food]').inputSpinner();
    const form = document.querySelector('#qurbani-form');

    if (!form) return;
    const campaignCategories = JSON.parse($('#donate_module_options').text());
    const formData = {
        prices: [],
        schedule: '',
        title: '',
        first_name: '',
        last_name: '',
        email: '',
        post_code: '',
        phone: '',
        address_1: '',
        city: '',
        county: '',
        country: '',
    };
    const prices = {};

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        formData.prices = [];

        for (const key in prices) {
            formData.prices.push(prices[key]);
        }

        for (const key in formData) {
            if (key === 'prices') continue;
            formData[key] = $(`[name="${key}"]`).val();
        }

        $.ajax({
            url: form.action,
            type: form.method,
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: formData,
            success: function (response) {
                if (response.payment_link) {
                    window.location.href = response.payment_link;
                }
            }
        })
    });

    qurbaniOptionsClick();
    function qurbaniOptionsClick() {
        $('.qurbani-options input[type="checkbox"]').on('change', function () {
            const $parent = $(this).closest('.qurbani-options__item');
            const $checkboxes = $parent.find('input[type="checkbox"]');

            if ($checkboxes.is(':checked')) {
                $parent.addClass('active');
            } else {
                $parent.removeClass('active');
            }
        });
       $('[input_number_spinner_food]').on('change', function () {
           const $qurbaniItem = $(this).closest('.qurbani-options__item')
           const $checkbox = $qurbaniItem.find('[type="checkbox"]');

           if (!$checkbox.is(':checked')) {
               $checkbox.click();
               $qurbaniItem.addClass('active');
           }

           let emptyCounter = true;
           $qurbaniItem.find('[input_number_spinner_food]').each(function() {
               if ($(this).val() !== '0') {
                   emptyCounter = false;
                   return false;
               }
           });

           if (emptyCounter) {
               $checkbox.click();
               $qurbaniItem.removeClass('active');
           }

           const itemsCount = +$(this).val();
           const pricesArray = [];
           for (let key in prices) {
               pricesArray.push(prices[key]);
           }
           const pricesCount = pricesArray.filter((item) => item.campaignId === $(this).data('campaign') && item.type === $(this).data('type') && item.country === $(this).data('country')).length;
           const pricesKeys = Object.keys(prices);
           const lastPricesIndex = pricesKeys.length > 0 ? pricesKeys[pricesKeys.length - 1] : 0;

           if (pricesCount < itemsCount) {
               const newIndex = lastPricesIndex === 0 ? +lastPricesIndex : +lastPricesIndex + 1;
               prices[newIndex] = {
                   amount: $(this).data('price'),
                   campaignId: $(this).data('campaign'),
                //    campaignCategory: campaignCategories[$(this).data('campaign')].categories[0],
                   period: 10,
                   type: $(this).data('type'),
                   country: $(this).data('country'),
               }

               addQurbaniNote(newIndex, $(this).data('campaign-name'));
           } else if (pricesCount > itemsCount) {
               let lastIndexWithPrice = 0;
               const reversedKeys = pricesKeys.reverse();
               for (let key of reversedKeys) {
                   if (prices[key].campaignId === $(this).data('campaign')) {
                       lastIndexWithPrice = key;
                       delete prices[lastIndexWithPrice];
                       removeQurbaniNote(lastIndexWithPrice);
                       break;
                   }
               }
           }
       })

    }

    function addQurbaniNote(amountId, campaignName) {
        const notesBlock = document.querySelector('#donation-notes');
        const noteNode = notesBlock.querySelector(`.form-group[data-amount_id="${amountId}"]`);

        if (noteNode) {
            return;
        }

        const formGroup = document.createElement('div');
        const label = document.createElement('label');
        const input = document.createElement('input');

        formGroup.classList.add('form-group');
        formGroup.dataset.amount_id = amountId;
        label.innerText = 'Name for ' + campaignName;
        input.classList.add('form-control');
        input.name = 'notes_' + amountId;
        input.required = true;
        formGroup.appendChild(label);
        formGroup.appendChild(input);
        notesBlock.appendChild(formGroup);
        input.addEventListener('input', (e) => onNameInput(event, amountId));
        $('#qurbani-names').removeClass('d-none');
    }

    function removeQurbaniNote(amountId) {
        const notesBlock = document.querySelector('#donation-notes');
        const noteNode = notesBlock.querySelector(`.form-group[data-amount_id="${amountId}"]`);

        if (noteNode) {
            noteNode.remove();
        }
        if (Object.keys(prices).length === 0) {
            $('#qurbani-names').addClass('d-none');
        }
    }

    function onNameInput(event, amountId) {
        prices[amountId].name = event.target.value;
    }

    $('.schedule-option').on('click', function (event) {
        $('.schedule-option').removeClass('active');
        $(this).addClass('active');
        $('#frequency').val($(this).data('timestamp'));
    })

    $('.collapse').collapse({
        toggle: false,
    });

    $('.qurbani-country').on('click', function () {
        const $parent = $(this).closest('.qurbani-options__item');
        console.log($parent);
        const $collapse = $parent.find('.collapse');
        $collapse.collapse('toggle');
    });
})
