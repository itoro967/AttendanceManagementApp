<?php

return [
    'required' => ':attributeを入力してください',
    'min' => [
        'string' => ':attributeは:min文字以上で入力してください',
    ],
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください',
    ],
    'unique' => [
        'email' => 'このメールアドレスは既に登録されています',
    ],
    'before' =>[
        'begin_at' => '出勤時間もしくは退勤時間が不適切な値です',
    ],
    'custom' => [
        'rest.*.begin_at.before' => '休憩時間が不適切な値です',
        'rest.*.begin_at.after' => '休憩時間が勤務時間外です',
        'rest.*.finish_at.before' => '休憩時間が勤務時間外です',
    ],

    'confirmed' => 'パスワードと一致しません',
    'attributes' => [
        'name' => 'お名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'note' => '備考',
        'date' => '日付',
        'rest.*.begin_at' => '休憩入り時間',
        'rest.*.finish_at' => '休憩戻り時間',
        'begin_at' => '出勤時間',
        'finish_at' => '退勤時間',
    ],
];
