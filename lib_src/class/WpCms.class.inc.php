<?php
/**
 * ActiveIR.class.inc.php
 * 
 * @created on 2011/05/31
 * @package    
 * @subpackage
 * @author     Arefin Tuhin
 * @version    SVN: Id: profile 2692 2011/05/31-16:22:53 fabien 
 * 
 *File content
     ActiveIR.class.inc.php
 *     
 */

 
 /**
  * 
  * Default class for Data Handle
  * @author arefin
  *
  */
 class WpCms{
 	
 	/**
 	 * DataBase instance
 	 */
 	protected $DB;
 	
 	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	
 	/**
 	 * contruct method
 	 */
 	function __construct(){
 		
 		/**
 		 * DataBase
 		 */
 		$this->DB = new DBBridge();
 		
 		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];

 	} // __construct
 	
 	
 	
 	
 	/**
 	 * get admin info 
 	 * @param $admin_id
 	 * @return admin info
 	 */
 	public function getAdminInfo($admin_id){
 		
 		if (empty($admin_id) || !is_numeric($admin_id))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: admin id is empty or invalid ");
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('activeuser', 1);
 		$QB->setInteger('id', $admin_id);
 		$QB->setLimit(1);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM ";
 		$sql .= " account_users ";
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		
 		if($result) 
 			return $result[0];
 			
 			
 	} // getAdminInfo
 	
 	
 	
 	
 	/**
 	 * update admin user table
 	 * @param $password
 	 * @param $admin_id
 	 */
 	public function updatePass($password, $admin_id){
 		
 		if (empty($password) || !is_string($password))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: password is empty or invalid ");
 		
 		if (empty($admin_id) || !is_numeric($admin_id))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: admin id is empty or invalid ");
 		 			
 		
 		$data = array(
	 		'id' 		=> $admin_id,
	 		'passwd'	=> $password,
 		);

 		
 		$this->DB->post($data, 'account_users');
 			
 	} // updatePass
 	
 	
 	/**
 	 * get number of rows on table for web
 	 * @param $table_name
 	 * @param $search_array
 	 * @return number of row
 	 */
 	public function getNumRowsWeb($table_name, $search_array = null){
 		
 		
 		$this->getNumRows($table_name, $search_array, 'web');
 		
 	} // getNumRowsWeb
 	
 	
 	/**
 	 * 
 	 * get number of rows on table
 	 * @param $table_name
 	 * @param $search_array
 	 * @return number of row
 	 */
 	public function getNumRows($table_name, $search_array = null, $data_panel = null ){
 		
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: getNumRows parameter table name is empty");
 		
 		$QB = new QueryBuilder();
 	
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$QB->setEqual($key, $val);
			}			
		}
 		
		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 			
 		$QB->setInteger('delete_flg', 0);
 		
 		$sql  = " SELECT ";
 		$sql .= " count(id) AS count_id";
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out( $sql );
 		//print $query_txt;
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) 
 			$num_rows = $result[0]['count_id'];
 			
 		return $num_rows;
 		
 	} // getNumRows
 	
 	
 	
 	/**
 	 * 
 	 * get last id from given table
 	 * @param $table_name
 	 */
 	public function getLastIdWeb($table_name, $fields_values = array() ){
 		
 		
 		$this->getLastId($table_name, $fields_values, 'web');
 		
 	} // getLastIdWeb
 	
 	
 	
 	/**
 	 * 
 	 * get last id from given table
 	 * @param $table_name
 	 */
 	public function getLastId($table_name, $fields_values = array(), $data_panel = null){
 		
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: getLastId parameter table name is empty");
 		
 		$QB = new QueryBuilder();
 		
 		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 			
 		$QB->setInteger('delete_flg', 0);
 		
 		if (!empty($fields_values) && is_array($fields_values)){
 			
 			foreach ($fields_values as $key=>$val){
 				
 				$QB->setEqual($key, $val);
 			}
 			
 		}
 		
 		
 		$QB->setOrder(" id DESC ");
 		$QB->setLimit(1);
 		$sql  = " SELECT ";
 		$sql .= " id ";
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) $id = $result[0]['id'];
 		
 		
 		return $id;
 		
 	} // getLastId 
 	
 	
 	
 	
 	
 	/**
 	 * 
 	 * get id by corresponds field and table for web
 	 * @param $field_name
 	 * @param $value
 	 * @param $table_name
 	 */
 	public function getIdWeb($field_name, $value, $table_name){
 		
 		$this->getId($field_name, $value, $table_name, 'web');
 		
 	} // getIdWeb
 	
 	
 	
 	
 	/**
 	 * 
 	 * get id by corresponds field and table
 	 * @param $field_name
 	 * @param $value
 	 * @param $table_name
 	 */
 	public function getId($field_name, $value, $table_name, $data_panel = null){
 		
 		if (empty($field_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: field name is empty");
 		
 		if (empty($value))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: value is empty");
 			
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: table name is empty");	
 		
 		$QB = new QueryBuilder();
 		
 		if ($data_panel = 'web')
 			$QB->setInteger('display_flg', 1);
 			
 		$QB->setInteger('delete_flg', 0);
 		$QB->setEqual($field_name, $value);
 		$QB->setLimit(1);
 		$sql  = " SELECT ";
 		$sql .= " id ";
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out( $sql );
 		
 		//print "<br>";
 		//print_r($query_txt);
 		//print "<br>";
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) $id = $result[0]['id'];

 		
 		return $id;
 		
 	} // getId
 	
 	
 	
 	
 	/**
 	 * search id crrosponds of columns for web
 	 * @param $table_name
 	 * @param array $search_fields_values
 	 * @return id
 	 */
 	public function getIdByColumnsWeb($table_name, $search_fields_values){
 		
 		$this->getIdByColumns($table_name, $search_fields_values, 'web');
 		
 	} // getIdByColumnsWeb
 	
 	
 	/**
 	 * search id crrosponds of columns
 	 * @param $table_name
 	 * @param array $search_fields_values
 	 * @return id
 	 */
 	public function getIdByColumns($table_name, $search_fields_values, $data_panel = null){
 		
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: table name is empty");
 		

 		if (empty($search_fields_values) || !is_array($search_fields_values))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: search_fields_values name is empty or invalid array");

 			
 		
 		$QB = new QueryBuilder();
 		
 		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 			
 		$QB->setInteger('delete_flg', 0);
 		
 		foreach ($search_fields_values as $row){
 			
 			
 			switch ($row['method']) {
 				case 'int':
	 					$method = setInteger; //$QB->setInteger($row['field'], $row['value']);
	 				break;
 				
	 			case 'like':
	 					$method = setLike; //$QB->setLike($search_column, $search_value);
	 				break;
 				
	 			case 'notLike':
	 					$method = setNotLike;//$QB->setNotLike($search_column, $search_value);
	 				break;
	 				
	 			default:
	 					$method= setEqual;//$QB->setEqual($search_column, $search_value);
	 				break;
 			}
 			
 			
 			
 			$QB->$method($row['field'], $row['value']);
 			
 			
 			
 		}
 		
 		$QB->setOrder(' id DESC ');
 		$QB->setLimit(1);
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " id ";
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out( $sql );
 		
 		
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if($result) $id = $result[0]['id'];

 		
 		return $id;
 		
 	} // getIdByColumns
 	
 	
 	 	
 	/**
 	 * get record for web
 	 * @param $id
 	 * @param $table_name
 	 * @return record
 	 */
 	public function getRecordWeb($id, $table_name){
 		
 		
 		$this->getRecord($id, $table_name, 'web');
 		
 	} // getRecordForWeb
 	
 	
 	
 	/**
 	 * get table record
 	 * @param $id
 	 * @param $table_name
 	 * @return record
 	 */
 	public function getRecord($id, $table_name, $data_panel){
 		
 		
 		if (empty($id) || !is_numeric($id))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: parameter table id is empty or invalid");
 		
 		if (empty($table_name) || !is_string($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: parameter table name is empty or invalid");
 		
 			
 		$QB = new QueryBuilder();
 		
 		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 		
 		$QB->setInteger('delete_flg', 0);
 		$QB->setInteger('id', $id);
 		
 		$sql  = " SELECT ";
 		$sql .= " * ";
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out( $sql );
 		
 		$result = $this->DB->refer($query_txt);
 		
 		
 		if ($result)
 			return $result[0];
 		
 			
 	} // getRecord
 	
 	
 	
 	
 	/**
 	 * 
 	 * get name corresponds of id for web 
 	 * @param table_id $id
 	 * @param table_name $table
 	 * @return name
 	 */
 	public function getNameWeb($id, $table){
 		
 		$this->getName($id, $table, 'web');
 		
 	} // getNameWeb
 	
 	
 	/**
 	 * 
 	 * get name corresponds id
 	 * @param table_id $id
 	 * @param table_name $table
 	 * @return name
 	 */
 	public function getName($id, $table, $data_panel){

 		if (empty($id) || !is_numeric($id)) 
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: id is empty or invalid");
 			
 			
 		if (empty($table)) 
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: table name is empty");

 			
 		
 		$QB = new QueryBuilder();
 		
 		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 			
 		$QB->setInteger('delete_flg', 0);
 		$QB->setInteger('id', $id);
 		$QB->setLimit(1);
 		$sql  = " SELECT ";
 		$sql .= " name ";
 		$sql .= " FROM ";
 		$sql .= $table;
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) $name = $result[0]['name'];
 		
 		
 		return $name;
 		
 	} // getName
 	
 	
 	
 	
 	/**
 	 * get columns value for web
 	 * @param $get_column
 	 * @param $search_column
 	 * @param $search_value
 	 * @param $table_name
 	 * @param $method // default equal
 	 * @return column value
 	 */
 	public function getColumnsValWeb($get_columns, $search_column, $search_value, $table_name, $method=null){
 		
 		$this->getColumnsVal($get_columns, $search_column, $search_value, $table_name, $method, 'web');
 		
 	} // getColumnsValWeb
 	
 	
 	
 	
 	/**
 	 * get columns value
 	 * @param $get_column
 	 * @param $search_column
 	 * @param $search_value
 	 * @param $table_name
 	 * @param $method // default equal
 	 * @return column value
 	 */
 	public function getColumnsVal($get_columns, $search_column, $search_value, $table_name, $method=null, $data_panel=null){
 		
 		if (empty($get_columns) || !is_array($get_columns))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: get columns name is empty or invalid array");
 			
 		if (empty($search_column))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: search column name is empty");

 		if (empty($search_value))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: search column value name is empty");	
 		
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: table name is empty");
 			

 			

 		$QB = new QueryBuilder();
 		
 		if (empty($method))
 			$QB->setEqual($search_column, $search_value);
 			
 		if ($method == 'int')
 			$QB->setInteger($search_column, $search_value);

 		if ($method == 'like')
 			$QB->setLike($search_column, $search_value);
 			
 		if ($method == 'notLike')
 			$QB->setNotLike($search_column, $search_value);

 		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 			
 		$QB->setInteger('delete_flg', 0);
 		$QB->setLimit(1);
 		
 		$sql  = " SELECT ";
 		$sql .= join(',', $get_columns);
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out($sql);
 		
 		//print_r($query_txt);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
			$get_value = $result[0];
 		
			
 		return $get_value;
 				
 	} // getColumnsVal
 	
 	
 	
 	
 	
 	/**
 	 * 
 	 * get total row without deleted
 	 * @param $table_name
 	 * @param $search_array
 	 * @return total row number 
 	 */
 	public function getTotal($table_name, $search_array = null ){
 		
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__."  <br /> Method: ".__METHOD__." <br /> Msg: getDisplayCount parameter table name is empty");
 			

 		$QB = new QueryBuilder();
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$QB->setEqual($key, $val);
			}			
		}
		
 		$QB->setInteger('delete_flg', 0);
 		
 		$sql  = " SELECT ";
 		$sql .= " count(id) as count_id ";
 		$sql .= " FROM ";
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out($sql);
 		//print $query_txt;
 		$result = $this->DB->refer($query_txt);
 		
 		if ($result) 
 			$total = $result[0]['count_id'];
 		

 		return $total;
 		
 	} // getTotal
 	
 	
 	
 	/**
	 * change require flag
	 * @param $id
	 * @param $require
	 */
 	public function requireChange($id, $required, $table){
 		
 		if (empty($id) || !is_numeric($id))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  parameter id is empty or invalid ";
 			
 		if (!is_numeric($required))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  parameter require flg is empty or invalid ";

 		if ($msg)
 			setErrMsg($msg);
 			
 		
 		$data = array(
	 		'id'			=> $id,
	 		'required' 		=> $required,
	 		'update_date'	=> time()		
	 	);
	 		
	 	$this->DB->post($data, $table);	
 		
 	} // requireChange
 	
 	
 	
 	
 	/**
	 * change display flag
	 * @param $id
	 * @param $display_flg
	 */
 	public function displayChange($id, $display_flg, $table){
 		
 		if (empty($id) || !is_numeric($id))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  parameter id is empty or invalid ";
 			
 		if (!is_numeric($display_flg))
 			$msg[] = $this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  parameter display_flg is empty or invalid ";

 		if ($msg)
 			setErrMsg($msg);
 			
 		
 		$data = array(
	 		'id'			=> $id,
	 		'display_flg' 	=> $display_flg,
	 		'update_date'	=> time()		
	 	);
	 		
	 	$this->DB->post($data, $table);	
 		
 	} // displayChange
 	
 	
 	
 	
 	
 	/**
 	 * change delete flag
 	 * @param $id
 	 */
 	public function delete($id, $table){
 		
 		if (empty($id) || !is_numeric($id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  parameter id is empty or invalid ");
 			
 			
 		$data = array(
	 		'id'			=> $id,
	 		'display_flg' 	=> 0,
	 		'delete_flg' 	=> 1,
	 		'update_date'	=> time()		
	 	);
	 		
	 	
	 	$this->DB->post($data, $table);

	 	
 	} // delete
 
 	
 	
 	 	
 	/**
 	 * display order move up 
 	 * @param $table_id
 	 * @param $table_name
 	 * @param $search_array
 	 */
 	public function moveUp($table_id, $table_name, $search_array = null ){
 		
 		if (empty($table_id) || !is_numeric($table_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table id is empty or invalid ");

 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table_name is empty or invalid ");

 		/**
 		 * search the display order
 		 */ 
		$sql  = " SELECT ";
		$sql .= " id, ";
		$sql .= " order_num ";
		$sql .= " FROM ";
		$sql .= $table_name;
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
		
		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		print_r($sql); print "<br>";
		$row = $this->DB->refer($sql);
		$order_num = $row[0]['order_num'];
			

		
		/**
		 * display order up by id
		 */  
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " order_num = '".($order_num+1)."'";
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".$order_num."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql); print "<br>";
		$this->DB->refer($sql);

		
		
		/**
		 * display order down
		 */ 
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " update_date = '".time()."', ";
		$sql .= " order_num = '".$order_num."'";
		$sql .= " WHERE ";
		$sql .= " id !='".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".($order_num+1)."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql); print "<br>";exit;
		$this->DB->refer($sql);
		
 	
 	} // moveUp
 	
 	
 	
 	
 	
 	
 	/**
 	 * display order move down
 	 * @param $id
 	 * @param $table_name
 	 * @param $search_array
 	 */
 	public function moveDown($table_id, $table_name, $search_array = null ){
 		
 		if (empty($table_id) || !is_numeric($table_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table_id is empty or invalid ");

 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table_name is empty or invalid ");	
 			
		/**
		 * search the display order
		 */ 
		$sql  = " SELECT ";
		$sql .= " id, ";
		$sql .= " order_num ";
		$sql .= " FROM ";
		$sql .= $table_name;
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		$row = $this->DB->refer($sql);
		$order_num = $row[0]['order_num'];
			
		
		
		/**
		 * display order down by id
		 */  
		$sql  = " UPDATE ";
		$sql .= $table_name ;
		$sql .= " SET ";
		$sql .= " order_num = '".($order_num-1)."'";
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".$order_num."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql);	
		$this->DB->refer($sql);
			
		
		
			
		/**
		 * display order up
		 */ 
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " update_date = '".time()."', ";
		$sql .= " order_num = '".$order_num."'";
		$sql .= " WHERE ";
		$sql .= " id != '".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".($order_num-1)."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql);exit;
		$this->DB->refer($sql);
 		
 		
 	} // moveDown
 	
 	
 	
 	
 	/**
 	 * display order move up asc query data 
 	 * @param $table_id
 	 * @param $table_name
 	 * @param $search_array
 	 */
 	public function moveUpAsc($table_id, $table_name, $search_array = null ){
 		
 		if (empty($table_id) || !is_numeric($table_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table_id is empty or invalid ");

 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table_name is empty or invalid ");	
 			
		/**
		 * search the display order
		 */ 
		$sql  = " SELECT ";
		$sql .= " id, ";
		$sql .= " order_num ";
		$sql .= " FROM ";
		$sql .= $table_name;
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		$row = $this->DB->refer($sql);
		$order_num = $row[0]['order_num'];
			
		
		
		/**
		 * display order down by id
		 */  
		$sql  = " UPDATE ";
		$sql .= $table_name ;
		$sql .= " SET ";
		$sql .= " order_num = '".($order_num-1)."'";
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".$order_num."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql);	
		$this->DB->refer($sql);
			
		
		
			
		/**
		 * display order up
		 */ 
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " update_date = '".time()."', ";
		$sql .= " order_num = '".$order_num."'";
		$sql .= " WHERE ";
		$sql .= " id != '".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".($order_num-1)."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql);exit;
		$this->DB->refer($sql);
 		
 		
 	} // moveUpAsc
 	
 	
 	
 	
 	
 	/**
 	 * 
 	 * display order move down asc query data 
 	 * @param $table_id
 	 * @param $table_name
 	 * @param $search_array
 	 */
 	public function moveDownAsc($table_id, $table_name, $search_array = null ){
 		
 		if (empty($table_id) || !is_numeric($table_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table id is empty or invalid ");

 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table_name is empty or invalid ");

 		/**
 		 * search the display order
 		 */ 
		$sql  = " SELECT ";
		$sql .= " id, ";
		$sql .= " order_num ";
		$sql .= " FROM ";
		$sql .= $table_name;
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
		
		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql); print "<br>";
		$row = $this->DB->refer($sql);
		$order_num = $row[0]['order_num'];
			

		
		/**
		 * display order up by id
		 */  
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " order_num = '".($order_num+1)."'";
		$sql .= " WHERE ";
		$sql .= " id='".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".$order_num."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql); print "<br>";
		$this->DB->refer($sql);

		
		
		/**
		 * display order down
		 */ 
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " update_date = '".time()."', ";
		$sql .= " order_num = '".$order_num."'";
		$sql .= " WHERE ";
		$sql .= " id !='".$table_id."' ";
		$sql .= " AND ";
		$sql .= " order_num = '".($order_num+1)."'";
 		
 		if (is_array($search_array)){
			foreach ($search_array as $key => $val){
				$sql .= " AND ";
				$sql .= " ".$key." = '".$val."'";
			}			
		}
		
		//print_r($sql); print "<br>";exit;
		$this->DB->refer($sql);
		
 	
 	} // moveDownAsc
 	
 	
 	
 	/**
 	 * get display order for web
 	 * @param $table_name
 	 * @param $position
 	 * @param $search_array
 	 */
 	public function getDisplayOrderWeb($table_name, $position, $search_array = null){
 		
 		$this->getDisplayOrder($table_name, $position, $search_array, 'web');
 		
 	} // getDisplayOrderAdmin
 	
 	
 	
 	
 	/**
 	 * get display order for segment account table
 	 * @param $table_name
 	 * @param $position
 	 * @return display order
 	 */
 	public function getDisplayOrder($table_name, $position, $search_array = null, $data_panel = null){
 		
 		if (empty($table_name) || !is_string($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table name is empty or invalid");
 			
 		if (empty($position))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: position is empty or invalid");
 			
 			
 		$QB = new QueryBuilder();
 		
 		$QB->setInteger('delete_flg', 0);
 		
 		if ($data_panel == 'web')
 			$QB->setInteger('display_flg', 1);
 		
 		
 		
 		if (is_array($search_array)){
 			foreach ($search_array as $key => $val){
 				$QB->setEqual($key, $val);
 			}
 		}
 		
 		if ($position == 'first')
 			$QB->setOrder(' order_num ASC ');
 		
 		if ($position == 'last')
 			$QB->setOrder(' order_num DESC ');
 		
 		$QB->setLimit(1);	
 		
 		
 		$sql  = " SELECT ";
 		$sql .= " order_num ";
 		$sql .= " FROM "; 
 		$sql .= $table_name;
 		
 		$query_txt = $QB->out($sql);
 		
 		//print_r($query_txt); print "<br><br>";
 		
 		$result = $this->DB->refer($query_txt);

 		
 		if ($result)
 			return $result[0]['order_num'];
 				
 	} // getDisplayOrder
 	
 	
 	
 	
 	
 	/**
 	 * update display order
 	 * @param $id
 	 * @param $table_name
 	 * @param $form_id
 	 * @param $set_id
 	 */
 	public function updateDisplayOrder($id, $table_name, $form_id= null, $set_id=null){
 		
 		if (empty($id) || !is_numeric($id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  id is empty or invalid");
 			
 		if (empty($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  table_name is empty or invalid");
 			
 		/**
 		 * search the display order
 		 */ 
		$sql  = " SELECT ";
		$sql .= " id, ";
		$sql .= " order_num ";
		$sql .= " FROM ";
		$sql .= $table_name;
		$sql .= " WHERE ";
		$sql .= " id='".$id."' ";
 		
 		if (!empty($form_id) && is_numeric($form_id)){
 			$sql .= " AND ";
 			$sql .= " form_id = '".$form_id."'";
 		}
			
		if (!empty($set_id) && is_numeric($set_id)){
			$sql .= " AND ";
			$sql .= " set_id = '".$set_id."'";
		}

		$row = $this->DB->refer($sql);
			
		$order_num = $row[0]['order_num'];
		
		
		/**
 		 * update display order
 		 */ 
		$sql  = " UPDATE ";
		$sql .= $table_name;
		$sql .= " SET ";
		$sql .= " order_num=(order_num-1) ";
		$sql .= " WHERE ";
		$sql .= " order_num > '".$order_num."' ";
		
 		if (!empty($form_id) && is_numeric($form_id)){
 			$sql .= " AND ";
 			$sql .= " form_id = '".$form_id."'";
 		}
			
		if (!empty($set_id) && is_numeric($set_id)){
			$sql .= " AND ";
			$sql .= " set_id = '".$set_id."'";
		}

		$row = $this->DB->refer($sql);
			
		
 		
 	} // updateDisplayOrder
 	
 	
 	
 	
 	
 	
 	/**
 	 * update or insert publish information
 	 * @param $office_id
 	 * @param $segment_id
 	 * @param $info
 	 * @param $admin_id
 	 */
 	public function updatePublishInfo($office_id, $segment_id, $info, $admin_id){
 		
 		if (empty($office_id) || !is_numeric($office_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  office_id is empty or invalid");
 			
 		if (empty($segment_id) || !is_numeric($segment_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  segment_id is empty or invalid");
 			
 		if (empty($info))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  info is empty");	
 			

 		$data = array(
	 		'office_tab_id'	 => $office_id,
	 		'segment_tab_id' => $segment_id,
	 		'admin_user_id'  => $admin_id,
 		);

 		if ($info == 'edit'){
 			$data['edit_date'] = time();
 		}elseif ($info == 'publish') {
 			$data['publish_date'] = time();
 		}
 			
 		$check = $this->getPublishInfo($office_id, $segment_id);

 		
 		if (!empty($check['id'])){
 			$data['id'] = $check['id']; 			
 		}
 		
 		
 		$this->DB->post($data, 'publish_info_tab');

 			
 		
 	} // updatePublishInfo
 	
 	
 	
 	
 	
 	/**
 	 * get publish information table
 	 * @param $office_id
 	 * @param $segment_id
 	 * @return table id
 	 */
 	public function getPublishInfo($office_id, $segment_id){
 		
 		if (empty($office_id) || !is_numeric($office_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  office_id is empty or invalid");
 			
 		if (empty($segment_id) || !is_numeric($segment_id))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg:  segment_id is empty or invalid");
 		
 		$QB = new QueryBuilder();
 		$QB->setInteger('office_tab_id', $office_id);
 		$QB->setInteger('segment_tab_id', $segment_id);
 		
 		$sql  = " SELECT ";
 		$sql .= " id, edit_date, publish_date ";
 		$sql .= " FROM ";
 		$sql .= " publish_info_tab ";
 		
 		$queryTxt = $QB->out($sql);
 		
 		$result = $this->DB->refer($queryTxt);
 		
 		if ($result)
 			return $result[0];
 		
 	} // getPublishInfo
 	
 	
 	
 	
 	/**
 	 * create or alter post form table
 	 * @param $table_name
 	 * @param $database_fields
 	 */
 	public function postFormTable($table_name, $database_fields){
 		
 		if (empty($table_name) || !is_string($table_name))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: table name is empty or invalid");
 			
 		if (empty($database_fields) || !is_array($database_fields))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: database fields is empty or invalid");	
 		
 		
 		/**
 		 * trim table name
 		 */
 		$table_name = trim($table_name);
 		
 		/**
	 	 * check table exists or not in data base
	 	 */
 		$sql = " SELECT ";
 		$sql .= " tables.table_name ";
 		$sql .= " FROM ";
 		$sql .= " information_schema.tables ";
 		$sql .= " WHERE ";
 		$sql .= "table_name = '".$table_name."'";
 		    
 		$table_result = $this->DB->refer($sql);
 		
 		if (empty($table_result)){
 			
 			
 			/**
 			 * create table creation sql
 			 */
 			$table_sql = ' CREATE TABLE IF NOT EXISTS `'.$table_name.'` ( 
 				`id` int(11) NOT NULL auto_increment,
 				`form_id` int(11) NOT NULL,
 				';
 			
 			foreach ($database_fields as $row){
 				$table_sql .= '
 					`'.$row.'` text collate utf8_unicode_ci, ';
 			}
 			
 			$table_sql .= '
 				`display_flg` int(11) NOT NULL default \'1\',
				`delete_flg` int(11) NOT NULL default \'0\',
				`entry_date` text collate utf8_unicode_ci,
				`update_date` text collate utf8_unicode_ci,
				PRIMARY KEY  (`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;';
 			
 			/**
 			 * create table
 			 */
 			$this->DB->refer($table_sql);
 			
 		}else{
 			
 			
 			/**
 			 * search for column and if not exists then add column
 			 */
 			$column_sql_array = array(); 
 			foreach ($database_fields as $row){
 				
 				$column_name_sql = " SHOW COLUMNS FROM `".$table_name."` LIKE '".$row."' ";
 				$column_name_result = $this->DB->refer($column_name_sql);
 				
 				if (empty($column_name_result))
 					$column_sql_array[] = ' ADD COLUMN `'.$row.'` text collate utf8_unicode_ci ';
 				
 			}
 			
 			/**
	 		 * create column creation sql
	 		 */
 			if (!empty($column_sql_array)){
 			
	 			$column_sql = ' ALTER TABLE '.$table_name;
	 			$column_sql .= join(' , ', $column_sql_array);
	 			$column_sql .= ";";
	 			
	 			/**
		 		 * alter table
		 		 */
		 		$this->DB->refer($column_sql);
 			}
 			
 		
 		} // if (empty($table_result)){ 		
	 	 		
 	} // postFormTable
 	
 	
 	
 	
 	/**
 	 * check entry month
 	 * @param $entry_month
 	 * @param $access
 	 * @param $form_id
 	 */
 	public function checkEntryMonth($entry_month, $access, $form_id=null){
 		
 		if (empty($entry_month))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: check month is empty or invalid");
 			
 		if (empty($access) && !is_string($access))
 			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: page view is empty or invalid");
 		
 			
 		/**
	 	 * search for entry month
	 	 */
 		$QB = new QueryBuilder();
 		$QB->setEqual('check_month', $entry_month);
 		$QB->setEqual('page_view', $access);
 		$QB->setLimit(1);
 		
 		if (!empty($form_id) && is_numeric($form_id))
 			$QB->setInteger('form_tab_id', $form_id);
 		
 		$sql  = " SELECT ";
 		$sql .= " check_month ";
 		$sql .= " FROM ";
 		$sql .= " form_report ";
 		
 		$query_txt = $QB->out($sql);
 		
 		$result = $this->DB->refer($query_txt);
 		
 		/**
 		 * if check date does not exist then insert check date
 		 */
 		if (empty($result[0]['check_month'])){
 			
 			$data = array(
	 			'page_view' => $access,
	 			'check_month' => $entry_month, 			
 			);
 			
 			if ($form_id)
 				$data['form_tab_id'] = $form_id;
 			
 			$this->DB->post($data, 'form_report');
 			
 		} // if (empty($result[0]['check_month'])){
 		
 		
 	} // checkEntryMonth
 	
 	
 	
 	
 	
 } // EMBDJP

 
?>