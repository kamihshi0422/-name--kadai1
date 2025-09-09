<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FashionablyLate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">

      <div class="header-utilities">
        <a class="header__logo" href="/">   FashionablyLate</a>
      </div>
       
        @if (request()->is('register'))
        {{-- register ページのときは login --}}
        <a class="header__link-button" href="/login">login</a>
        @elseif (request()->is('login'))
        {{-- login ページのときは register --}}
        <a class="header__link-button" href="/register">register</a>
        @elseif (request()->is('admin*'))
        {{-- 管理ページ (admin配下) のときは logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
          <button type="submit" class="header__button-submit">logout</button>
        </form>
         @endif

    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>
