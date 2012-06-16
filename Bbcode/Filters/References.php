<?php

/**
 * Odnośniki
 * @package Parser
 * @subpackage Filters
 * @author K13
 * @version 0.1
 */
class BbCodeFilterReferences {
	
	protected $_references = array();
	
	public $tags = array(
		'ref' => array(
			'open' => 'span',
			'close' => 'span',
			'parse_body' => 'parseReferences',
			'attributes' => array(
				'ref' => array(
					'type' => 'string'
				)
			),
		)
	);
	
	
	public function parseReferences($tag, &$openNode, &$body, &$closeNode, $settings){
		
		$id = count($this->_references)+1;
		$name = $openNode['attributes']['tag_attributes']['ref'];
		$descr = $body[0]['text'];
		
		$exists = false;
		
		foreach($this->_references as $key=>$ref){
			if($ref['name'] === $name && $ref['descr'] === $descr){
				$exists = true;
				$id = (int)$key+1;
			}
		}
		
		$openNode['text'] = '<sup><a href="#ref_'.$id.'">';
		$body[0]['text_html'] = '['.$id.']';
		$closeNode['text'] = '</a></sup>';
		
		if(!$exists){
			$this->_references[] = array(
				'id'	=> $id,
				'name'	=> $name,
				'descr'	=> $descr
			);
		}
	}
	
	public function getReferences(){
		return $this->_references;
	}
	
}

?>