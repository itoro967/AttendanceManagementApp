<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/table-common.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/attendancelist.css') }}">
  </x-slot:css>
  <div class="inner">
    <div class="page-title">勤怠一覧</div>
    <div class="calender-box">
      <a class="arrow-button" href="?month={{ Carbon\Carbon::parse($month)->addMonthWithoutOverflow(-1)->format('Y-m') }}">
        <img src="{{ asset('/img/arrow_back.svg') }}">
        前月
      </a>
      <span>
        <input type="month" id="calender" class="calender" value="{{$month}}">
      </span>
      <a class="arrow-button" href="?month={{ Carbon\Carbon::parse($month)->addMonthWithoutOverflow(1)->format('Y-m') }}">
        翌月
        <img src="{{ asset('/img/arrow_forward.svg') }}">
      </a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="th">日付</th>
          <th class="th">出勤</th>
          <th class="th">退勤</th>
          <th class="th">休憩</th>
          <th class="th">合計</th>
          <th class="th">詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($periods as $period)
        @php
        $work = $works->where('date',$period->format('Y-m-d'))->first()
        @endphp
        <tr @class(["tr","not_confirmed"=> !($work->is_confirmed ?? TRUE)])>
          <td class="td">{{ Carbon\Carbon::parse($period)->isoFormat('MM/DD(ddd)')}}</td>
          @isset($work)
          <td class="td">{{ Carbon\Carbon::parse($work->begin_at)->format('H:i') }}</td>
          <td class="td">{{ Carbon\Carbon::parse($work->finish_at)->format('H:i') }}</td>
          <td class="td">{{ Carbon\Carbon::parse($work->getRestSum())->format('H:i') }}</td>
          <td class="td">{{ Carbon\Carbon::parse($work->getWorkTime()+$work->getRestSum())->format('H:i') }}</td>
          <td class="td td--bold"><a href="{{ route('detail',['id'=>$work->id]) }}">詳細</a></td>
          @endisset
          @empty($work)
          <td class="td">--:--</td>
          <td class="td">--:--</td>
          <td class="td">--:--</td>
          <td class="td">--:--</td>
          <td class="td td--bold"><a href="#">詳細</a></td>
          @endempty
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-common>
<script>
  let calender = document.getElementById('calender');
  calender.addEventListener('input', () => location.href = `?month=${calender.value}`)
</script>