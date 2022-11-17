<?php

$configApp = include_once './app/config.php';

session_start();

include_once './models/model.php';
include_once './components/Validator.php';
include_once './components/GenerateMask.php';

$model = new Model($configApp['components']);

$titlePage = 'Home';

include_once  './template/header.php';

$arrTypes = $model->fetchType();

?>

<div class="col-md-6 mx-auto">
    <h4>Add equipment</h4>

    <?php $insert = $model->insert();  ?>

    <form action="" method="post">
        <div class="form-group">
            <textarea class="form-control" placeholder="Serial number (each line has its own serial number)" id="floatingTextarea" name="Equipment[serials_number]"></textarea>
        </div>
        <div class="form-group">
            <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon" name="Equipment[type]">
                <option selected>Type of equipment</option>

                <?php

                for ($i = 0; $i < count($arrTypes); $i++) {

                    $idType = $arrTypes[$i]['id'];
                    $nameType = $arrTypes[$i]['type'];

                    echo "<option value='$idType'>$nameType</option>";
                }

                ?>

            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="Equipment[insert]">Submit</button>
        </div>
    </form>
</div>

<?php

include_once  './template/footer.php';

?>