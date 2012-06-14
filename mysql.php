<?php
#MySQL-Send-Non-ASCII-UTF8.php
# Copyright (c) 2007 by Dr. Herong Yang, http://www.herongyang.com/
#
  $con = mysql_connect("localhost", "admin", "VS3FZ353du");
  $ok = mysql_select_db("wpform", $con);
  
  $test_name = "Send Non-ASCII";

# Set character_set_results
  mysql_query("SET character_set_results=utf8", $con);

# Set character_set_client and character_set_connection
  mysql_query("SET character_set_client=utf8", $con);
  mysql_query("SET character_set_connection=utf8", $con);

# Show character set encoding variables
  $sql = "SHOW VARIABLES LIKE 'character_set_%'";
  $res = mysql_query($sql, $con);
  while ($row = mysql_fetch_array($res)) {
    print($row['Variable_name']." = ".$row['Value']."\n");
  }
  mysql_free_result($res);

# Delete the record
  $sql = "DELETE FROM Comment_Mixed WHERE Test_Name ='$test_name'";
  mysql_query($sql, $con);
  print("\nNumber of rows deleted: ".mysql_affected_rows()."\n");

# Build the SQL INSERT statement
  $sql = <<<END_OF_MESSAGE
INSERT INTO Comment_Mixed (Test_name, String_ASCII, 
    String_Latin1, String_UTF8, String_GBK, String_Big5)
  VALUES ('$test_name', 'Television', 
    'T?l?vision', '电视机/電視機', '???', '???');
END_OF_MESSAGE;

# Run the SQL statement
  if (mysql_query($sql, $con)) {
    print("\nNumber of rows inserted: ".mysql_affected_rows()."\n");
  } else {
    print("SQL statement failed.\n");
    print(mysql_errno($con).": ".mysql_error($con)."\n"); 
  }

# Get the recod back
  $sql = "SELECT * FROM Comment_Mixed"
    . " WHERE Test_Name = '$test_name'";
  $res = mysql_query($sql, $con);
  if ($row = mysql_fetch_array($res)) {
    print("\nTest Name = ".$row['Test_Name']."\n");
    print("   String_ASCII: 0x".bin2hex($row['String_ASCII'])."\n");
    print("   String_Latin1: 0x".bin2hex($row['String_Latin1'])."\n");
    print("   String_UTF8: 0x".bin2hex($row['String_UTF8'])."\n");
    print("   String_GBK: 0x".bin2hex($row['String_GBK'])."\n");
    print("   String_Big5: 0x".bin2hex($row['String_Big5'])."\n");
  }  
  mysql_free_result($res);

  mysql_close($con); 
?>