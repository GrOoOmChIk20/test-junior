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
<<<<<<< HEAD

=======
        
>>>>>>> 5f8f1333f13894e509294632c991c6971fc1cd53
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
<<<<<<< HEAD
            }

            return $data;
        }
    }
=======

            } 
            
            return $data;
            
        }

    }

>>>>>>> 5f8f1333f13894e509294632c991c6971fc1cd53
}
