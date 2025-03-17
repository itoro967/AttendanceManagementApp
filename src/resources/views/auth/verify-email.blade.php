<x-common>
    <x-slot:css>
        <link rel="stylesheet" href="{{ asset('/css/auth-common.css') }}">
    </x-slot:css>
    <div class="inner">
    <form action="/email/verification-notification" class="login-form" method="post">
        @csrf
        <h1 class="page-title">メール認証</h1>
        <p class="message">確認メールを送信しました。</p>
        <button class="login-button">確認メールを再送信する</button>
    </form>
    </div>
</x-common>
<style>
    .message {
        margin: 20px;
    }