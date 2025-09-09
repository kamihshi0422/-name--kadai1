<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

use App\Models\Contact;
use App\Models\Category;
use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('auth.login'); // resources/views/auth/login.blade.php
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) { //ログイン認証
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'email' => 'メールアドレスまたはパスワードが正しくありません。',
    ])->onlyInput('email');
    }

     // ログアウト処理
    public function logout(Request $request)
    {
        Auth::logout(); //ログアウト
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login'); // ログアウト後、ログイン画面へ
    }

     // 会員登録フォーム表示
    public function showRegisterForm()
    {
        return view('auth.register'); // resources/views/auth/register.blade.php
    }

    // 会員登録処理
    public function register(RegisterRequest $request)
    {
        // バリデーション済みデータを取得
        $data = $request->validated();

        // ユーザー作成
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 登録後ログイン
        Auth::login($user);

        // 管理画面やトップページへリダイレクト
        return redirect('/admin');
        }

    // 管理画面処理
    public function index(Request $request)
    {
        // カテゴリ一覧を取得（検索用セレクトに表示）
        $categories = Category::all();

        // クエリビルダー開始
        $query = Contact::with('category');

        // キーワード検索（姓・名・フルネーム）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%")
                  ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$keyword}%")
                  // メールアドレス検索（部分一致）
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        // 性別絞り込み
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // カテゴリ絞り込み
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 日付絞り込み
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        // ページネーション（7件ずつ）
        $contacts = $query->paginate(7)->appends($request->all());

        return view('admin', compact('contacts', 'categories'));
    }

    // CSVエクスポート用メソッド
    public function export(Request $request)
    {
        $query = Contact::with('category');

        // 検索条件を再適用（キーワード、性別、カテゴリ、日付）
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%")
                  ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$keyword}%");
            });
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        $contacts = $query->get();

        // CSV出力（Laravel-Excel やシンプルな方法）
        $filename = 'contacts_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function() use ($contacts) {
            $handle = fopen('php://output', 'w');
            // ヘッダー行
            fputcsv($handle, ['姓', '名', '性別', 'メール', 'カテゴリ', '作成日']);
            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->first_name,
                    $contact->last_name,
                    $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他'),
                    $contact->email,
                    $contact->category->content ?? '',
                    $contact->created_at,
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'お問い合わせを削除しました');
    }
}
