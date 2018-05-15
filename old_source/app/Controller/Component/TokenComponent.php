<?php

class TokenComponent extends Component {
	public $components = array("Session");
	
	// *****************************************
	// ワンタイムトークンの生成
	// *****************************************
	public function create_token(){
		$time = time();
		$rand = mt_rand();
		// 値をハッシュ化
		$time = md5( $time );
		$rand = md5( $rand );
//		$no_token = $ipad.$time.$rand;
		$no_token = $time.$rand;
		// トークン生成
		$token = md5( $no_token );
		
		return $token;		
	}
	
	// *****************************************
	// トークンの半券を取得
	// *****************************************
	function get_harf_token($name=null){
		$original_token = $this->create_token();
		// フォームに埋め込む半券
		$harf = substr( $original_token, 0, 10 );
		// オリジナルのトークンと片割れをSESSIONに保存
		if($name != null){
			$this->Session->write($name.'.harf_token',substr( $original_token, 10 ));
			$this->Session->write($name.'.original_token', $original_token);
		}else{
			$this->Session->write('harf_token',substr( $original_token, 10 ));
			$this->Session->write('original_token', $original_token);
		}
		
		return $harf;
	}
	
	// *****************************************
	// トークンの照合
	// *****************************************
	function check_token( $harf_token, $name=null ){
		if($name != null){
			// 照合用のトークン取得
			$ch_token = $this->Session->read("{$name}.original_token");
			// 所持していた半券とformから送信された半券を結合
			$token = $harf_token.$this->Session->read("{$name}.harf_token");
		}else{
			// 照合用のトークン取得
			$ch_token = $this->Session->read("original_token");
			// 所持していた半券とformから送信された半券を結合
			$token = $harf_token.$this->Session->read("harf_token");
		}
//print "<br>".$ch_token . "<br>" . $token;
		// 照合
		if( strcmp( $ch_token, $token ) === 0 ){
			return true;
		}
		return false;
	}
	
}

?>