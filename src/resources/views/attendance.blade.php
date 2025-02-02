<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/attendance.css') }}">
  </x-slot:css>
  <div class="inner">
    <div class="status">
      @if ($state==0)
      勤務外
      @elseif ($state==1)
      勤務中
      @elseif ($state==2)
      休憩中
      @endif
    </div>
    <div class="datetime">
      <div class="date" id="date"></div>
      <div class="time" id="time"></div>
    </div>
    <div class="button-box">
      @if ($state==0)
      <a href="?work=1" class="working-button">出勤</a>
      @elseif ($state==1)
      <a href="?work=0" class="working-button">退勤</a>
      <a href="?work=2" class="working-button breaking">休憩 入</a>
      @elseif ($state==2)
      <a href="?work=1" class="working-button breaking">休憩 戻</a>
      @endif
    </div>
  </div>
</x-common>

<script>
  function clock() {
    let week = ['日', '月', '火', '水', '木', '金', '土'];
    let nowTime = new Date();
    let year = String(nowTime.getFullYear());
    let month = String(nowTime.getMonth() + 1).padStart(2, '0');
    let date = String(nowTime.getDate()).padStart(2, '0');
    let day = week[nowTime.getDay()];
    let hours = String(nowTime.getHours()).padStart(2, '0');
    let minutes = String(nowTime.getMinutes()).padStart(2, '0');
    document.getElementById('date').innerText = `${year}年${month}月${date}日(${day})`;
    document.getElementById('time').innerText = `${hours}:${minutes}`;
  };
  clock();
  setInterval(clock, 1000);
</script>