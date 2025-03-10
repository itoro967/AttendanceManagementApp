<x-common>
  <x-slot:css>
    <link rel="stylesheet" href="{{ asset('/css/table-common.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/staffList.css') }}">
  </x-slot:css>
  <div class="inner">
    <div class="page-title">スタッフ一覧</div>
    <table class="table">
      <thead>
        <tr>
          <th class="th name">名前</th>
          <th class="th mail">メールアドレス</th>
          <th class="th monthly-attendance">月次勤怠</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($staffs as $staff)
        <tr class="tr">
          <td class="td">{{ $staff->name }}</td>
          <td class="td">{{ $staff->email }}</td>
          <td class="td td--bold"><a href="{{ route('admin.staffDetail',['id'=>$staff->id]) }}">詳細</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</x-common>