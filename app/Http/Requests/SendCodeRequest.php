<?php

namespace App\Http\Requests;

class SendCodeRequest extends BaseFormRequest
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
            'mobile-number' => 'bail|required|numeric|min:11|phone:IR,mobile',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
//            'mobile-number.*' => __("validation.mobileInvalid"),
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
//            'hash' => __("word.hash"),
//            'code' => __("word.code"),
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
