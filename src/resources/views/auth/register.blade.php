<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/auth-common.css') }}">
  </x-slot:css>

  <form action="/register" class="register-form" method="post">
    @csrf
    <h1 class="page__title">会員登録</h1>
    <label for="name" class="entry__name">ユーザ名</label>
    <input name="name" id="name" type="text" class="input" value="{{ old('name') }}">

    <label for="mail" class="entry__name">メールアドレス</label>
    <input name="email" id="mail" type="email" class="input" value="{{ old('email') }}">

    <label for="password" class="entry__name">パスワード</label>
    <input name="password" id="password" type="password" class="input">

    <label for="password_confirm" class="entry__name">確認用パスワード</label>
    <input name="password_confirmation" id="password_confirm" type="password" class="input">
    <button class="register-button">登録する</button>
    <a href="/login" class="link">ログインはこちら</a>
  </form>
</x-common>