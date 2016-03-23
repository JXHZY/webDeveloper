<?php
include_once 'db_connect.php';

/*Design SQL which lists user(s) with biggest total salary from April to November.
Show user name and overall salary amount*/

$sql = "SELECT user.name AS NAME,user.id AS ID,SUM(salary.sum) AS SUMMARY FROM salary,user WHERE user.id = salary.userId AND salary.saldate BETWEEN '2016-04-01' AND '2016-12-30' GROUP BY salary.userId";
//$result = mysql_query($sql);
$result = $mysqli->query($sql);
foreach($result as $v)
{
  echo "NAME:" .$v['NAME'] . "&nbsp&nbsp&nbspID:" . $v['ID']. "&nbsp&nbsp&nbspSUMMARY:" . $v['SUMMARY'];
  echo "<br>";
  echo "<br>";
  echo "<br>";
}

/*Design SQL which shows users who haven't received salary yet
*/
$sql = "SELECT name AS NAME, id AS ID FROM user where user.id not in (SELECT user.id FROM salary,user WHERE user.id = salary.userId)";
//$result = mysql_query($sql);
$result = $mysqli->query($sql);
echo "These peoples haven't received salary yet";
echo "<br>";
foreach($result as $v)
{
  echo "NAME:" .$v['NAME'] . "&nbsp&nbsp&nbspID:" . $v['ID'];
  echo "<br>";
}
?>
