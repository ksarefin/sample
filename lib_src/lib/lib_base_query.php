<?
// --------------------------------------------------------------------------------
//	クエリビルダー
//	********* 【 class QueryBuilder 】*************************
//				
//
//		コンストラクタ
//		QueryBuilder();
//				
//		int setInteger($fieldStr, $searchStr)
//						1-：１以上，-2：2以下，1-3 で 1〜3，空白区切りでOR検索
//						戻り値 (1: セット，0: セットなし)
//		int setLike($fieldStr, $searchStr)
//						いわゆる全文検索(空白区切りでAND検索)
//						戻り値 (1: セット，0: セットなし)
//		int setHeadLike($fieldStr, $searchStr)
//						like前方一致検索(空白区切りでAND検索)
//						戻り値 (1: セット，0: セットなし)
//		int setEqual($fieldStr, $searchStr)
//						"stage_txt='normal'"のような検索( int 型には用いるべからず)
//						戻り値 (1: セット，0: セットなし)
//		int notEqual($fieldStr, $searchStr)
//						"stage_txt<>'normal'"のような検索
//						戻り値 (1: セット，0: セットなし)
//		int setIn($fieldStr, $searchList)
//						where fieldName in (...) のこと
//		int set($queryStr)
//						検索条件をそのまま記述
//						戻り値 (1: セット，0: セットなし)
//		int setGroup($groupStr)
//						group by なんとか
//						戻り値 (1: セット，0: セットなし)
//		int setOrder($orderStr)
//						id_i desc とか
//						戻り値 (1: セット，0: セットなし)
//String	out($queryStr, $1,...)
//						printf 形式でOK，
// 						"select * from some_tab" まで入力させることにした
//						戻り値は，SQL Query の文字列
//		void setMode($modeStr)
//						and か or か？
//
//	********* 【 依存関係 】************************************
//				keySplit()
//				_addslashes()
//				ztrim()
// --------------------------------------------------------------------------------

class QueryBuilder
{
	var $whereSection  = array();
	var $groupSection  = "";
	var $orderSection  = "";
	var $limitSection  = "";
	var $offsetSection = "";
	var $mode = "and";
	
	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
 		
 	} // __construct
	
	
	
	
	// 複数フィールド対応
	// セットされたときは 戻り値 1
	function setInteger($fieldStr, $searchStr)
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_setInteger("__permutation__", $searchStr);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}

	function setLike($fieldStr, $searchStr, $mode="and")
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_setLike("__permutation__", $searchStr, $mode);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}
	
	
	function setNotLike($fieldStr, $searchStr, $mode="and")
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_setNotLike("__permutation__", $searchStr, $mode);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}
	

	function setILike($fieldStr, $searchStr, $mode="and")
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_setILike("__permutation__", $searchStr, $mode);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}

	function setHeadLike($fieldStr, $searchStr)
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_setHeadLike("__permutation__", $searchStr);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}
	
	function setEqual($fieldStr, $searchStr)
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_setEqual("__permutation__", $searchStr);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}
	

	function notEqual($fieldStr, $searchStr)
	{
		$fieldList = split(",", $fieldStr);
		$tmpStr = $this->_notEqual("__permutation__", $searchStr);
		$tmpList = array();
		
		if(!strlen($tmpStr))
		{
			return;
		}
		for($i=0; $i<count($fieldList); ++$i){
			$tmpList[] = preg_replace("/__permutation__/", $fieldList[$i], $tmpStr);
		}
		$this->whereSection[] = "(". join(sprintf(" %s ", $this->_getReverseMode()), $tmpList). ")";
		
		return 1;
	}
	

	function setIn($fieldStr, $searchList)
	{
		for($i=0; $i< sizeof($searchList); ++$i){
			$searchList[$i] = ztrim($searchList[$i]);
			if(strlen($searchList[$i])){
				$tmpList[] = $searchList[$i];
			}
		}
		if(sizeof($tmpList)){
			$this->whereSection[] = sprintf("(%s in (%s))", $fieldStr, join(",", $tmpList));
		} else {
			return 0;
		}
		
		return 1;
	}

	function set($queryStr){
		if(strlen($queryStr)){
			$this->whereSection[] = "(". $queryStr. ")";
			return 1;
		}
	}


	function setGroup($groupStr){
		if(strlen($groupStr)){
			$this->groupSection = sprintf(" GROUP BY %s ", $groupStr);
			return 1;
		}
	}


	function setOrder($orderStr){
		if(strlen($orderStr)){
			$this->orderSection = sprintf(" ORDER BY %s ", $orderStr);
			return 1;
		}
	}
	
	function setLimit($limit){
		if(strlen($limit)){
			$this->limitSection = sprintf(" LIMIT %d ", $limit);
			return 1;
		}
	}
	
	
	function setOffset($offset){
		if(strlen($offset)){
			$this->offsetSection = sprintf(" OFFSET %d ", $offset);
			return 1;
		}
	}


	// "select * from some_tab" まで入力させることにした
	function out($queryStr, $a="____null____", $b="", $c="", $d="", $e="", $f="", $g=""){
		$queryStr = !strcmp($a, "____null____") ? $queryStr : sprintf($queryStr, $a, $b, $c, $d, $e, $f, $g);
		if(count($this->whereSection)){
			$where_txt = "where ". join(" ". $this->mode. " ", $this->whereSection);
		}
		if(strlen($this->groupSection)){
			$groupStr = $this->groupSection;
		}
		if(strlen($this->orderSection)){
			$orderStr = $this->orderSection;
		}
		if(strlen($this->limitSection)){
			$limitStr = $this->limitSection;
		}
		if(strlen($this->offsetSection)){
			$offsetStr = $this->offsetSection;
		}
		$queryStr .= sprintf(" %s %s %s %s %s ", $where_txt, $groupStr, $orderStr, $limitStr, $offsetStr);
		//print_r($queryStr);
		return($queryStr);
	}

	// "select * from some_tab" まで入力させることにした
	function nowhere($queryStr, $a="____null____", $b="", $c="", $d="", $e="", $f="", $g=""){
		$queryStr = !strcmp($a, "____null____") ? $queryStr : sprintf($queryStr, $a, $b, $c, $d, $e, $f, $g);
		if(count($this->whereSection)){
			$where_txt = join(" ". $this->mode. " ", $this->whereSection);
		}
		if(strlen($this->groupSection)){
			$groupStr = $this->groupSection;
		}
		if(strlen($this->orderSection)){
			$orderStr = $this->orderSection;
		}
		$queryStr .= sprintf(" %s %s %s", $where_txt, $groupStr, $orderStr);
		return($queryStr);
	}


	function setMode($modeStr)
	{
		switch($modeStr)
		{
			case "and" :// 
			case "or":// 
				$this->mode = $modeStr;
				break;
			default: // 
				fatalError("そのようなモードは存在しませんmodeStr=$modeStr", $this->file_name, __LINE__);
				break;
		}
	}

  //2005/08/21
  function resetWhere(){
	$this->whereSection = array();
  }

// --------------------------------------------------------------------------------
// 以下は private メソッドなので使うな！！
// --------------------------------------------------------------------------------
	function _getReverseMode()
	{
		return ( "and" == $this->mode ) ? "or" : "and";
	}
	
	function _setInteger($fieldStr, $searchStr)
	{
		$searchList = keySplit($searchStr);
		
		for($i=0; $i < sizeof($searchList); ++$i){
			if(ereg("^-([0-9]+)$", $searchList[$i], $tmpReg)) {
				$tmpList[] = sprintf("%s<=%d", $fieldStr, $tmpReg[1]);
			}elseif(ereg("^([0-9]+)-$", $searchList[$i], $tmpReg)){
				$tmpList[] = sprintf("%s>=%d", $fieldStr, $tmpReg[1]);
			}elseif(ereg("^([0-9]+)-([0-9]+)$", $searchList[$i], $tmpReg)){
				$tmpList[] = sprintf("(%s>=%d and %s<=%d)", $fieldStr, $tmpReg[1], $fieldStr, $tmpReg[2]);
			}elseif(ereg("^([0-9]+)$", $searchList[$i], $tmpReg)) {
				$tmpList[] = sprintf("%s=%d", $fieldStr, $tmpReg[1]);
			}
		}
		if(strlen($tmpList[0])){
			return sprintf("(%s)", join(" or ", $tmpList));
		}
	}
	
	
	function _setLike($fieldStr, $searchStr, $mode="and")
	{
		unset($words);
		$searchStr = ztrim($searchStr);
		$words = keySplit($searchStr);
		
		for($i=0; !isNull($words[$i]); ++$i){
			$tmpList[] = sprintf("(%s like '%%%s%%')", $fieldStr, _addslashes($words[$i]) );
		}
		if(!isNull($tmpList[0])){
			return "(". join(" ". $mode. " ", $tmpList). ")";
		}
	}
	
	
	function _setNotLike($fieldStr, $searchStr, $mode="and")
	{
		unset($words);
		$searchStr = ztrim($searchStr);
		$words = keySplit($searchStr);
		
		for($i=0; !isNull($words[$i]); ++$i){
			$tmpList[] = sprintf("(%s not like '%%%s%%')", $fieldStr, _addslashes($words[$i]) );
		}
		if(!isNull($tmpList[0])){
			return "(". join(" ". $mode. " ", $tmpList). ")";
		}
	}


	function _setILike($fieldStr, $searchStr, $mode="and")
	{
		unset($words);
		$searchStr = ztrim($searchStr);
		$words = keySplit($searchStr);
		
		for($i=0; !isNull($words[$i]); ++$i){
			$words[$i] = mb_convert_kana($words[$i],'KVa');
			$tmpList[] = sprintf("(%s ilike '%%%s%%')", $fieldStr, _addslashes($words[$i]) );
		}
		if(!isNull($tmpList[0])){
			return "(". join(" ". $mode. " ", $tmpList). ")";
		}
	}
	
	function _setHeadLike($fieldStr, $searchStr)
	{
		$searchStr = ztrim($searchStr);
		if(!strlen($searchStr)){
			return;
		}
		return sprintf("(%s like '%s%%')", $fieldStr, _addslashes($searchStr) );
	}
	
	function _setEqual($fieldStr, $searchStr)
	{
		$searchStr = ztrim($searchStr);
		if(strlen($searchStr)){
			return sprintf("(%s='%s')", $fieldStr, _addslashes($searchStr));
		}
	}

	function _notEqual($fieldStr, $searchStr){
		if(strlen($searchStr)){
			return sprintf("(%s<>'%s')", $fieldStr, _addslashes($searchStr));
		}
	}
}
?>
