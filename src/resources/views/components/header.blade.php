<div>
    <header class="header"><img src="{{asset('img/logo.svg')}}" alt="">
        @if( !in_array(Route::currentRouteName(), ['register']))
        <div class="header__button">
            <a href="" class="work-button header-button">勤怠</a>
            <a href="" class="work-list-button header-button">勤怠一覧</a>
            <a href="" class="correct-button header-button">申請</a>
            <a href="" class="logout-button header-button">ログアウト</a>
        </div>
        @endif
    </header>
</div>