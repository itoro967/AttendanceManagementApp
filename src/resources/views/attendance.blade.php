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
      @elseif ($state==9)
      退勤済
      @endif
    </div>
    <div class="datetime">
      <div class="date" id="date"></div>
      <div class="time" id="time"></div>
    </div>
    <div class="button-box">
      <form action="punch" method="post">
        @csrf
        @if ($state==0)
        <button name="punch" value="1" class="working-button">出勤</button>
        @elseif ($state==1)
        <button name="punch" value="9" class="working-button">退勤</button>
        <button name="punch" value="2" class="working-button breaking">休憩 入</button>
        @elseif ($state==2)
        <button name="punch" value="3" class="working-button breaking">休憩 戻</button>
        @elseif ($state==9)
        お疲れ様でした。
        @endif
      </form>
    </div>
  </div>
</x-common>

<script>
  let week = ['日', '月', '火', '水', '木', '金', '土'];

  function clock() {
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
  setInterval(clock, 500);
</script>