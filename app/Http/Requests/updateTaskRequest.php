<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class updateTaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'assigned_by' => [
                'required',
                'exists:users,id',
                function ($attribute , $value , $fail){
                    if (!User::findOrFail($value)->hasRole('admin')){
                        $fail('not valid admin name');
                    }
                },
            ],
            'assigned_to' => [
                'required',
                'exists:users,id',
                function ($attribute , $value , $fail){
                    if (!User::findOrFail($value)->hasRole('user')){
                        $fail('not valid user name');
                    }
                },
            ],
            'description' => 'nullable',
        ];
    }
}
