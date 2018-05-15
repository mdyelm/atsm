<?php

require_once 'message.php';

date_default_timezone_set('Asia/Tokyo');

Configure::write('TemMailForget', array(
    'title' => '【4Kカメラ災害監視システム】パスワードをお忘れの方',
    'view' => 'forget'
));
//session search
Configure::write('SessionSearch', array(
    'Monitoring', 'Licenses', 'Organizations', 'Users', 'Units'
));
Configure::write('paginate.Limit.Pagination', 20);

Configure::write('Unit.status', array(
    0 => "正常稼動中",
    1 => "映像の取得異常(カメラ異常)",
    2 => "電源異常",
    3 => "稼動終了",
    4 => "ファイル保存異常"
));
Configure::write('License.type', array(
    1 => '試用版',
    2 => '正規版'
));
Configure::write('License.status', array(
    0 => '無効',
    1 => '有効'
));
Configure::write('User.role', array(
    0 => 'DL管理者',
    1 => '管理者',
    2 => '一般担当者'
));
Configure::write('User.role1', array(
    1 => '管理者',
    2 => '一般担当者'
));

Configure::write('display_interval', array(
    1 => "1秒間隔",
    //2 => "2秒ずつ",
    5 => "5秒間隔",
    10 => "10秒間隔",
    15 => "15秒間隔",
    20 => "20秒間隔",
    25 => "25秒間隔",
    30 => "30秒間隔",
    60 => "1分間隔",
));
Configure::write('display_intervalOLd', array(
    1 => "30秒",
    2 => "1分",
    5 => "2分30秒",
    10 => "5分",
    15 => "7分30秒",
    20 => "10分",
    25 => "12分30秒",
    30 => "15分",
    60 => "30分",
));
Configure::write('diff_pix_type', array(
    'diff_pix_hue' => "色相",
    'diff_pix_shade' => "位置"
));

Configure::write('set_default', array(
    'display_interval' => 5,
    'bar_rate' => 30,
    'diff_pix_type' => 'diff_pix_hue',
    'miniSeconds' => 100,
    'arrDateDisplay' => array(1,16,31)
));

Configure::write('chartThreshold', array(
    'Threshold1' => 60,
    'Threshold2' => 40,
    'Threshold3' => 20,
));
Configure::write('monitor_list', array(
    'limit' => 10
));

$time_csv = array();
$time_img = array();
for ($i = 0; $i <= 23; $i++) {
    $time_csv[$i] = $i;
}
for ($i = 0; $i <= 23; $i++) {
    $time_img[$i] = $i;
    if ($i == 23) {
        $time_img[$i + 1] = '*';
    }
}
Configure::write('time_csv', $time_csv);
Configure::write('time_img', $time_img);

Configure::write('radio_notification', array(
    1 => '通知する',
    2 => '通知しない'
));

define('PHP_PATH', 'php ');
Configure::write('Shell.SendMailAlive', PHP_PATH . APP . 'Console' . DS . 'cake.php SendMailAlive');

Configure::write('AlivesReq_mail', array(
    0=> array(
        "title" => 'ユニット端末の稼動が開始しました',
        "content" => 'ユニット端末の稼動が開始しました'
    ),
    1 => array(
        "title" => 'ユニット端末装置異常のお知らせ',
        "content" => '映像の取得が出来ません。ユニット端末のカメラの状態を確認してください'
    ),
    2 => array(
        "title" => 'ユニット端末装置異常のお知らせ',
        "content" => 'ユニット端末の電源に異常が発生しています'
    ),
    3 => array(
        "title" => 'ユニット端末装置異常のお知らせ',
        "content" => 'ユニットの稼動が終了しました'
    ),
    4 => array(
        "title" => 'ユニット端末装置異常のお知らせ',
        "content" => 'ユニット端末でファイルの書き込みに失敗しました。書き込み先ディスクの状態を確認してください'
    ),
));


Configure::write('GetDataShell_mail', array(
    "Error500" => array(
        "title" => 'ユニット端末異常のお知らせ',
        "content" => 'ユニット端末にて、観測データの生成に失敗しました。'
    ),
    "Error400" => array(
        "title" => '内部エラー',
        "content" => 'リクエストした日付に誤りがあります。サーバー管理者にお問い合わせ下さい'
    ),
    "Error401" => array(
        "title" => 'ユニット端末異常のお知らせ',
        "content" => 'ユニット端末との通信が拒否されました。ユニット端末側の「観測データ取得ホストの値をご確認ください。'
    ),
    "ErrorOther" => array(
        "title" => 'ユニット端末異常のお知らせ',
        "content" => 'ユニット端末との通信に失敗しました。ユニット端末側のネットワーク状況をご確認ください。'
    ),
));
