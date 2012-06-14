<?php

/**
 * RssParserClass.inc.php
 * 
 * @created on 2011/08/21
 * @package    FORM
 * @subpackage Rss Parser
 * @author     Arefin Tuhin
 * @version    Id: profile 2692 2011/08/21-15:41:52 fabien 
 * 
 *File content
     RssParserClass.inc.php
 *     
 */
  
 
 /**
  * rss parser class use for 
  * get rss data
  * get channel data
  * get item data
  * @author arefin
  */

 class RssParserClass {
	
 	/**
 	 * document instance
 	 */
	public $document;
	
	/**
	 * channel instance
	 */
	public $channel;
	
	/**
	 * items instance
	 */
	public $items;

	
 	/**
 	 * file name instance
 	 */
 	protected $file_name;
 	
 	
 	
 	/**
 	 * construct
 	 */
 	function __construct(){
 		
 		/**
		 * set file name
		 */
		$path = pathinfo(__FILE__);
		$this->file_name = $path['filename'];					
						
 		
 		
 	} // __construct
 	
 	
	
	/**
	 * load RSS from URL
	 */
	public function load($url=false, $unblock=true) {
		
		if (empty($url))
			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: url is empty or invalid");
			
			
		if($unblock)
			$this->loadParser(file_get_contents($url, false, $this->randomContext()));
		else
			$this->loadParser(file_get_contents($url));
		
	
	} // load
	
	
	
	/**
	 * load raw RSS data
	 */
	public function loadRSS($rawxml=false) {

		if (empty($rawxml))
			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: raw xml is empty or invalid");
		
		
		$this->loadParser($rawxml);
		
	
	} // loadRSS

	
	
	
	/**
	 * public load methods
	 * @param $includeAttributes
	 * @return return full rss array
	 */
	public function getRSS($includeAttributes=false) {

		if($includeAttributes)
			return $this->document;
		else 
			return $this->valueReturner();
		
	} // getRSS
	
	
	
	/**
	 * get channel data
	 * @return channel data
	 */
	public function getChannel($includeAttributes=false) {

		if($includeAttributes)
			return $this->channel;
		else
			return $this->valueReturner($this->channel);
			
	} // getChannel
	
	
	
	/**
	 * get item data 
	 * @return rss items
	 */
	public function getItems($includeAttributes=false) {

		if($includeAttributes)
			return $this->items;
		else
			return $this->valueReturner($this->items);
	
	} // getItems
	
	
	
	/**
	 * load rss parser
	 */
	private function loadParser($rss=false) {
		
		//print $rss;exit;
		
		if (empty($rss))
			setErrMsg($this->file_name." Line : ".__LINE__." <br /> Method: ".__METHOD__." <br /> Msg: rss is empty or invalid");
			
		$this->document = array();
		$this->channel = array();
		$this->items = array();
		$DOMDocument = new DOMDocument;
		$DOMDocument->strictErrorChecking = false;
		$DOMDocument->loadXML($rss);
		$this->document = $this->extractDOM($DOMDocument->childNodes);
		
		
	} // loadParser
	
	
	
	
	/**
	 * rss value returner
	 */ 
	private function valueReturner($valueBlock=false) {
		
		if(!$valueBlock) {
			$valueBlock = $this->document;
		}
		
		
		foreach($valueBlock as $valueName => $values) {
			
			if(isset($values['value']))
				$values = $values['value'];
			

			if(is_array($values))
				$valueBlock[$valueName] = $this->valueReturner($values);
			else
				$valueBlock[$valueName] = $values;
			
			
		} // foreach($valueBlock as $valueName => $values) {
		
		
		return $valueBlock;
	
	} // valueReturner
	
	
	
	
	/**
	 * extract rss containt
	 */ 
	private function extractDOM($nodeList,$parentNodeName=false) {
		
		
		$itemCounter = 0;
		foreach($nodeList as $values) {
			
			
			
			if(substr($values->nodeName,0,1) != '#') {

				if($values->nodeName == 'item') {
					$nodeName = $values->nodeName.':'.$itemCounter;
					$itemCounter++;
				} else {
					$nodeName = $values->nodeName;
				}
				
				
				$tempNode[$nodeName] = array();				
				
				
				if($values->attributes) {
					for($i=0;$values->attributes->item($i);$i++) {
						$tempNode[$nodeName]['properties'][$values->attributes->item($i)->nodeName] = $values->attributes->item($i)->nodeValue;
					}
				}
				
				
				if(!$values->firstChild) {
					$tempNode[$nodeName]['value'] = $values->textContent;
				} else {
					
					$tempNode[$nodeName]['value']  = $this->extractDOM($values->childNodes, $values->nodeName);
				}
				
				
				
				if(in_array($parentNodeName, array('channel','rdf:RDF'))) {
					if($values->nodeName == 'item') {
						$tempNode['itemCounter'] = $itemCounter;
						$this->items[] = $tempNode[$nodeName]['value'];
					} elseif(!in_array($values->nodeName, array('rss','channel'))) {
						$this->channel[$values->nodeName] = $tempNode[$nodeName];
					}
				}
				
				
			} elseif(substr($values->nodeName,1) == 'text') {
				
				$tempValue = trim(preg_replace('/\s\s+/',' ',str_replace("\n",' ', $values->textContent)));
					
				if($tempValue != "") {
					$tempNode = $tempValue;
				}
			} elseif(substr($values->nodeName,1) == 'cdata-section'){
				$tempNode = $values->textContent;
			}
		}
		
		
		return $tempNode;
	
	} // extractDOM
	
	
	
	
	/**
	 * get random context of rss
	 */ 
	private function randomContext() {
		
		
		$headerstrings = array();
		$headerstrings['User-Agent'] = 'Mozilla/5.0 (Windows; U; Windows NT 5.'.rand(0,2).'; en-US; rv:1.'.rand(2,9).'.'.rand(0,4).'.'.rand(1,9).') Gecko/2007'.rand(10,12).rand(10,30).' Firefox/2.0.'.rand(0,1).'.'.rand(1,9);
		$headerstrings['Accept-Charset'] = rand(0,1) ? 'en-gb,en;q=0.'.rand(3,8) : 'en-us,en;q=0.'.rand(3,8);
		$headerstrings['Accept-Language'] = 'en-us,en;q=0.'.rand(4,6);
		$setHeaders = 	'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'."\r\n".
						'Accept-Charset: '.$headerstrings['Accept-Charset']."\r\n".
						'Accept-Language: '.$headerstrings['Accept-Language']."\r\n".
						'User-Agent: '.$headerstrings['User-Agent']."\r\n";
		
		
		$contextOptions = array(
			'http'=>array(
				'method'=>"GET",
				'header'=>$setHeaders
			)
		);
		
		
		return stream_context_create($contextOptions);
	
	} // randomContext
	
 
 } // RssParserClass
 

?>