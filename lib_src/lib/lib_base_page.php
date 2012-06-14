<?
// --------------------------------------------------------------------------------
//	ページ管理クラス
//	********* 【 class PageClass 】*****************************
//				「前へ」，「次へ」のリンクを作成するためのクラス
//
//				コンストラクタ
//				PageClass($numRows, $pageNumber, $limit)
//				
//				int getLastPageNumber()
//						最後のページ番号を得る
//				int isNext()
//						次のページがあるか？(1: ある，0: ない)
//				int isPrev()
//						前のページがあるか？(1: ある，0: ない)
//				String getNextStr()
//						次のページのリンク文字列 (戻り値の例："pn=2&un=20": ページ番号 2 で，表示件数 20)
//				String getPrevStr()
//						前のページのリンク文字列
//				String getFirstStr()         (戻り値の例："pn=0&un=20": ページ番号 0 で，表示件数 20)
//						最初のページのリンク文字列
//				String getLastStr()
//						最後のページのリンク文字列
//				String getThisStr()
//						このページのリンク文字列
//	********* 【 依存関係 】************************************
//				fatalError()
// --------------------------------------------------------------------------------

/*
********* 【 使用例 】**************************************

$page = new PageClass($numRows, $pn, $un);
if($page->isPrev()){
	printf("<a href=\"%s?%s\">←</a>", $progName, $page->getPrevStr());
}
if( ($page->isPrev() + $page->isNext()) == 2)
{ // 前と後ろ両方 表示しないといけないので，セパレータ表示
	printf("｜");
}
if($page->isNext()){
	printf("<a href=\"%s?%s\">→</a>　", $progName, $page->getNextStr());
}


「 ←｜→ 」 みたいなナビゲータのいっちょあがり
*/


class PageClass{
	
	/**
	 * ページ番号 として使う変数名
	 */
	var $pageNumberStr = "pn";
	
	/**
	 * @var unknown_type
	 */
	var $limitStr = "un";
	
	/**
	 * ヒット数，ページ番号，一ページ当たりの表示件数
	 */
	var $numRows, $pageNumber, $limit;
	
	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
	
	function PageClass($numRows, $pageNumber, $limit)
	{
		/**
 		 * set file name
 		 */
 		$path = pathinfo(__FILE__);
 		$this->file_name = $path['filename'];
 		
		if( ($numRows < 0) || ($limit < 1) ){
			fatalError("ページ指定が矛盾しています(numRows=${numRows},pageNumber=${pageNumber},limit=${limit})",
				$this->file_name,__LINE__);
		}
		$this->numRows  = $numRows;
		$this->limit  = $limit;
		// ↓ ページ番号は，なるべく補正するように努力する方針で
		$pageNumber = sprintf("%d", $pageNumber);
		$pageNumber = ($pageNumber < 0) ? 0 : $pageNumber;
		$this->pageNumber = ( $pageNumber <= $this->getLastPageNumber() ) ? $pageNumber : $this->getLastPageNumber()+1;
		// ↑ ページ番号補正終了
	}
	
	// ０ページ目から始まる
	// ページがなければ 0
	// コンストラクタとインタフェースを同じにするために，要らないけど $pageNumber も引数として必要
	// (注)普通に使うときは，引数なしで使ってね
	function getLastPageNumber($numRows="", $pageNumber="", $limit=""){
		$numRows     = !strlen($numRows)     ? $this->numRows     : $numRows;
		$pageNumber = !strlen($pageNumber) ? $this->pageNumber : $pageNumber;
		$limit = !strlen($limit) ? $this->limit : $limit;
		
		$return = ( $numRows ) ?
			intval( ($numRows - 1) / $limit ) : 0;
		return($return);
	}
	
	
	function isPrev()
	{
		if ($this->pageNumber <=1)
			return 0;
		else 
			return 1;	
	}
	
	
	function isNext()
	{
		return(
			($this->pageNumber <= $this->getLastPageNumber())    ? 1 : 0
		);
	}
	
	
	function getPrevStr()
	{
		if($this->pageNumber <= 0)
		{
			fatalError(
				sprintf("なんで最初のページなのに呼ぶの？(pageNumber=%d)",
					$this->pageNumber, $this->getLastPageNumber() ),
				$this->file_name,
				__LINE__ );
		}
		return(
			sprintf("%s=%d&%s=%d", $this->pageNumberStr, $this->pageNumber - 1, $this->limitStr, $this->limit)
		);
	}
	
	
	function getNextStr()
	{
		if($this->getLastPageNumber() <= $this->pageNumber)
		{
			fatalError(
				sprintf("なんで最後のページなのに呼ぶの？(pageNumber=%d,lastPageNumber=%d)",
					$this->pageNumber, $this->getLastPageNumber() ),
				$this->file_name,
				__LINE__ );
		}
		return(
			sprintf("%s=%d&%s=%d", $this->pageNumberStr, $this->pageNumber + 1, $this->limitStr, $this->limit)
		);
	}
	
	
	function getFirstStr()
	{
		if($this->pageNumber <= 0)
		{
			fatalError(
				sprintf("なんで最初のページなのに呼ぶの？(pageNumber=%d)",
					$this->pageNumber, $this->getLastPageNumber() ),
				$this->file_name,
				__LINE__ );
		}
		return(
			sprintf("%s=0&%s=%d", $this->pageNumberStr, $this->limitStr, $this->limit)
		);
	}
	
	function getLastStr()
	{
		if($this->getLastPageNumber() <= $this->pageNumber)
		{
			fatalError(
				sprintf("なんで最後のページなのに呼ぶの？(pageNumber=%d,lastPageNumber=%d)",
					$this->pageNumber, $this->getLastPageNumber() ),
				$this->file_name,
				__LINE__ );
		}
		return(
			sprintf("%s=%d&%s=%d", $this->pageNumberStr, $this->getLastPageNumber(), $this->limitStr, $this->limit)
		);
	}
	
	function getThisStr()
	{
		return(
			sprintf("%s=%d&%s=%d", $this->pageNumberStr, $this->pageNumber, $this->limitStr, $this->limit)
		);
	}
	
	
	
	function DisPage($link_url){
		
		$un = $this->limit;
		//$this->cPage =$this->pageNumber+1;
		$this->cPage =$this->pageNumber;
	
		$p_count=intval(($this->numRows)/$un);
    	$extra_p=(($this->numRows)%$un);
    
    	if($extra_p){
    		$total_page = $p_count+1;
    	}else{
    		$total_page =$p_count;
   	 	}
    
    	$this->total_page = $total_page;
    
		$total_page = $this->total_page;
  	 
    	if($total_page>10){
     	
     		$display_pages_set= intval($total_page/10);
    		$extra_display_page=$total_page%10;
    		
    			for($i=1;$i<=$display_pages_set;$i++){
    	 	    	 		
    		    	if(($this->cPage)>=($i*10+1) && ($this->cPage)<=(($i+1)*10)){
    	 				$current = $i*10;
    	 			}
    	 		
    	 			if($current == ($i*10)){
    					if($extra_display_page && $i==$display_pages_set){
    						$start=$i*10+1;
    						$end = $start+$extra_display_page-1;
    					}else{
    					
    						$start=$i*10+1;
    						$end = $start+9;
    					}
    	  			}else if($current < 10){
    	  				$start=1;
    	  				$end = 10;
    	  			}
    			}
    	
    		
    			for($i=$start;$i<=$end;$i++){
    				if($this->cPage == $i){
    					$page_number .='<li><span >'.$i.'</span></li>';
    				}
    				else if($i==$end){
    					$page_number .='<li><a href="'.sprintf("%s/page/%d",$link_url,$i).'">'.$i."</a></li>";
    				}else{
    					$page_number .='<li><a href="'.sprintf("%s/page/%d",$link_url,$i).'">'.$i."</a></li>";	
    				}
    			}
 
    	}else if($total_page<=10){
    		$start=1;
    		$end=$total_page;
    
    		for($i=$start;$i<=$end;$i++){
    			if($this->cPage==$i){
    				$page_number .='<li><span>'.$i.'</span></li>';
    			}
    			else if($i==$end){
    				$page_number .='<li><a href="'.sprintf("%s/page/%d",$link_url,$i).'">'.$i."</a></li>";
    			}else{
    				$page_number .='<li><a href="'.sprintf("%s/page/%d",$link_url,$i).'">'.$i."</a></li>";	
    			}
    		}
    	}
   
   	  $this->page_number = $page_number;
   
  	  // print_r($page_number);
    
   	  return $page_number; 
	}

	
}
?>