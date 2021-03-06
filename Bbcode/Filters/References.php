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
		
		$id = count($this->references)+1;
		$name = $openNode['attributes']['tag_attributes']['ref'];
		$descr = $body[0]['text'];
		
		$exists = false;
		
		foreach($this->references as $key=>$ref){
			if($ref['name'] === $name && $ref['descr'] === $descr){
				$exists = true;
				$id = (int)$key+1;
			}
		}
		
		$openNode['text'] = '<sup><a href="#ref_'.$id.'">'.'['.$id.']'.'</a></sup>';
		$closeNode['text'] = '';
		
		reset($body);
		$body[0]['tagText'] = $body[0]['text'];
		$body[0]['text'] = '';
		
		if(!$exists){
			$this->references[] = array(
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