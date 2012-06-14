<?

include_once(BASE_DIR.LIB_SRC.FUNCTION_DIR."/extra_function.php");


include_once("lib_base_error.php");
$gl_debugSw = isset($gl_debugMode) ? 1 : 0;


// ---------------------------------------------------------------------------
// selectクエリー生成するためのクラス
// ********* 【 class SelectQuery 】***************************
// ---------------------------------------------------------------------------
include_once("lib_base_query.php");



// ---------------------------------------------------------------------------
//	ページ管理クラス
//	********* 【 class PageClass 】*****************************
// ---------------------------------------------------------------------------
include_once("lib_base_page.php");



// ---------------------------------------------------------------------------
//	データベース インターフェース クラス
// ********* 【 class DBBridge 】***************************
// ---------------------------------------------------------------------------
$database_type = $GLOBALS['gl_databaseInfo']['dbType'];
include_once("lib_base_".$database_type.".php");



// 2005/07/25
class basicResultClass{
  var $result;
  var $db;
  var $query;
  var $hitNum;
  var $id;
  var $table;
  var $sql;
  var $start;
  var $end;
  var $clms;
  
  function basicResultClass($table){
	$db=new DbBridge;
	$query=new QueryBuilder;
	$this->db=$db;
	$this->query=$query;
	$this->table=$table;
  }

  function setId($id){
	$this->id=$id;
	$this->query->setInteger("id_i",$id);
  }
  
  function setStart($start){
	$this->start=$start;
  }

  function setEnd($end){
	$this->end=$end;
  }

  function setClms($in){
	if(!isNull($in)){
	  $this->clms=$in;
	}elseif(isNull($this->clms)){
	  $this->clms='*';
	}
	return $this->clms;
  }

  function sql($in=""){
	$this->setClms($in);
	$this->sql=$this->query->out(sprintf("SELECT %s FROM %s",$this->clms,$this->table));
	AccessTimeCheck(  $this->sql );
	return $this->sql;
  }

  function search($start=0,$count=20000){
	//	$sql=$this->query->out("SELECT * FROM ".$this->table);
	$sql=$this->sql();
	AccessTimeCheck(  "refer s" );
	$result=$this->db->refer($sql,$start,$count);
	AccessTimeCheck(  "refer e" );
	$this->result=$result;
	$this->hitNum=$this->db->hitNum;
  }

  function setOrder($order="id_i"){
	$this->query->setOrder($order);
  }

  function outResult($start=0,$range=20000){
	$this->search($start,$range);
	return $this->result;
  }

  function setWhere($in){
	if(!isNull($in)){
	  $this->query->set($in);
	}
  }

  function hitNum(){
	return $this->hitNum;
  }

  function setTable($table){
	$this->table=$table;
  }

  function resetWhere(){
	$this->query->resetWhere();
  }
}



?>
