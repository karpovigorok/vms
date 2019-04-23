<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php

class Hvconfig {

	private $cfg = array();
	private $config_file = './config.php';

	public function __construct(){
		$this->cfg = include $this->config_file;
	}

	public function getConfig(){
		return $this->cfg;
	}

	public function add($key, $value){
		$this->cfg[$key] = $value;
	}

	public function delete($key, $value){

	}

	public function updateConfig(){

		$results = var_export($this->cfg, true);
		$config_string = "<?php return " . $results . ";";
		return file_put_contents($this->config_file, $config_string);

	}

}