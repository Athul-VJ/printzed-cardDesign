<?php
class operation{
    function __construct(){
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->databasename = "tracking";
        // Create connection
        $this->conn = new mysqli($this->servername,$this->username,$this->password,$this->databasename);
                          }
                          function login($email,$track){
                            $this->sql="SELECT * FROM users WHERE emailid = '$email' AND trackid = '$track'";
                          }
                          function UpdateFlag($track){
                            $this->sql="UPDATE users SET flag = 1 WHERE  trackid='$track'";
                          }
                          function Deatils($track){
                            $this->sql="SELECT * FROM users WHERE trackid='$track'";
                          }

                          function executeQuery()
                          {
                              $this->result = mysqli_query($this->conn, $this->sql);
                              return $this->result;
                          }
                        
                        }
                        ?>