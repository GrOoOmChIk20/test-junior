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
        $equipmentData = $_POST['Equipment'];

        if (isset($equipmentData['insert'])) {

            $formValidation = Validator::validateForm($equipmentData);

            if ($formValidation['valid']) {

                $equipmentData = $formValidation['validFields'];
                
                $fetchMask = $this->fetchMask($equipmentData['type'])[0];

                if ($fetchMask) {

                    $serialsNumber = explode(PHP_EOL, $equipmentData['serials_number']);
                    $mask = $fetchMask['mask_numb'];
                    $splitMask = str_split($mask);

                    $regularMatch = GenerateMask::generate($splitMask);
                    
                    for ($number = 0; $number < count($serialsNumber); $number++) {

                        $serialNumber = $serialsNumber[$number];
                        $match = preg_match($regularMatch, $serialNumber);

                        if ($match) {

                            $fetchSerialNumber = $this->fetchSerialNumber($serialNumber);
                            
                            if ($fetchSerialNumber) {

                                $_SESSION['errorField'][] = $serialNumber . ' has already been added to the database';
                                
                            } else {

                                $idEquipment = $fetchMask['id'];
                                $this->insertSerialNumber($serialNumber, $idEquipment);

                            }
                        } else {
                            $_SESSION['errorField'][] = $serialNumber . ' does not match the mask';
                        }
                    }

                    header("Location: " . $_SERVER["REQUEST_URI"]);
                    die;

                } else {

                    $_SESSION['errorField'][] = 'Type equipment nor found';

                    header("Location: " . $_SERVER["REQUEST_URI"]);
                    die;

                }

            }else {

                $_SESSION['errorField'][] = 'Please fill in all the fields';

                header("Location: " . $_SERVER["REQUEST_URI"]);
                die;

            }

        }
    }


    private function insertSerialNumber($serialNumber, $idEquipment)
    {
        $query = "INSERT INTO `equipment` (`id_equipment`, `serial_number`) VALUES ('{$idEquipment}', '{$serialNumber}')";

        if ($sql = $this->connect->query($query)) {

            $_SESSION['succesField'][] = $serialNumber . ' added to the database';

        } else {

            $_SESSION['errorField'][] = 'The entry has not been added, try again';

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

    public function fetchMask($id)
    {
        $data = [];
        $query = "SELECT id, mask_numb FROM type_equipment WHERE id = '$id'";

        if ($sql = $this->connect->query($query)) {

            if (mysqli_num_rows($sql) != 0) {

                while ($row = mysqli_fetch_assoc($sql)) {
                    $data[] = $row;
                }
            }
            
            return $data;
        }
    }

    public function fetchSerialNumber($serialNumber)
    {
        $data = [];
       
        $query = "SELECT id FROM equipment WHERE serial_number = '$serialNumber'";
        
        if ($sql = $this->connect->query($query)) {

            if (mysqli_num_rows($sql) != 0) {

                $data = mysqli_fetch_row($sql)[0];

            }
            
            return $data;

        } else {

            $_SESSION['errorField'][] = 'The entry has not been added, try again';
            return $data;

        }

    }
        
}
