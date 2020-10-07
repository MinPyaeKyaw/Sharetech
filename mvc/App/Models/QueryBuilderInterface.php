<?php 

/*-
----
Query Builder Interface
*/
interface QueryBuilderInterface {

	public function table($table);

	public function query($sql);

	public function insert($fields, $value);

	public function select($fields);

	public function delete();

	public function update($field, $value);

    public function where($field, $value, $operator = '=');

    public function limit($start, $offset);

    public function orderBy($fields, $desc);

    public function innerJoin($table, $column1, $column2);

    public function leftJoin($table, $column1, $column2);

    public function rightJoin($table, $column1, $column2);

    public function fullJoin($table, $column1, $column2);

    public function lastID();

    public function getQuery();

    public function rowCount($query);

    public function run($query);

    public function fetch($query);
    
}



 ?>