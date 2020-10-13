<?php 

/*-
----
SQLModel Class
*/
class SQLModel implements QueryBuilderInterface {

	protected $database = null;
	protected $table    = null;
	protected $query;
    protected $connect;

	public function __construct() {
		$this->connect = DB::connect($this->database);
	}

	/*-
	----
	Builder Container Class
	*/
    protected function reset()
    {
        $this->query = new \stdClass;
    }

    /*-
    ----
    Defining table
    */
    public function table($table) {
        $this->table = $table;

        return $this;
    }

    /*-
    ----
    Build a custom Query
    */
    public function query($sql) {
        $this->reset();
        $this->query->base = $sql;

        return $this;
    }

    /*-
    ----
    Build a base SELECT Query
    */
    public function insert($fields, $value) {

        $this->reset();
        if (!is_array($value)) {
            $this->query->base = "INSERT INTO " . $this->table . " (" . $fields . ")" ." VALUES ('".Security::escapeInput($value)."'";
        }else {
            $this->query->base = "INSERT INTO " . $this->table . " (" . $fields . ")" ." VALUES (";
            for($i=0; $i<count($value); $i++) {
                if ($i == count($value)-1) {
                    $this->query->base .= "'".Security::escapeInput($value[$i])."'";
                }else {
                    $this->query->base .= "'".Security::escapeInput($value[$i])."', ";
                }
            }
        }
        $this->query->base .= ")"; 
        $this->query->type = 'insert';

        return $this;
    }

    /*-
	----
	Build a base SELECT Query
	*/
	public function select($fields) {

		$this->reset();
        $this->query->base = "SELECT " . $fields . " FROM " . $this->table;
        $this->query->type = 'select';

        return $this;
	}

    /*-
    ----
    Build a base DELETE Query
    */
    public function delete() {

        $this->reset();
        $this->query->base = "DELETE FROM " . $this->table;
        $this->query->type = 'delete';

        return $this;
    }

    /*-
    ----
    Build a base MULTI DELETE Query
    */
    public function multiDelete($dbId, $id) {

        $this->reset();
        $this->query->base = "DELETE FROM " . $this->table." WHERE $dbId IN($id)";
        $this->query->type = 'multiDelete';

        return $this;
    }

    /*-
    ----
    Build a base UPDATE Query
    */
    public function update($field, $value) {
        
        $this->reset();
        $this->query->base = "UPDATE ".$this->table." SET ";
        $this->query->type = 'update';
        $field = explode(',', $field);
        $value = explode(',', $value);
        
        for ($i=0; $i<=count($field)-1 ; $i++) { 

            if ($i < count($field)-1) {
                $this->query->base .= $field[$i].'='."'".Security::escapeInput($value[$i])."', ";
            }else {
                $this->query->base .= $field[$i].'='."'".Security::escapeInput($value[$i])."'";
            }

        }

        return $this;
    }

	/*-
	----
	Add WHERE Condition
	*/
    public function where($field, $value, $operator = '=') {

        $value = Security::escapeInput($value);

    	if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }

        $this->query->where[] = $field.$operator."'".$value." '";

        return $this;
    }

    /*-
	----
	Add LIMIT Condition
	*/
    public function limit($start, $offset) {

    	if (!in_array($this->query->type, ['select'])) {
            throw new \Exception("LIMIT can only be added to SELECT");
        }
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    /*-
	----
	Add ORDER Condition
	*/
    public function orderBy($fields, $desc) {
    	if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception("WHERE can only be added to SELECT, UPDATE OR DELETE");
        }
        if ($desc == null) {
        	$this->query->order = " ORDER BY ".$fields;
        }else {
        	$this->query->order = " ORDER BY ".$fields." DESC";
        }

        return $this;
    }

    /*-
    ----
    Add innerjoin condition
    */
    public function innerJoin($table, $column1, $column2) {
        $this->query->innerJoin = " INNER JOIN ".$table." ON ".$column1." = ".$column2;

        return $this;
    }

    /*-
    ----
    Add innerjoin condition
    */
    public function leftJoin($table, $column1, $column2) {
        $this->query->leftJoin = " LEFT JOIN ".$table." ON ".$column1." = ".$column2;

        return $this;
    }

    /*-
    ----
    Add innerjoin condition
    */
    public function rightJoin($table, $column1, $column2) {
        $this->query->rigthJoin = " RIGHT JOIN ".$table." ON ".$column1." = ".$column2;

        return $this;
    }

    /*-
    ----
    Add fulljoin condition
    */
    public function fullJoin($table, $column1, $column2) {
        $this->query->fullJoin = " FULL OUTER JOIN ".$table." ON ".$column1." = ".$column2;

        return $this;
    }

    /*-
    ----
    Getting last inserted ID
    */
    public function lastID() {
        return $this->connect->lastInsertId();
    }

    /*-
	----
	Getting Query to Execute
	*/
    public function getQuery() {
    	$query = $this->query;
        $sql = $query->base;

        // Checking innerjoin condition exists or not
        if (isset($query->innerJoin)) {
            $sql .= $query->innerJoin;
        }
        // Checking leftjoin condition exists or not
        if (isset($query->leftJoin)) {
            $sql .= $query->leftJoin;
        }
        // Checking rightjoin condition exists or not
        if (isset($query->rightJoin)) {
            $sql .= $query->rightJoin;
        }
        // Checking fulljoin condition exists or not
        if (isset($query->fullJoin)) {
            $sql .= $query->fullJoin;
        }
        // Checking where condition exists or not
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        // Checking limit condition exists or not
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        // Checking order condition exists or not
        if (isset($query->order)) {
            $sql .= $query->order;
        }
        $sql .= ";";
        return $sql;
    }

    /*-
    ----
    Executing the Query
    */
    public function fetch($query) {
        $statement = $this->connect->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    /*-
    ----
    Inserting
    */
    public function run($query) {
        $statement = $this->connect->prepare($query);
        return $statement->execute();
    }

    /*-
    ----
    Counting the number of row
    */
    public function rowCount($query) {
        $statement = $this->connect->prepare($query);
        $statement->execute();
        return $statement->rowCount();
    }

}

 ?>