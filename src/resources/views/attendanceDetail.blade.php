<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/attendanceDetail.css') }}">
  </x-slot:css>
  <div class="inner">
    <div>勤怠詳細</div>
    <form action="correct" method="post">
      @csrf
      <input type="hidden" name="work_id" value="{{$work->id}}">
      <input type="hidden" name="type" value="{{$work->type + 1}}">
      <table class="table">
        <tbody>
          <tr class="tr">
            <th class="th">名前</th>
            <td class="td td_name">{{Auth::user()->name}}</td>
          </tr>
          <tr class="tr">
            <th class="th">日付</th>
            <td class="td"><input class="input" type="date" value="{{$work->date}}" name="date" @disabled(!($work->is_confirmed ?? TRUE))></td>
          </tr>
          <tr class="tr">
            <th class="th">出勤・退勤</th>
            <td class="td"><input class="input" type="time" step="1" value="{{$work->begin_at}}" name="begin_at" @disabled(!($work->is_confirmed ?? TRUE))></td>
            <td class="td"><input class="input" type="time" step="1" value="{{$work->finish_at}}" name="finish_at" @disabled(!($work->is_confirmed ?? TRUE))></td>
          </tr>
          @foreach($work->rests as $rest)
          <tr class="tr">
            <th class="th">休憩:{{$loop->index+1}}</th>
            <td class="td"><input class="input" type="time" step="1" value="{{$rest->begin_at}}" name="rest[{{$loop->index}}][begin_at]" @disabled(!($work->is_confirmed ?? TRUE))></td>
            <td class="td"><input class="input" type="time" step="1" value="{{$rest->finish_at}}" name="rest[{{$loop->index}}][finish_at]" @disabled(!($work->is_confirmed ?? TRUE))></td>
          </tr>
          @endforeach
          <tr class="tr">
            <th class="th">備考</th>
            <td class="td" colspan="2"><textarea class="textarea" name="note" rows="5" @disabled(!($work->is_confirmed ?? TRUE))>{{$work->note}}</textarea></td>
          </tr>
        </tbody>
      </table>
      @if($work->is_confirmed ?? TRUE)
      <button type="submit" class="button">修正</button>
      @else
      <div class="not_confirmed">*承認待ちのため修正はできません</div>
      @endif
    </form>
  </div>
</x-common>