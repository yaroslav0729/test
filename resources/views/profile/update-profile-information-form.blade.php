<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span class="block rounded-full w-20 h-20"
                        x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="last_name" value="{{ __('Last name') }}" />
            <x-jet-input id="last_name" type="text" class="mt-1 block w-full" wire:model.defer="state.last_name"
                autocomplete="last_name" />
            <x-jet-input-error for="last_name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="phone" value="{{ __('Phone') }}" />
            <x-jet-input id="phone" type="text" class="mt-1 block w-full" wire:model.defer="state.phone" />
            <x-jet-input-error for="phone" class="mt-2" />
        </div>

        @php
            $title = $this->user->title;
        @endphp
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="title" value="{{ __('Title') }}" />
            <select name="title" class="form-control" wire:model.defer="state.title">
                <option value="Mr" @if ($title === 'Mr') selected @endif>
                    Mr</option>
                <option value="Mrs" @if ($title === 'Mrs') selected @endif>Mrs</option>
                <option value="Miss" @if ($title === 'Miss') selected @endif>Miss</option>
                <option value="Dr" @if ($title === 'Dr') selected @endif>
                    Dr</option>
            </select>
            <x-jet-input-error for="title" class="mt-2" />
        </div>

        <!-- Birthday -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="birthday" value="{{ __('Birthday') }}" />
            <x-jet-input id="birthday" type="date" class="mt-1 block w-full" wire:model.defer="state.birthday" />
            <x-jet-input-error for="birthday" class="mt-2" />
        </div>

        <h3 class="pt-3 pb-3">Address fields:</h3>

        <!-- Address 1 -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address_1" value="{{ __('Address 1') }}" />
            <x-jet-input id="address_1" type="text" class="mt-1 block w-full" wire:model.defer="state.address_1" />
            <x-jet-input-error for="address_1" class="mt-2" />
        </div>

        <!-- Address 2 -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address_2" value="{{ __('Address 2') }}" />
            <x-jet-input id="address_2" type="text" class="mt-1 block w-full" wire:model.defer="state.address_2" />
            <x-jet-input-error for="address_2" class="mt-2" />
        </div>

        <!-- Town, City-->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="city" value="{{ __('Town, City') }}" />
            <x-jet-input id="city" type="text" class="mt-1 block w-full" wire:model.defer="state.city" />
            <x-jet-input-error for="city" class="mt-2" />
        </div>

        <!-- Postcode-->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="post_code" value="{{ __('Post code') }}" />
            <x-jet-input id="post_code" type="text" class="mt-1 block w-full" wire:model.defer="state.post_code" />
            <x-jet-input-error for="post_code" class="mt-2" />
        </div>

        <!-- Postcode-->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="country" value="{{ __('Country') }}" />
            <x-jet-input id="country" type="text" class="mt-1 block w-full" wire:model.defer="state.country" />
            <x-jet-input-error for="country" class="mt-2" />
        </div>

    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
