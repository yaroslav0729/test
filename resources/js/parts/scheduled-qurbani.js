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
       $('[input_number_spinner_food]').on('change input', function () {
           const $qurbaniItem = $(this).closest('.qurbani-options__item')
           const $checkbox = $qurbaniItem.find('[type="checkbox"]');

           if (!$checkbox.is(':checked') && +$(this).val() > 0) {
               $checkbox.prop('checked', true);
               $qurbaniItem.addClass('active');
           }

           let emptyCounter = true;
           $qurbaniItem.find('[input_number_spinner_food]').each(function() {
               if ($(this).val() !== '0') {
                   emptyCounter = false;
                   return false;
               }
           });

           if (emptyCounter && $checkbox.is(':checked')) {
               $checkbox.prop('checked', false);
               $qurbaniItem.removeClass('active');
           }

           const itemsCount = +$(this).val();
           const campaignId = $(this).data('campaign');
           const type = $(this).data('type');
           const country = $(this).data('country');
           const price = $(this).data('price');
           const campaignName = $(this).data('campaign-name');

           let pricesCount = 0;
           let existingKeys = [];
           for (const key in prices) {
               if (prices[key].campaignId === campaignId && prices[key].type === type && prices[key].country === country) {
                   pricesCount++;
                   existingKeys.push(key);
               }
           }

           const difference = itemsCount - pricesCount;

           if (difference > 0) {
               for (let i = 0; i < difference; i++) {
                   let newIndex = 0;
                   const pricesKeys = Object.keys(prices).map(Number);
                   if (pricesKeys.length > 0) {
                       newIndex = Math.max(...pricesKeys) + 1;
                   } else {
                       newIndex = 0;
                   }

                   prices[newIndex] = {
                       amount: price,
                       campaignId: campaignId,
                       period: 10,
                       type: type,
                       country: country,
                   };
                   addQurbaniNote(newIndex, campaignName);
               }
           } else if (difference < 0) {
               const itemsToRemove = Math.abs(difference);
               existingKeys.sort((a, b) => Number(b) - Number(a));
               for (let i = 0; i < itemsToRemove; i++) {
                   if (existingKeys.length > 0) {
                       const keyToRemove = existingKeys.shift();
                       if (prices[keyToRemove]) {
                            delete prices[keyToRemove];
                            removeQurbaniNote(keyToRemove);
                       }
                   }
               }
           }

           const totalAmount = Object.values(prices).reduce((acc, item) => acc + item.amount, 0);
           $('#total-amount-value').text(totalAmount);
       });

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
