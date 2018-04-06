# Schema-MySQL-Create-Database-Table
Like Laravel Schema

Example use
```<?php
Schema::create("users",function($table){

	$table->increment('id');
	$table->float('para',3,5);
	$table->varchar('name',30)->varchar('surname',30);

	$table->last_column = true; //you should do last column before for jump to mysql syntax error (comma)

	$table->varchar('email',30);

	$table->compile(); //compile to sql string

	echo $table; //compiled sql string
});
```
