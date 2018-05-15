<?php

/**
 * SUser authority list
 */
Configure::write('authority_list', array(
    1 => "管理者",
    2 => "一般担当者"
));

Configure::write('display_time_select', array(
    1 => "1時間",
    6 => "6時間",
    12 => "12時間",
    24 => "24時間"
));

Configure::write("camera_setting_default", array(
    "diff_pix" => 20,
    "time_gap" => 60,
    "output_time" => 1,
    "get_pic_time" => 1,
    "switcher_on" => "18:00",
    "switcher_off" => "7:00",
    "switcher_mode" => "auto",
    "switcher_name" => "USB Powered Relay Module",
    "ftp_port" => 21,
    "path_raw_image" => "c:\programdata\i4kd\\rawimage",
    "path_trans" => "c:\programdata\i4kd\\trans",
    "path_proc_image" => "c:\programdata\i4kd\procimage",
    "start_x" => 64,
    "start_y" => 48,
    "end_x" => 235,
    "end_y" => 562,
    "width" => 450,
    "height" => 364
));

Configure::write('alert_message_first_sentence', "観測所名 [place] より、災害のアラートが検出されました。");
?>
