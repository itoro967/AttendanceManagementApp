<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/table-common.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/attendanceListAdmin.css') }}">
  </x-slot:css>
  <div class="inner">
    <div class="page-title">{{Carbon\Carbon::parse($date)->format('Y年m月d日')}}の勤怠</div>
    <div class="calender-box">
      <a class="arrow-button" href="?date={{ Carbon\Carbon::parse($date)->addDay(-1)->format('Y-m-d') }}">
        <img src="{{ asset('/img/arrow_back.svg') }}">
        前日
      </a>
      <span>
        <input type="date" id="calender" class="calender" value="{{$date}}">
      </span>
      <a class="arrow-button" href="?date={{ carbon\Carbon::parse($date)->addDay(1)->format('Y-m-d') }}">
        翌日
        <img src="{{ asset('/img/arrow_forward.svg') }}">
      </a>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th class="th name">名前</th>
          <th class="th">出勤</th>
          <th class="th">退勤</th>
          <th class="th">休憩</th>
          <th class="th">合計</th>
          <th class="th">詳細</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($staffs as $staff)
        @php
        $work = $works->where('user_id',$staff->id)->first()
        @endphp
        <tr @class(["tr","not_confirmed"=> !($work->is_confirmed ?? TRUE)])>
          <td class="td">{{$staff->name}}</td>
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
  calender.addEventListener('change', () => location.href = `?date=${calender.value}`)
</script>