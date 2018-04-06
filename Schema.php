class SchemaTable{
	public $table_name;
	public $result;

	public $pretty = true;
	public $pretty_type = "backspace"; //html

	public $last_column = false;

	private function do_pretty(){
		return $this->pretty ? ($this->pretty_type == "html" ? "<br>" : "\n\r\t") : "";
	}

	private function check_last_column(){
		return $this->last_column ? "" : ",";
	}

	public function __construct($table_name){
		$this->table_name = $table_name;
		$this->result = "CREATE TABLE ".$this->table_name." (".$this->do_pretty();
	}

	public function __destruct(){
		$this->result .= ")";
	}

	public function compile(){
		$this->result .= ")";
	}

	public function __toString() {
        return $this->result;
    }

    private function protocol(){
    	return $this->check_last_column().$this->do_pretty();
    }

    private function notnull($notnull){
    	return $notnull ? " NOT NULL":$this->check_last_column();
    }

    private function column($function,$column_name,$limit=null,$offset=null,$notnull=null){
    	if($limit != null && $offset == null){
    		return $column_name." ".strtoupper($function)."(".$limit.") ".$this->notnull($notnull).$this->protocol();
    	}

    	if($limit == null && $offset == null){
    		return $column_name." ".strtoupper($function).$this->notnull($notnull).$this->protocol();
    	}

    	if($limit != null && $offset != null){
    		return $column_name." ".strtoupper($function)."(".$limit.",".$offset.")".$this->notnull($notnull).$this->protocol();
    	}

    }

    //Data Types

    public function increment($column_name){
    	$this->result .= $column_name." INT(11) AUTO_INCREMENT PRIMARY KEY".$this->protocol();
    	return $this;
    }

    public function varchar($column_name,$limit,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset=null,$notnull);
    	return $this;
    }

    public function text($column_name,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	return $this;
    }

    public function json($column_name,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	return $this;
    }

    public function boolean($column_name,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	return $this;
    }

    public function int($column_name,$limit,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset=null,$notnull);
    	return $this;
    }

    public function tinyint($column_name,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	return $this;
    }

    public function smallint($column_name,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	return $this;
    }

    public function mediumint($column_name,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	return $this;
    }

    public function decimal($column_name,$limit,$offset=0,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset,$notnull);
    	return $this;
    }

    public function float($column_name,$limit,$offset=0,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset,$notnull);
    	return $this;
    }

    public function real($column_name,$limit,$offset=0,$notnull=true){
    	$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset,$notnull);
    	return $this;
    }

    public function bit($column_name,$limit,$notnull=true){
    	if($limit == null || $limit == 0)
    		$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	else
    		$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset=null,$notnull);
    	return $this;
    }

    public function binary($column_name,$limit,$notnull=true){
    	if($limit == null || $limit == 0)
    		$this->result .= $this->column(__FUNCTION__,$column_name,$limit=null,$offset=null,$notnull);
    	else
    		$this->result .= $this->column(__FUNCTION__,$column_name,$limit,$offset=null,$notnull);
    	return $this;
    }

    public function enum($column_name,array $arr){
    	$enums = $column_name." ".strtoupper(__FUNCTION__)."(";
    	foreach ($arr as $key => $value) {
    		if($key < count($arr)-1){
    			$enums .= "'".$value."', ";
    		}else{ //last
    			$enums .= "'".$value."'";
    		}
    	}
    	$enums .= ")".$this->notnull($notnull).$this->protocol();
    	$this->result .= $enums;
    }

    public function set($column_name,array $arr){
    	$enums = $column_name." ".strtoupper(__FUNCTION__)."(";
    	foreach ($arr as $key => $value) {
    		if($key < count($arr)-1){
    			$enums .= "'".$value."', ";
    		}else{ //last
    			$enums .= "'".$value."'";
    		}
    	}
    	$enums .= ")".$this->notnull($notnull).$this->protocol();
    	$this->result .= $enums;
    }

}

class Schema{
	public static function create($table_name, Closure $callback = null){
		$table = new SchemaTable($table_name);
		$callback($table);
	}
}
