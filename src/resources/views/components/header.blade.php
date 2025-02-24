<div>
    <header class="header"><img src="{{asset('img/logo.svg')}}" alt="">
        @if( !in_array(Route::currentRouteName(), ['register','login']))
        <div class="header__button">
            <a href="/attendance" class="work-button header-button">勤怠</a>
            <a href="/attendance/list" class="work-list-button header-button">勤怠一覧</a>
            <a href="/stamp_correction_request/list" class="correct-button header-button">申請</a>
            <form action="/logout" class="logout" method="post">
                @csrf
                <button type="submit" class="logout-button header-button">ログアウト</button>
            </form>
        </div>
        @endif
    </header>
</div>