<?php

use Project\Components\View;
/**
 * @var View $this
 * @var array $array
 */

$this->title = 'Index page';
?>

<form>
    <div class="form-row align-items-center">
        <div class="col-auto my-1">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="col-auto my-1">
            <label class="mr-sm-2" for="inlineFormCustomSelect">Preference</label>
            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
                <option selected value="1">Quiz 1</option>
                <option value="2">Quiz 2</option>
                <option value="3">Quiz 3</option>
            </select>
        </div>
        <div class="col-auto my-1">
            <button style="margin-top:30px" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
