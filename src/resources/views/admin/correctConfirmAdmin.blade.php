<x-common>
  <x-slot:css>
  <link rel="stylesheet" href="{{ asset('/css/table-common.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/correctConfirmAdmin.css') }}">
  </x-slot:css>
  <div class="inner">
    <div class="page-title">勤怠詳細</div>
    <form action="{{ route('admin.confirm') }}" method="post">
      @csrf
      <input type="hidden" name="work_id" value="{{$work->id}}">
      <table class="table">
        <tbody>
          <tr class="tr">
            <th class="th">名前</th>
            <td class="td td_name"><span class="input-data">{{$work->user->name}}</span></td>
          </tr>
          <tr class="tr">
            <th class="th">日付</th>
            <td class="td"><span class="input-data">{{$work->date}}</span></td>
          </tr>
          <tr class="tr">
            <th class="th">出勤・退勤</th>
            <td class="td"><span class="input-data">{{$work->begin_at}}</span></td>
            <td class="td"><span class="input-data">{{$work->finish_at}}</span></td>
          </tr>
          @foreach($work->rests as $rest)
          <tr class="tr">
            <th class="th">休憩:{{$loop->index+1}}</th>
            <td class="td"><span class="input-data">{{$rest->begin_at}}</span></td>
            <td class="td"><span class="input-data">{{$rest->finish_at}}</span></td>
          </tr>
          @endforeach
          <tr class="tr">
            <th class="th">備考</th>
            <td class="td td-note" colspan="2"><span class="input-data note">{{$work->note}}</span></td>
          </tr>
        </tbody>
      </table>
      @if($work->is_confirmed)
      <button disabled class="button confirmed">承認済み</button>
      @else
      <button type="submit" class="button">承認</button>
      @endif
    </form>
  </div>
</x-common>