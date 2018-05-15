<?php
define("E700", "ログインIDとパスワードをご入力ください");
define("E701", "登録情報が存在しません");
define("E801", "画面遷移が不正です");
define("E700_user_id", "担当者IDを入力してください");
define("E700_login_pw", "パスワードを入力してください");
define("E700_confirm_pw", "パスワード確認はパスワードと一致する必要があります");
define("E200_user_id", "ログインIDは半角英数字15文字で入力してください");
define("E200_login_pw", "パスワードは6文字以上15文字以内で入力してください");
define("E200_user_name", "担当者名を入力してください");
define("ERROR_NOT_BLANK", "入力して下さい");

define("user_name_maxLength", "IDは15文字以内でしてください");
define("login_pw_maxLength", "パスワードは15文字以内でしてください");
define("login_pw_minMaxLength", "パスワードは6文字以上かつ15文字以内の半角英数字で入力してください");

// message auth/forget
define("E700_forget_mail", "メールアドレスを入力してください");
define("E200_format_mail", "メールアドレスの形式に誤りがあります");
define("E300_forget_mail", "登録メールアドレスは50文字以内で入力してください");
define("ERROR_SEND_MAIL", "メールを送信できませんでした。もう一度送信してください");

// message Organizations/organization_regist
define("E001_organization_name", "組織名はスペースのみの入力はできません");
define("E001_position", "全角半角合計30文字");
define("E001_phone", "20文字以内半角数字のみ");
define("E002_phone", "半角数字で入力してください。");
define("E001_mail_address", "全角半角合計50文字。");

// Monitoring/status
define("ERROR_NOT_EXIST_UNIT", "このクライアントが存在しません");
define("ERROR_NOT_EXIST_FILE_XXL", "このクライアントは観測状況がありません");
define("ERROR_NOT_EXIST_DATA", "観測データがありません");
define("ERROR_NOT_EXIST_DATA_SEARCH", "観測データがありません");


define("unit_id_maxLength", "ユニット端末IDは15文字以内でしてください");
define("organization_name_maxLength", "管理組織は30文字以内でしてください");
define("place_maxLength_fullwidth", "観測場所名は全角数値60桁以内で入力して下さい");
define("ip_address_maxLength_haltwidth", "IPアドレスは半角数値20桁以内で入力して下さい");

// Not Blank ORGANIZATION 
define("ORGANIZATION_NAME_NOT_BLANK", "組織名を入力してください");
define("ORGANIZATION_PHONE_NOT_BLANK", "代表電話番号を入力してください");
define("ORGANIZATION_MAIL_NOT_BLANK", "代表メールアドレスを入力してください");

// Not Blank USER
define("USER_NAME_NOT_BLANK", "担当者名を入力してください");
define("ORGANIZATION_ID_NOT_BLANK", "所属組織を入力してください");
define("USER_PHONE_NOT_BLANK", "緊急連絡先を入力してください");
define("USER_MAIL_NOT_BLANK", "メールアドレスを入力してください");
define("USER_ROLE_NOT_BLANK", "システム権限を入力してください");
define("USER_NOTIFICATION_NOT_BLANK", "ユニット端末異常通知を入力してください");
define("USER_PASSWORD_NOT_BLANK", "パスワードを入力してください");
define("USER_PASSWORD_CF_NOT_BLANK", "パスワード確認を入力してください");

// Not Blank UNIT ～を入力してください
define("ORGANIZATION_ID_UNIT_NOT_BLANK", "管理組織を入力してください");
define("ORGANIZATION_EXP_DATE_NOT_BLANK", "有効期限を入力してください");

// Data
define("NOT_EXIST_IMAGE_ANALYSIS", "該当する解析画像が存在しません");
define("NOT_EXIST_IMAGE_OBSERVE", "該当する観測画像が存在しません");
