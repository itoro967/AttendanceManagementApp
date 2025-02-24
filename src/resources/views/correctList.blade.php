<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/correctList.css') }}">
  </x-slot:css>
  <div class="inner">
    <div>申請一覧</div>
    <div class="tab">
      @php
      $confirmed=request()->input('confirmed')
      @endphp
      <a href="?confirmed=0" @class(["tab-items","active"=>!$confirmed])>承認待ち</a>
      <a href="?confirmed=1" @class(["tab-items","active"=>$confirmed])>承認済み</a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="th state">状態</th>
          <th class="th name">名前</th>
          <th class="th target-date">対象日時</th>
          <th class="th reason">申請理由</th>
          <th class="th date">申請日時</th>
          <th class="th detail">詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $corrects as $correct)
        <tr class="tr">
          <td class="td">
            @if($correct->is_confirmed)
            承認済み
            @else
            承認待ち
            @endif</td>
          <td class="td state">{{$correct->user->name}}</td>
          <td class="td name">{{Carbon\Carbon::parse($correct->date)->format('Y/m/d')}}</td>
          <td class="td target-date">{{$correct->note}}</td>
          <td class="td date">{{$correct->created_at->format('Y/m/d')}}</td>
          <td class="td detail"><a href="/attendance/{{$correct->id}}">詳細</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-common>