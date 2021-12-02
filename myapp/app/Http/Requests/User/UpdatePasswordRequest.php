<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current-password'      => ['required', 'current_password'],
            'password'              => ['required'],
            'password-confirmation' => ['required', 'same:password'],
        ];
    }

    protected function passedValidation()
    {
        $this->replace(['password' => Hash::make($this->password)]);
        $this->offsetUnset('current-password');
        $this->offsetUnset('password-confirmation');
    }

    public function messages()
    {
        return [
            'current-password.required'         => '現在のパスワードが入力されていません。',
            'current-password.current_password' => 'パスワードが違います。',
            'password.required'                 => 'パスワードが入力されていません。',
            'password-confirmation.required'    => 'パスワードの再入力がされていません。',
            'password-confirmation.same'        => '入力したパスワードが同一ではありません。',
        ];
    }
}
