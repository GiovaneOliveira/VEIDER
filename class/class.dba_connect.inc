<?
    class dba_connect
    {
        var $conn = null;
        var $reg = 0;
        
        function dba_connect() {
            $conn = mssql_connect("Giovane-PC\SQLEXPRESS", "sa", "111111");
            
            if($conn) {
                mssql_select_db("VEIDER", $conn);
            } else {
                error_log("Erro ao conectar com o banco de dados.");
            }
            
            $this->conn = $conn;
        }
        
        function query($query) {
            $sql = mssql_query($query, $this->conn);
            
            if($sql) {
                $fields = array();
                
                do {
                    $exec = mssql_fetch_array($sql);
                    
                    if($exec) {
                        foreach($exec as $key => $value) {
                            if(strlen($key) > 4) {
                                $fields[$this->reg][strtolower($key)] = $value;
                            }
                        }
                        $this->reg++;
                    }
                    
                    mssql_next_result($sql);
                }while($exec != "");
                
                return $fields;
                
            } else {
                error_log("Erro ao executar query.");
                return null;
            }
            
        }
		
		function getNextCode($table,$column)
		{
			$sql = "SELECT COALESCE((MAX(".$column.")+1),1) AS result FROM ".$table;
			
			$ex = $this->query($sql);
			
			return $ex[0]['result']; 
		}
        
		function executeDBA($query)
		{
			mssql_query($query, $this->conn);
		}
    }
?>