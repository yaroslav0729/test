import { refreshCardAddHtml, number_format } from './cart';

$(function () {
    const widgetBtn = document.querySelector('.foodpack-qurbani-widget');
    const foodpackQurbaniModal = document.querySelector('.modal--foodpack-qurbani');
    const modalBody = document.querySelector('.modal--foodpack-qurbani__content');
    const itemsContainer = document.querySelector('.modal--foodpack-qurbani__items');
    const btnCloseModal = document.querySelector('.modal--foodpack-qurbani__close');
    const foodpackQurbaniForm = document.querySelector('.modal--foodpack-qurbani__form');
    const submitBtn = document.querySelector('.modal--foodpack-qurbani__btn');
    const modalTabsContainer = document.querySelector('.modal--foodpack-qurbani__tabs_container');
    const modalTabsBody = document.querySelector('.modal--foodpack-qurbani__tabs_body');
    const btnSpinner = `<div class="spinner-border" role="status">
    <span class="sr-only">Loading...</span>
    </div>`;
    let total;


    checkRoute();

    async function checkRoute() {
        const routePath = window.location.pathname;
        await $.ajax({
            url: `/foodpack/qurbani/show?page_url=${routePath}`,
            type: 'GET',
            processData: true,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (!response.show) return;
                getItemsList();
            },
        });
    }

    async function getItemsList() {
        await $.ajax({
            url: '/foodpack/qurbani/price',
            type: 'GET',
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (!response.length) return;
                widgetBtn.style.display = 'flex';
                renderItemsList(response);
                if(!sessionStorage.getItem('foodpackQurbaniModalFirstTimeOpened')) {
                    foodpackQurbaniModal.classList.add('open');
                    sessionStorage.setItem('foodpackQurbaniModalFirstTimeOpened', "1");
                }
            },
        });
    }

    function renderItemsList(items) {

        const groups = items.reduce((groups, item) => {
            const group = (groups[item.price] || []);
            group.push(item);
            groups[item.price] = group;
            return groups;
        }, {});

        let tabs = '';
        let tabsContent = '';
        for (const [key, value] of Object.entries(groups)) {
            let content = '<div class="qurbani-row">';

            let firstItem = value.find(e => !!e);

            content += `
            <div class="col-12 qurbani-row mb-2">
                <div class="col-md-4">
                </div>
                <div class="col-md-4 col-6 text-center">
                    <img class="modal--foodpack-qurbani__image mx-auto d-block" src="https://islamichelp.org.uk/storage/cow.png">
                    <p class="mt-2">1/7 cow share</p>
                </div>
                <div class="col-md-4 col-6 text-center">
                    <img class="modal--foodpack-qurbani__image mx-auto d-block" src="https://islamichelp.org.uk/storage/goat.png">
                    <p class="mt-2">goat</p>
                </div>
            </div>
            `;

            let listHtml = value.map(item => {
                let id = item.id;
                let html = `
                <div class="col-12 mt-4 row modal-foodpack-qurbani__item align-middle">
                    <div class="col-md-4 col-12 text-xs-center top-0-xs xs-align-center" style="top: 30%">
                    <label class="align-middle" style="display: table-cell;">
                        <input type="checkbox" name="countries[]" value="${id}">
                        <i class="fas fa-check-circle"></i>
                        <span class="modal--foodpack-qurbani__name">${item.country.name}</span>
                    </label>
                    </div><div class="qurbani-row col-md-8 col-12">`;



                let htmlItems = item.types.map(item => {
                    if (item.pivot.price > 0) {
                        return `<div class="col-md-6 col-6 text-center">
                        <span class="modal--foodpack-qurbani__price">£${item.pivot.price}</span>

                        <div class="modal--foodpack-qurbani__number"><input type="number" input_number_spinner_food
                                data-id="${id}" value="0" data-type-id="${item.id}" data-price="${item.pivot.price}"
                                min="0" max="1000" step="1" class="color-danger" /></div>
                    </div>`
                    }else {
                        return  `<div class="col-md-6 col-6 text-center"></div>`;
                    }
                })

                html += htmlItems.join('') + '</div></div>';

                return html;
            });
            content += listHtml.join('') + '</div>';
            tabsContent += content;
        }


        modalTabsContainer.innerHTML = tabs;
        modalTabsBody.innerHTML = tabsContent;

        $(".modal--foodpack-qurbani__number [input_number_spinner_food]").inputSpinner();

        foodpackQurbaniForm.querySelectorAll('[input_number_spinner_food]').forEach(item => {
            item.addEventListener("change", function (event) {
                let checkbox = event.target.closest(".modal-foodpack-qurbani__item").querySelector('[type="checkbox"]');
                if(!checkbox.checked) {
                    checkbox.click();
                }
            })
        });
    }

    if (widgetBtn) {
        widgetBtn.addEventListener('click', onShowfoodpackQurbaniModal);
        btnCloseModal.addEventListener('click', onHidefoodpackQurbaniModal);
        foodpackQurbaniForm.addEventListener('submit', onSubmitForm);
        foodpackQurbaniModal.addEventListener('click', onBackgroundClick)
    }

    function hide (elements) {
        elements = elements.length ? elements : [elements];
        for (var index = 0; index < elements.length; index++) {
            elements[index].style.display = 'none';
        }
    }

    function onShowfoodpackQurbaniModal(e) {
        e.preventDefault();
        foodpackQurbaniModal.classList.add('open');
    }

    function onHidefoodpackQurbaniModal(e) {
        e.preventDefault();
        foodpackQurbaniModal.classList.remove('open');
    }

    async function onSubmitForm(e) {
        e.preventDefault();
        await addToCart();
    }

    async function addToCart() {
        const items = [];
        foodpackQurbaniForm.querySelectorAll('input').forEach(item => {
            if (item.checked) {
                let allItems = item.closest(".modal-foodpack-qurbani__item").querySelectorAll('[input_number_spinner_food]');
                allItems.forEach(iItem => {
                    let numberOfItems = iItem.value;
                    if (numberOfItems >= 1)
                    {
                        for(let i=0; i<numberOfItems; i++) {
                            items.push({id: item.value, typeId: iItem.dataset.typeId, price: iItem.dataset.price});
                        }
                    }

                })
            }
        })


        if (!items.length) {
            toastr.error("Please, choose one or more of these countries", "Error");
            return;
        }

        submitBtn.innerHTML = btnSpinner;

        total = items.reduce((acc, cur) => {
            return acc += +cur.price;
        }, 0);
        $("#add_to_cart_popup .amount").text(number_format(total, 2, ".", ","));
        $("#add_to_cart_popup .period").text("foodpack");


        try {
            for (const item of items) {
                try {
                    const response = await sendRequest(item);
                    refreshCardAddHtml(response);
                } catch (error) {
                    toastr.error("Unknown error, please try again later", "Error");
                    throw error
                }
            }

            foodpackQurbaniForm.reset();
            foodpackQurbaniForm.querySelectorAll('[input_number_spinner_food]').forEach(item => {
                item.setValue(0);
            });
            foodpackQurbaniModal.classList.remove('open');
            window.location = '/donate#about-donation';
            $("#add_to_cart_popup").toggleClass('show-up');
            setTimeout(() => {
                $("#add_to_cart_popup").toggleClass('show-up');
                $("#add_to_cart_popup").toggleClass('show-out');
            }, 5000)
        }
        finally {
            submitBtn.innerHTML = 'Add to cart';
        }
    }

    async function sendRequest(item) {
        let formData = new FormData();
        formData.append('food_pack_qurbani_id', item.id);
        formData.append('food_pack_qurbani_type_id', item.typeId);
        formData.append('amount', item.price);

        return await $.ajax({
            url: '/cart/add',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
        });
    }

    function onBackgroundClick(e) {
        if (!e.target.closest('.modal--foodpack-qurbani__content')) {
            foodpackQurbaniModal.classList.remove('open');
        }
    }
})
