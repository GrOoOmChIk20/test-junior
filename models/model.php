<?php

mysqli_report(MYSQLI_REPORT_STRICT);

class Model
{
    private $connect;

    public $errorField;
    public $succesField;

    public function __construct($db)
    {
        try {
            $this->connect = new mysqli($db['host'], $db['userName'], $db['password'], $db['dataBase']);
        } catch (Exception $e) {
            echo 'Connection failed! ' . $e->getMessage();
        }
    }

    public function insert()
    {
        $userData = $_POST['User'];

        if (isset($userData['insert'])) {

            $formValidation = $this->validation($userData);

            switch ($formValidation['valid']) {

                case true:

                    $userData = $formValidation['validFields'];

                    $fetchUser = $this->fetch(['id'], ['login' => $userData['login']]);

                    if (empty($fetchUser)) {

                        $userData['birthday'] = strtotime($userData['birthday']);
                        $userData['pass'] = password_hash($userData['pass'], PASSWORD_DEFAULT);

                        $query = "INSERT INTO `users` (`login`, `password`, `name`, `surname`, `gender`, `birthday`) VALUES ('{$userData['login']}', '{$userData['pass']}', '{$userData['name']}', '{$userData['surname']}', '{$userData['gender']}', '{$userData['birthday']}')";

                        if ($sql = $this->connect->query($query)) {
                            $_SESSION['succesField'] = 'User successfully added';

                            header("Location: " . $_SERVER["REQUEST_URI"]);
                            die;
                        } else {
                            $_SESSION['errorField'] = 'The entry has not been added, try again';

                            header("Location: " . $_SERVER["REQUEST_URI"]);
                            die;
                        }
                    } else {

                        $_SESSION['errorField'] = 'A user with this login exists';

                        header("Location: " . $_SERVER["REQUEST_URI"]);
                        die;
                    }

                    break;

                case false:

                    $_SESSION['errorField'] = 'Please fill in all the fields';

                    header("Location: " . $_SERVER["REQUEST_URI"]);
                    die;

                    break;
            }
        }
    }


    public function fetchType()
    {
        $data = [];
        $query = "SELECT id, type FROM type_equipment";

        if ($sql = $this->connect->query($query)) {

            if (mysqli_num_rows($sql) != 0) {

                while ($row = mysqli_fetch_assoc($sql)) {
                    $data[] = $row;
                }

            } 
            
            return $data;
            
        }

    }

}
