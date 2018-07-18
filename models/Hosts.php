<?php

    class Hosts {
        //Database Properties 
        private $conn;
        private $tblname = "admins";
        
        //Host Properties
        public $new_id;
        public $host_id;
        public $fname;
        public $mname;
        public $lname;
        public $username;
        public $password;
        public $confirm_password;
        
        //Error Code Properties
        /*
            0. Passwords do not match
            2. All Fields are required
            3. Password must be atleast 8 characters
        */
        
        public $error_code;
        
        //Constructor   
        public function __construct($db){
            $this->conn = $db;
        }
        
        public function validateHostDetails() {
            /*check if inputs are left blank
            if passwords match and atleast 8 characters
            username must be unique*/
            
        }
        
        public function addHost() {
            $insertQuery = "INSERT INTO admins 
                            SET
                              admin_id = :admin_id,
                              fname = :fname,
                              mname = :mname,
                              lname = :lname,
                              username = :username,
                              password = :password
                              ";
            
            //Prepare Insert Statement
            $stmt = $this->conn->prepare($insertQuery);
            
            //Clean inputted data
            $this->admin_id = htmlspecialchars(strip_tags($this->admin_id));
            $this->fname = htmlspecialchars(strip_tags($this->fname));
            $this->mname = htmlspecialchars(strip_tags($this->mname));
            $this->lname = htmlspecialchars(strip_tags($this->lname));
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->password = htmlspecialchars(strip_tags($this->password));
            
            //Bind paramaters
            $stmt->bindParam(':admin_id', $this->admin_id);
            $stmt->bindParam(':fname', $this->fname);
            $stmt->bindParam(':mname', $this->mname);
            $stmt->bindParam(':lname', $this->lname);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            
            
            //Execute
            if($stmt->execute()){
                return true;
            }else{
                
            printf("Error: %s".\n, $stmt->err);
            return false;
            }


    }

    function logInHost(){
        //QUERY
        $query = "SELECT * FROM admins WHERE username = :username && password = :password";
        //PREAPARE STATMENT
        $stmt = $this->conn->prepare($query);
        //BIND PARAMS AND EXECURE QUERY
        $stmt->execute([ 'username' => $this->username , 'password' => $this->password]);

        //IF MAY RESULT
        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return true;
        }else{
            return false;
        }

    }   
}