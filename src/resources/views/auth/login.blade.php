<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/auth-common.css') }}">
  </x-slot:css>

  <form action="/login" class="login-form" method="post">
    @csrf
    <h1 class="page__title">ログイン</h1>

    <label for="mail" class="entry__name">メールアドレス</label>
    <x-alert :message="$errors->first('email')" />
    <input name="email" id="mail" type="email" class="input" value="{{ old('email') }}">

    <label for="password" class="entry__name">パスワード</label>
    <x-alert :message="$errors->first('password')" />
    <input name="password" id="password" type="password" class="input">

    <button class="login-button">ログインする</button>
    <a href="/register" class="link">会員登録はこちら</a>
  </form>
</x-common>