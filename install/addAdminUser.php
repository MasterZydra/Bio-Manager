<?php
/*
* addAdminUser.php
* ---------------
* Page to add the admin user 'wurzel'.
*
* @Author: David Hein
* 
* Changelog:
* ----------
*/

    include 'modules/Mysql.php';

    $conn = new Mysql();
    $conn -> dbConnect();

    $NULL = [
        "type" => "null",
        "val" => "null"
    ];
        
    $user_name = [
        "type" => "char",
        "val" => "wurzel"
    ];

    // Add user
    $data = array($NULL, $user_name, $NULL);
    $conn -> insertInto('T_User', $data);
    $data = NULL;

    // Get user id
    $conn -> select('T_User', 'id', 'name = \'wurzel\' ORDER BY id DESC');
    $user = $conn -> getFirstRow();
    if($user == NULL) {
            // Error do not continue
    }
        
    $user_id = [
        "type" => "int",
        "val" => $user['id']
    ];
        
    $user_password = [
        "type" => "char",
        "val" => password_hash("wurzel", PASSWORD_DEFAULT)
    ];
        
    $user_forcePwdChange = [
        "type" => "int",
        "val" => "1"
    ];
        
    // Add user login
    $data = array($NULL, $user_id, $user_name, $user_password, $user_forcePwdChange);
    $conn -> insertInto('T_UserLogin', $data);
    $data = NULL;
        
        $user_isAmin = [
            "type" => "int",
            "val" => "1"
        ];
        
        $user_noPermission = [
            "type" => "int",
            "val" => "0"
        ];

        $data = array($NULL, $user_id, $user_isAmin, $user_noPermission, $user_noPermission, $user_noPermission, $user_noPermission);
        $conn -> insertInto('T_UserPermission', $data);
        $data = NULL;
                
        $conn -> dbDisconnect();
?>