<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * 権限チェック（基本 true でOK）
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name'  => ['required', 'string'],
            'gender'     => ['required', 'in:男性,女性,その他'],
            'email'      => ['required', 'email'],
            'tel1'       => ['required', 'numeric'],
            'tel2'       => ['required', 'numeric'],
            'tel3'       => ['required', 'numeric'],
            'address'    => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'], // categoriesテーブルに存在するIDかチェック
            'detail'    => ['required', 'string', 'max:120'], // お問い合わせ内容
        ]; 
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 未入力チェック
            if (empty($this->tel1) || empty($this->tel2) || empty($this->tel3)) {
                $validator->errors()->add('tel', '電話番号を入力してください');
            }

            // 数字チェック
            if (
                (!empty($this->tel1) && !ctype_digit($this->tel1)) ||
                (!empty($this->tel2) && !ctype_digit($this->tel2)) ||
                (!empty($this->tel3) && !ctype_digit($this->tel3))
            ) {
                $validator->errors()->add('tel', '電話番号を入力してください');
            }
        });
    }

    /**
     * エラーメッセージ
     */
    public function messages(): array
    {
        return [
            'first_name.required' => '姓を入力してください',
            'last_name.required'  => '名を入力してください',
            'gender.required'     => '性別を選択してください',
            'gender.in'           => '性別を選択してください',
            'email.required'      => 'メールアドレスを入力してください',
            'email.email'         => 'メールアドレスはメール形式で入力してください',
            'address.required'    => '住所を入力してください',
            'category_id.required'     => 'お問い合わせの種類を選択してください',
            'detail.required'    => 'お問い合わせ内容を入力してください',
            'detail.max'         => 'お問合せ内容は120文字以内で入力してください',
        ];
    }
}
