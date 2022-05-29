<?php

namespace App\Http\Requests\Study;

use App\Enums\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Additional validation rules
     *
     * @param $validator
     *
     * @return void
     */
    public function withValidator($validator): void
    {
        $validator->after(
            function ($validator) {
                $count = $this->route('study')->users()->whereNotIn('users.id', [$this->route('user')->id])
                                                       ->whereIn('role_id', [RoleEnum::SUPERUSER, RoleEnum::CLIENT])
                                                       ->count();
                if ($count == 0) {
                    $validator->errors()->add(
                        'id',
                        __('global.you_cant_remove_the_only_admin_in_this_study')
                    );
                }
            }
        );
    }
}
