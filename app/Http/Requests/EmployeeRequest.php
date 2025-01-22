<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $this->employee,
            'phone' => 'required|string',
            'address' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'salary' => 'required|numeric|min:0',
        ];
    }
}
