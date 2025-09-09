@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
<div class="admin__wrapper">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>

    <div class="admin__box">
        <div class="admin__search">
            <form action="{{ route('admin.contacts.index') }}" method="GET">
                <!-- 検索バー -->
                <input class="admin__search-bar" 
                    type="text" 
                    name="keyword" 
                    placeholder="名前やメールアドレスを入力してください"
                    value="{{ request('keyword') }}">

                <!-- 性別 絞り込み -->
                <div class="select-wrapper gender">
                    <select name="gender">
                        <option value="" hidden>性別</option>
                        <option value="">全て</option>
                        <option value="1" {{ request('gender') == 1 ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender') == 2 ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender') == 3 ? 'selected' : '' }}>その他</option>
                    </select>
                </div>

                <!-- お問い合わせの種類 -->
                <div class="select-wrapper category">
                    <select name="category_id">
                        <option value="" hidden>お問い合わせの種類</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->content }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 日付 -->
                <div class="select-wrapper date">
                    <input class="admin__search-date" 
                        type="date" 
                        name="created_at" 
                        value="{{ request('created_at') }}">
                </div>

                <button type="submit">検索</button>
                <a href="{{ route('admin.contacts.index') }}" class="admin__search--reset-button">リセット</a>
            </form>
        </div>

        <div class="admin__nav">
            <!-- 「エクスポート」ボタンのクリックでデータをCSV形式でエクスポート
                また、検索を絞り込んだ状態で「エクスポート」ボタンを押すと絞り込んだ分でエクスポート -->
            <form action="{{ route('admin.contacts.export') }}" method="GET">
                <!-- 検索条件を隠しフィールドで送る -->
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                <input type="hidden" name="created_at" value="{{ request('created_at') }}">
                <button type="submit" class="admin__nav-export">エクスポート</button>
            </form>

            <div class="pagination">
            @include('vendor.pagination.number-only', ['contacts' => $contacts])
            </div>
        </div>
    </div>
    <div class="admin-table">
        <table class="admin-table__inner">
            
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
                <th class="admin-table__header"></th>
            </tr>

            @foreach($contacts as $contact)
            <tr class="admin-table__row">
                <td class="admin-table__text">{{ $contact->first_name }} {{ $contact->last_name }}</td>
                <td class="admin-table__text">{{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}</td>
                <td class="admin-table__text">{{ $contact->email }}</td>
                <td class="admin-table__text">{{ $contact->category->content }}</td>
                <td class="admin-table__text">
                    <a href="#modal-{{ $contact->id }}" class="form__button-modify">詳細</a>
                </td>
            </tr>
            @endforeach

            @foreach($contacts as $contact)
            <div id="modal-{{ $contact->id }}" class="modal">
                <div class="modal__content">
                    <a href="#" class="modal__close">&times;</a>

                    <div class="modal__info">
                        <p><strong>お名前</strong> <span>{{ $contact->first_name }} {{ $contact->last_name }}</span></p>
                        <p><strong>性別</strong> <span>{{ $contact->gender == 1 ? '男性' : ($contact->gender == 2 ? '女性' : 'その他') }}</span></p>
                        <p><strong>メールアドレス</strong> <span>{{ $contact->email }}</span></p>
                        <p><strong>電話番号</strong> <span>{{ $contact->tel }}</span></p>
                        <p><strong>住所</strong> <span>{{ $contact->address }}</span></p>
                        <p><strong>建物名</strong> <span>{{ $contact->building }}</span></p>
                        <p><strong>お問い合わせの種類</strong> <span>{{ $contact->category->content }}</span></p>
                        <p><strong>お問い合わせ内容</strong> <span>{{ $contact->detail }}</span></p>
                    </div>

                    <div class="delete-wrapper">
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">削除</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </table>
    </div>
</div>
@endsection
