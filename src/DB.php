<?php
class DBobj {
  function __construct() {
    $this->conn_error = 'Could not connect DB';;

    $mysql_host = 'localhost';
    $mysql_user = 'root';
    $mysql_pass = '';
    $mysql_db = 'sms';

    $this->link = mysqli_connect($mysql_host,$mysql_user,$mysql_pass,$mysql_db);
  }

  public function getRows() {
    $getRowsSql = "SELECT * FROM `user_sms` order by time desc"; 

    if ($result = mysqli_query($this->link, $getRowsSql)) {
      while($row = $result->fetch_assoc())
      {
          $rows[] = $row;
      }    
      $row_cnt = $result->num_rows;
      $test =   mysqli_fetch_assoc($result);
      return $rows;
    }
  }

  public function addRow($smsRequest) {

    $insetStr = "INSERT INTO user_sms ( `sending_number`, `to_number`, `msg`, `time`, `status`)
    VALUES ('".$smsRequest->fromNumber."','".$smsRequest->toNumber."','".$smsRequest->message."','".$smsRequest->time."','".$smsRequest->smsStatus."')";
    
    $dbResult = mysqli_query($this->link,$insetStr);
    
    if ($dbResult) {
      $dbResultArray = [
        "success" => true,
        "id" => mysqli_insert_id($this->link),
      ];
    } else {
      $dbResultArray = [
        "success" => false,
      ];
    }
    return $dbResultArray ;
  }
}
?>
 