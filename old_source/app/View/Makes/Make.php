<?php
// 作成するファイル名の指定
$file_name = 'file.txt';
$error_file = 'hoge.hoge';
  
// ファイルの存在確認
if( !file_exists($file_name) ){
//ファイル作成
    touch($file_name);   
    
}else{
    // すでにファイルが存在する為エラーとする
    echo('Warning - ファイルが存在しています。 file name:['.$file_name.']');
    touch($error_file);
    exit();
    
}
// ファイルのパーティションの変更
    chmod($file_name,0666);
    echo('Info - ファイル作成完了。 file name:['.$file_name.']');
