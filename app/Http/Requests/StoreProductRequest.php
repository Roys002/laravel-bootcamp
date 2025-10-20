<?php

// app/Http/Requests/StoreProductRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cek authorization (akan dibahas di hari 3)
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama produk wajib diisi',
            'price.min' => 'Harga tidak boleh negatif',
            'sku.unique' => 'SKU sudah digunakan produk lain',
        ];
    }

    // Custom validation
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->price > 100000000) {
                $validator->errors()->add(
                    'price', 
                    'Harga terlalu tinggi, hubungi admin'
                );
            }
        });
    }
}