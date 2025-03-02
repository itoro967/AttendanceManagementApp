<div>
    <header class="header">
        <img src="{{ asset('img/logo.svg') }}" alt="">
        <!-- 一般ユーザー -->
        @if (!Str::startsWith(Route::currentRouteName(), 'admin.') && !in_array(Route::currentRouteName(), ['register', 'login', 'loginAdmin']))
        <div class="header__button">
            <a href="/attendance" class="work-button header-button">勤怠</a>
            <a href="/attendance/list" class="work-list-button header-button">勤怠一覧</a>
            <a href="/stamp_correction_request/list" class="correct-button header-button">申請</a>
            <form action="/logout" class="logout" method="post">
                @csrf
                <button type="submit" class="logout-button header-button">ログアウト</button>
            </form>
        </div>
        <!-- 管理者ユーザー -->
        @elseif (Str::startsWith(Route::currentRouteName(), 'admin.') && !in_array(Route::currentRouteName(), ['admin.loginAdmin']))
        <div class="header__button">
            <a href="/admin/attendance/list" class="work-list-button header-button">勤怠一覧</a>
            <a href="" class="work-button header-button">スタッフ一覧</a>
            <a href="/stamp_correction_request/list" class="correct-button header-button">申請一覧</a>
            <form action="/logout" class="logout" method="post">
                @csrf
                <button type="submit" class="logout-button header-button">ログアウト</button>
            </form>
        </div>
        @endif
    </header>
</div>