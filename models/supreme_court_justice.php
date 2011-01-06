<?php
/*
+------------+------------------+------+-----+---------+----------------+
| Field      | Type             | Null | Key | Default | Extra          |
+------------+------------------+------+-----+---------+----------------+
| id         | int(10) unsigned | NO   | PRI | NULL    | auto_increment | 
| birthday   | datetime         | YES  |     | NULL    |                | 
| first_day  | datetime         | YES  |     | NULL    |                | 
| appt_by    | varchar(50)      | YES  |     | NULL    |                | 
| first_name | varchar(50)      | YES  |     | NULL    |                | 
| last_name  | varchar(50)      | YES  |     | NULL    |                | 
+------------+------------------+------+-----+---------+----------------+
*/
class SupremeCourtJustice extends AppModel {
    var $name = 'SupremeCourtJustice';

}

?>