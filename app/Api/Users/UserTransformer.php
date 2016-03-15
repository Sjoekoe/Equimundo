<?php
namespace EQM\Api\Users;

use EQM\Models\Users\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id(),
            'is_admin' => $user->isAdmin(),
            'first_name' => $user->firstName(),
            'last_name' => $user->lastName(),
            'language' => $user->language(),
            'email' => $user->email(),
            'date_of_birth' => $user->dateOfBirth() ? $user->dateOfBirth()->toIso8601String() : null,
            'country' => $user->country(),
            'gender' => $user->gender(),
            'slug' => $user->slug(),
        ];
    }
}
