<?php
declare(strict_types=1);

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'post'  => 'required',
        ];
    }

    public function message(): array
    {
        return [
            'title.required' => '入力必須です。',
            'post.required'  => '入力必須です。',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge(['post' => clean($this->post)]);
    }
}
