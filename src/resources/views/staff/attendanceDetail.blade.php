<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/table-common.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/attendanceDetail.css') }}">
  </x-slot:css>
  <div class="inner">
    <div class="page-title">勤怠詳細</div>
    <form action="{{ route('staff.correct') }}" method="post">
      @csrf
      <input type="hidden" name="work_id" value="{{$work->id}}">
      <input type="hidden" name="type" value="{{$work->type + 1}}">
      <table class="table">
        <tbody>
          <tr class="tr">
            <th class="th">名前</th>
            <td class="td td_name">{{$work->user->name}}</td>
          </tr>
          <tr class="tr">
            <th class="th">日付</th>
            <td class="td"><input class="input" type="date" value="{{old('date',$work->date)}}" name="date" @disabled(!($work->is_confirmed ?? TRUE))></td>
          </tr>
          <tr class="tr">
            <th class="th">出勤・退勤</th>
            <td class="td"><input class="input" type="time" step="1" value="{{old('begin_at',$work->begin_at)}}" name="begin_at" @disabled(!($work->is_confirmed ?? TRUE))></td>
            <td class="td"><input class="input" type="time" step="1" value="{{old('finish_at',$work->finish_at)}}" name="finish_at" @disabled(!($work->is_confirmed ?? TRUE))></td>
          </tr>
          @foreach($work->rests as $rest)
          <input type="hidden" name="rest[{{$loop->index}}][rest_id]" value="{{$rest->id}}">
          <tr class="tr">
            <th class="th">休憩:{{$loop->index+1}}</th>
            <td class="td">
              <input class="input" type="time" step="1"
                value="{{ old('rest.' . $loop->index . '.begin_at', $rest->begin_at) }}"
                name="rest[{{$loop->index}}][begin_at]"
                @disabled(!($work->is_confirmed ?? TRUE))>
            </td>
            <td class="td">
              <input class="input" type="time" step="1"
                value="{{ old('rest.' . $loop->index . '.finish_at', $rest->finish_at) }}"
                name="rest[{{$loop->index}}][finish_at]"
                @disabled(!($work->is_confirmed ?? TRUE))>
            </td>
          </tr>
          @endforeach
          <tr class="tr">
            <th class="th">備考</th>
            <td class="td" colspan="2"><textarea class="textarea" name="note" rows="5" @disabled(!($work->is_confirmed ?? TRUE))>{{old('note',$work->note)}}</textarea></td>
          </tr>
        </tbody>
      </table>
      <x-alert :message="$errors->first('date')" />
      <x-alert :message="$errors->first('begin_at')" />
      <x-alert :message="collect($errors->first('rest.*.begin_at'))->first()" />
      <x-alert :message="collect($errors->first('rest.*.finish_at'))->first()" />
      <x-alert :message="$errors->first('note')" />
      @if($work->is_confirmed ?? TRUE)
      <button type="submit" class="button">修正</button>
      @else
      <div class="not_confirmed">*承認待ちのため修正はできません</div>
      @endif
    </form>
  </div>
</x-common>