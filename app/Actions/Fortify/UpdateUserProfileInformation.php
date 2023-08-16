<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            'phone' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'address_1' => ['nullable', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'post_code' => ['nullable', 'string', 'max:10'],
            'country' => ['nullable', 'string', 'max:255'],
            'birthday' => ['nullable', 'date'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'title' => $input['title'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'address_1' => $input['address_1'],
                'address_2' => $input['address_2'],
                'city' => $input['city'],
                'post_code' => $input['post_code'],
                'country' => $input['country'],
                'birthday' => $input['birthday'],
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'title' => $input['title'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'address_1' => $input['address_1'],
            'address_2' => $input['address_2'],
            'city' => $input['city'],
            'post_code' => $input['post_code'],
            'country' => $input['country'],
            'birthday' => $input['birthday'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
