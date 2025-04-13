<?php

require_once __DIR__ . '/../config/config.php';

function cleanInput($data){
    return htmlspecialchars(stripslashes(trim($data)));
}



function addUser($user, $connection) {
    $name = cleanInput($user['name']);
    $email = cleanInput($user['email']);
    $password = cleanInput($user['password'], PASSWORD_DEFAULT);

    // cehck if email already exists
    $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0){
        return "Email ALready registered";
    }

    // insert into database
    $stmt = $connection->prepare("INSERT INTO users (nom, email, password) VALUES(?, ?, ?)");
    $stmt->execute([$name, $email, $password]);<?php

    require_once __DIR__ . '/../config/config.php';
    
    function cleanInput($data){
        return htmlspecialchars(stripslashes(trim($data)));
    }
    
    
    
    function addUser($user, $connection) {
        $name = cleanInput($user['name']);
        $email = cleanInput($user['email']);
        $password = cleanInput($user['password'], PASSWORD_DEFAULT);
    
        // cehck if email already exists
        $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if($stmt->rowCount() > 0){
            return "Email ALready registered";<?php

            require_once __DIR__ . '/../config/config.php';
            
            function cleanInput($data){
                return htmlspecialchars(stripslashes(trim($data)));
            }
            
            
            
            function addUser($user, $connection) {
                $name = cleanInput($user['name']);
                $email = cleanInput($user['email']);
                $password = cleanInput($user['password'], PASSWORD_DEFAULT);
            
                // cehck if email already exists
                $stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if($stmt->rowCount() > 0){
                    return "Email ALready registered";
                }
            
                // insert into database
                $stmt = $connection->prepare("INSERT INTO users (nom, email, password) VALUES(?, ?, ?)");
                $stmt->execute([$name, $email, $password]);
            
            }
            
            
            // function log($email, $password, $connection) {}
            // function detailsUser($id, $connection) {}
            
            ?>
        }
    
        // insert into database
        $stmt = $connection->prepare("INSERT INTO users (nom, email, password) VALUES(?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
    
    }
    
    
    // function log($email, $password, $connection) {}
    // function detailsUser($id, $connection) {}
    
    ?>

}


 function log($email, $password, $connection) {
    $stmt = $connection->prepare("SELECT id, nom,password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
 }
// function detailsUser($id, $connection) {}

?>