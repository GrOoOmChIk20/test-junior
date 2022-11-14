<?php

$titlePage = 'Home';

include_once  './template/header.php';

?>

<div class="col-md-6 mx-auto">
    <h4>Add equipment</h4>
    <form action="" method="post">
        <div class="form-group">
            <textarea class="form-control" placeholder="Serial number (each line has its own serial number)" id="floatingTextarea" name="Equipment[serial_number]"></textarea>
        </div>
        <div class="form-group">
            <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon" name="Equipment[type]">
                <option selected>Type of equipment</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="Equipment[insert]">Submit</button>
        </div>
    </form>
</div>