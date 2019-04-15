 <?php 
    require "vendor/autoload.php";

    $fb = new Facebook\Facebook([
        "app_id" => "2199009383524440",
        "app_secret" => "20beaba1dc33f9db6a3a703979723015",
        "default_graph_version" => "v2.7"
    ]);
    
    $helper = $fb->getRedirectLoginHelper();
    $fb_login_url = $helper->getLoginUrl("http://localhost/salon-management-software/login.php",["email"]);
    
    try {
        $accessToken = $helper->getAccessToken();
        if (isset($accessToken)) {
            // Problem Here
            $_SESSION["access_token"] = (string)$accessToken;
            
            if ($_SESSION["access_token"]) {
                try {
                    //$info = explode('=', $accessToken);
                    //$fb->setDefaultAccessToken($info[1]);
                    $fb->setDefaultAccessToken($_SESSION["access_token"]);
                    $res = $fb->get("/me?locale=en_US&fields=name,email", $_SESSION["access_token"]);
                    $user = $res->getGraphUser();
                    
                    // 
                    $user_check_query = "SELECT * FROM `users` WHERE `email` = :email LIMIT 1";

                    $result = $conn->prepare($user_check_query);
                    $result->bindValue(":email", $email);
                    $result->execute();

                    $userdatabase = $result->fetch(PDO::FETCH_ASSOC);

                    if ($userdatabase) {
                        if ($userdatabase["email"] == $user->getField("email")) {
                            $_SESSION["id"] = $userdatabase["userId"];
                            $_SESSION["name"] = $userdatabase["name"];
                            $_SESSION["email"] = $userdatabase["email"];
                            $_SESSION["role"] = "user";
                        } else {
                            $date = date("Y-m-d H:i:s");
                            $user_store_query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, NULL, :name, 'user', '', '$date')";
                            // Insert the user
                            $result = $conn->prepare($user_store_query);
                            $result->bindValue(":name",  $user->getField("name"));
                            $result->bindValue(":email", $user->getField("email"));
                            $result->execute();
                            
                             // Select the signed user from database 
                            $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

                            $result = $conn->prepare($user_find_query);
                            $result->bindValue(":name",  $user->getField("name"));
                            $result->bindValue(":email", $user->getField("email"));
                            $result->execute();

                            $newUser = $result->fetch(PDO::FETCH_ASSOC);
                            
                            $_SESSION["id"] = $newUser["userId"];
                            $_SESSION["name"] = $user->getField("name");
                            $_SESSION["email"] = $user->getField("email");
                            $_SESSION["role"] = "user";
                        }
                    } else {
                        $date = date("Y-m-d H:i:s");
                            $user_store_query = "INSERT INTO `users` (email, password, name, role, note, lastSignIn) VALUES (:email, NULL, :name, 'user', '', '$date')";
                            // Insert the user
                            $result = $conn->prepare($user_store_query);
                            $result->bindValue(":name",  $user->getField("name"));
                            $result->bindValue(":email", $user->getField("email"));
                            $result->execute();
                            
                             // Select the signed user from database 
                            $user_find_query = "SELECT * FROM `users` WHERE `name` = :name OR `email` = :email LIMIT 1";

                            $result = $conn->prepare($user_find_query);
                            $result->bindValue(":name",  $user->getField("name"));
                            $result->bindValue(":email", $user->getField("email"));
                            $result->execute();

                            $newUser = $result->fetch(PDO::FETCH_ASSOC);
                            
                            $_SESSION["id"] = $newUser["userId"];
                            $_SESSION["name"] = $user->getField("name");
                            $_SESSION["email"] = $user->getField("email");
                            $_SESSION["role"] = "user";
                    }
                    header("Location: index.php");
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
            }
            
            //header("Location: index.php");
            
        }
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }

?>