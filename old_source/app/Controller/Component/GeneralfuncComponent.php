<?php

/*
 * 汎用関数群
 */

class GeneralfuncComponent extends Component {

    /**
     * タグを除く
     * @param array $data
     * @return type
     */
    public function dataEscape($data = null, $type = "all") {
        App::uses('Sanitize', 'Utility');
        if ($data != null) {
            if (is_array($data)) {
                foreach ($data as $key => $val) {
                    $data[$key] = $this->dataEscape($val);
                }
            } else {
                //半角カナ→全角カナ
                $data = mb_convert_kana($data, "KV", "UTF-8");
                if ($type == "textarea") {
                    $data = Sanitize::stripImages(trim($data));
                    $data = Sanitize::stripScripts($data);
                } else {
                    //$data = mb_convert_encoding($data, "UTF-8", "EUC-JP");
                    $data = Sanitize::stripAll(trim($data));
                }
            }
        }

        return $data;
    }

    /**
     * SQLのLIKE分のワイルドカードをエスケープする
     *
     * @params string $str LIKE文に指定する検索文字列
     * @params boolean $before 検索文字列の前に % を付与するか
     * @params boolean $after 検索文字列の後に % を付与するか
     * @return string ワイルドカードがエスケープされたLIKE文
     */
    public function escapeLikeSentence($str, $before = false, $after = false) {
        $result = str_replace('\\', '\\\\', $str); // \ -> \\
        $result = str_replace('%', '\\%', $result); // % -> \%
        $result = str_replace('_', '\\_', $result); // _ -> \_
        return (($before) ? '%' : '') . $result . (($after) ? '%' : '');
    }

    /**
     * URLのIDが数字かどうかのチェック
     * @param type $id
     * @return boolean
     */
    public function checkID($id) {
        if (!preg_match("/^[0-9]+$/", $id) || $id == 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 日付正規型チェック
     * @param type $str
     * @return boolean
     */
    public function checkDate($str) {
        if ($str != "") {
            if (!preg_match("/^\d{4}\/\d{2}\/\d{2}$/", $str)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 英数字変換（全角→半角）
     * @param type $val
     * @return type
     */
    public function changeEngNum($val) {
        return mb_convert_kana($val, "a", "UTF-8");
    }

    /**
     * 年リスト
     */
    public function getYearList() {
        $y = date("Y");
        $y += 2;

        $year_list = array();
        for ($y; $y >= START_YEAR; $y--) {
            $year_list[$y] = $y;
        }

        return $year_list;
    }

    /**
     * 月,日リスト
     */
    public function getMonthDayList($end_num) {
        $list = array();
        for ($m = 1; $m <= $end_num; $m++) {
            $list[$m] = $m;
        }

        return $list;
    }

    /**
     * フリー　2桁リスト
     * @param unknown_type $min
     * @param unknown_type $max
     */
    public function freeDateArr($min, $max, $step = 1) {
        $data = array();
        for ($d = $min; $d <= $max; $d+=$step) {
            $data[$d] = $d;
        }

        return $data;
    }

    /**
     * CSVダウンロード処理
     * @param array $csv_data title,fname,data
     */
    public function csvDownload($csv_data) {
        if (empty($csv_data["data"])) {
            return false;
        }

        try {
            //ファイル名日本語対応
            $fileName = $csv_data["fname"] . "_" . date("YmdHis") . ".csv";
            $ua = $_SERVER['HTTP_USER_AGENT'];

            //$fileName = str_replace("?","",$fileName);
            //$fileName = str_replace("/","",$fileName);
            //$fileName = str_replace(";","",$fileName);

            if (preg_match("/MSIE/i", $ua)) {
                $fileName = mb_convert_encoding($fileName, "SJIS-win", "UTF-8");
            }

            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $fileName);

            $title = "";
            $r = "";
            foreach ($csv_data["title"] as $t_row) {
                $title .= $r . '"' . $t_row . '"';
                $r = ",";
            }
            echo mb_convert_encoding($title . "\r\n", 'SJIS-win', 'UTF-8');
            //echo $title."\r\n";

            if ($csv_data["data"]) {
                foreach ($csv_data["data"] as $d_row) {
                    $line = "";
                    $r = "";
                    foreach ($d_row as $row) {
                        $line .= $r . '"' . $row . '"';
                        $r = ",";
                    }

                    echo mb_convert_encoding($line . "\r\n", 'SJIS-win', 'UTF-8');
                }
            }
            exit();
        } catch (Exception $e) {
            $this->log($e->getMessage(), LOG_ERR);
            return false;
        }
    }
    
}

?>
