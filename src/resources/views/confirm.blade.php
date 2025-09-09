@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="confirm__content">
    <div class="confirm__heading">
        <h2>Confirm</h2>
    </div>

    <div class="confirm-table">
        <table class="confirm-table__inner">
            <tr class="confirm-table__row">
                <th class="confirm-table__header">お名前</th>
                <td class="confirm-table__text">{{ $contact['name'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">性別</th>
                <td class="confirm-table__text">{{ $contact['gender'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">メールアドレス</th>
                <td class="confirm-table__text">{{ $contact['email'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">電話番号</th>
                <td class="confirm-table__text">{{ $contact['tel'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">住所</th>
                <td class="confirm-table__text">{{ $contact['address'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">建物名</th>
                <td class="confirm-table__text">{{ $contact['building'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせの種類</th>
                <td class="confirm-table__text">{{ $contact['category_name'] }}</td>
            </tr>

            <tr class="confirm-table__row">
                <th class="confirm-table__header">お問い合わせ内容</th>
                <td class="confirm-table__text">{{ $contact['detail'] }}</td>
            </tr>
        </table>
    </div>

    <div class="form__button">
        <!-- 送信ボタン -->
        <form action="{{ url('/thanks') }}" method="post">
            @csrf
            @foreach ($contact as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <button type="submit" class="form__button-submit">送信</button>
        </form>

        <!-- 修正ボタン -->
        <form action="{{ route('contact.index') }}" method="get">
          @csrf
          @foreach ($contact as $key => $value)
            @if($key === 'category_name')
                {{-- category_name は送らない --}}
                @continue
            @endif
          <input type="hidden" name="{{ $key }}" value="{{ $value }}">
          @endforeach
          <button type="submit" class="form__button-submit--link">修正</button>
        </form>
    </div>
</div>
@endsection
