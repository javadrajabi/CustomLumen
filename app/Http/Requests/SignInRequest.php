<?php

namespace App\Http\Requests;

class SignInRequest extends BaseFormRequest
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
            'mobile-number' => 'bail|required|numeric|min:11|phone:IR,mobile',
            'hash' => 'bail|required|string|min:10|max:10',
            'code' => 'bail|required|digits:4'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
//            'mobile-number' => __("mobile"),
//            'hash' => __("hash"),
//            'code' => __("code"),
        ];
    }

    public function messages(): array
    {
        return [
//            'mobile-number.*' => __("validation.attribute"),
//            'hash.*' => __("validation.attribute"),
//            'code.*' => __("validation.attribute"),
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            'mobile-number' => 'trim|persian_to_latin',
        ];
    }
//    /**
//     *  Custom filters to be applied to the input.
//     *
//     * @return array
//     */
//    public function customFilters() :array
//    {
//        return [
//            'en_num' => RemoveStringsFilter::class,
//        ];
//    }

}
