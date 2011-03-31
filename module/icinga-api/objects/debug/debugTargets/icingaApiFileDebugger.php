<?php
/**
 * Debugger that simply prints to a specified file or STD_FILE_OUT
 * @author Jannis Mosshammer <jannis.mosshammer@netways.de>
 *
 */
define("DEFAULT_API_LOG_FILE",dirname(__FILE__)."/../../../log/icingaApi.log");
class icingaApiFileDebugger implements icingaApiDebuggerTargetInterface {
	
	public $breakStyle = "\n";
	
	public function __construct(array $params = array()) {
		if(isset($params["break"]))
			$this->breakStyle = $params["break"];
		if(isset($params["file"]))	
			$this->outFile = $params["file"];
		else 
			$this->outFile = DEFAULT_API_LOG_FILE;
	
	}


	public function out($msg) {
		// Check if logfile can be written
		if(file_exists($this->outFile))
			if(!is_writable($this->outFile))
				return false;
		else 
			if(!is_writable(dirname($this->outFile)))
				return false;
				
		$msg = date("c")." - ".$msg.$this->breakStyle;
		file_put_contents($this->outFile,$msg,FILE_APPEND);
	}
}