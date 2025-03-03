<div>
    <header class="header">
        <img src="{{ asset('img/logo.svg') }}" alt="">
        <!-- 一般ユーザー -->
        @auth
        @if (!Auth::user()->is_admin && !in_array(Route::currentRouteName(), ['register', 'login']))
        <div class="header__button">
            <a href="{{ route('staff.attendance') }}" class="work-button header-button">勤怠</a>
            <a href="{{ route('staff.attendanceList') }}" class="work-list-button header-button">勤怠一覧</a>
            <a href="{{ route('correctList') }}" class="correct-button header-button">申請一覧</a>
            <form action="/logout" class="logout" method="post">
                @csrf
                <button type="submit" class="logout-button header-button">ログアウト</button>
            </form>
        </div>
        <!-- 管理者ユーザー -->
        @elseif (Auth::user()->is_admin && !in_array(Route::currentRouteName(), ['admin.login']))
        <div class="header__button">
            <a href="/admin/attendance/list" class="work-list-button header-button">勤怠一覧</a>
            <a href="/admin/staff/list" class="work-button header-button">スタッフ一覧</a>
            <a href="/stamp_correction_request/list" class="correct-button header-button">申請一覧</a>
            <form action="/logout" class="logout" method="post">
                @csrf
                <button type="submit" class="logout-button header-button">ログアウト</button>
            </form>
        </div>
        @endif
        @endauth
    </header>
</div>