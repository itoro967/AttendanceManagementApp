<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendanceManagementApp</title>
    <link rel="stylesheet" href="{{ asset('/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/common.css') }}">
    {{$css}}
</head>

<body>
    <x-header />
    @if(session('message'))
    <div class="session_message">{{session('message')}}</div>
    @endif
    {{ $slot }}
</body>

</html>