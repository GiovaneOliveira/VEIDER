<?
	class dba_connect
	{
		var $conn = null;
		var $reg = 0;
		
		function dba_connect()
        {
			$conn = mssql_connect("Giovane-PC\SQLEXPRESS", "sa", "111111");
			
			if($conn) {
				mssql_select_db("VEIDER", $conn);
			} else {
				error_log("Erro ao conectar com o banco de dados.");
			}
			
			$this->conn = $conn;
		}
		
        function close()
        {
            mssql_close($this->conn);
        }
        
		function query($query)
        {
			$this->reg = 0;

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
		
		function getNextCode($table, $column)
		{
			$sql = "SELECT COALESCE((MAX(".$column.")+1),1) AS RESULT FROM ".$table;
			$ex = $this->query($sql);
			
			return $ex[0]['result']; 
		}
		
		function insert($query)
		{
			mssql_query($query, $this->conn);
		}
		
		/*
		*		Funзгo para executar comandos INSERT, UPDATE, DELETE
		*		
		*		@param string	$type = insert, update ou delete
		*		@param array		$table = deve ser passado um array com no mнnimo a chave "table"=>"NOMETABELA" para quando for update ou delete	
		*											quando for insert devem ser passadas as chaves "table"=>"NOMETABELA" e 'primarykey'=>'CAMPOPRIMARYKEY'
		*		@param array		$fields = array com "NOMECAMPO"=>"VALORCAMPO"
		*		@param array		$where = deve ser passado array no padrгo "CONDICAO=CONDICAO"=>" OR/AND "
		*		
		*		@warning
		*				Nos valores do array $where deve conter um espaзo antes e depois do OR/AND para concatenar corretamente
		*
		*/
		function transaction($type, $table, $fields, $where = "")
		{
			$field = ""; $value = ""; $whereStr = "";
			$type = strtoupper($type);
			
			if( !empty($where)) {
				$whereStr = " WHERE 1=1";
				foreach($where as $key => $value) {
					$whereStr .= $value.$key;
				}
			}
			
			$transaction = "
				BEGIN TRANSACTION
				BEGIN TRY
			";
			
			switch($type)
			{
				case "INSERT":
					$transaction .= "
						DECLARE @PRIMARYKEY INT;
						SET @PRIMARYKEY = (SELECT COALESCE((MAX(".$table['primarykey'].")+1), 1) FROM ".$table['table'].");
					";
					
					$field .= $table['primarykey'].", ";
					$value .= "@PRIMARYKEY, ";
					
					foreach($fields as $key => $values) {
						$field .= $key.", ";
						$value .= $values.", ";
					}
					
					$transaction .= "
						INSERT INTO ".$table['table']." (
							".substr($field, 0, -2)."
						) VALUES (
							".substr($value, 0, -2)."
						)";
				break;
				
				case "UPDATE":
					foreach($fields as $key => $values) {
						$field .= $key."=".$values.", ";
					}
					
					$transaction .= "
						UPDATE ".$table['table']." SET 
						".substr($field, 0, -2).$whereStr;
				break;
				
				case "DELETE":
					$transaction .= "
						DELETE FROM ".$table['table'].$whereStr;
				break;
			}
			
			$transaction .= "
					COMMIT TRANSACTION
				END TRY
				
				BEGIN CATCH
					DECLARE @ErrorMessage NVARCHAR(4000);
					DECLARE @ErrorSeverity INT;
					DECLARE @ErrorState INT;
					
					SELECT
						@ErrorMessage = ERROR_MESSAGE(),
						@ErrorSeverity = ERROR_SEVERITY(),
						@ErrorState = ERROR_STATE();
					
					RAISERROR (
						@ErrorMessage,
						@ErrorSeverity,
						@ErrorState
					);
					ROLLBACK TRANSACTION
				END CATCH
			";
			
			$execution = mssql_query($transaction);
			
			if( !$execution) {
				error_log("Erro ao executar transaзгo.");
				return false;
			}
			else {
				return true;
			}
		}
		
        function formatString($string)
        {
            return "'".$string."'";
        }
        
        function selectID($prefix, $cdfield, $table)
        {
            $id = "(SELECT '".$prefix."'+(SELECT CAST(MAX(".$cdfield.")+1 AS VARCHAR) FROM ".$table."))";
            return $id;
        }
        
		function protectStr($field, $value, $percent = true)
		{
			$percent = $percent? "%" : "";
			$value = $percent.$value.$percent;
			$sql = " ".$field." LIKE (".str_replace("\\''", "'", "'".str_replace("'", "''", $value)."'").") ";
			return $sql;
		}
	}
?>