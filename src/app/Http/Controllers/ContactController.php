<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        if ($request->query()) {
            $request->flash(); // old() に反映
    }

    return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'gender', 'email', 'address', 'building',  'content',
            'first_name','last_name','tel1','tel2','tel3','detail'
        ]);

        $contact['name'] = $request->input('first_name') . ' ' . $request->input('last_name');
        $contact['tel'] = $request->input('tel1') . '-' .
                        $request->input('tel2') . '-' .
                        $request->input('tel3');

        // category名を追加
        if ($request->filled('category_id')) {
        $contact['category_id'] = $request->input('category_id'); // ← 追加
        $contact['category_name'] = Category::find($request->input('category_id'))->content ?? '';
        }

        return view('confirm', compact('contact'));
    }

    public function store(ContactRequest $request)
    {
        // gender を数値に変換
        $genderMap = [
            '男性' => 1,
            '女性' => 2,
            'その他' => 3,
        ];
        
        $genderValue = $genderMap[$request->input('gender')] ?? null;

        // contact を保存（category_id を紐づけ）
        Contact::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'gender'     => $genderValue,
            'email'      => $request->input('email'),
            'tel'        => $request->input('tel'),
            'address'    => $request->input('address'),
            'building'   => $request->input('building'),
            'category_id' => $request->input('category_id'), // ← categoriesテーブルと紐付け
            'detail'      => $request->input('detail'),     // ← ユーザーの入力内容
        ]);

        return view('thanks');
    }
}
