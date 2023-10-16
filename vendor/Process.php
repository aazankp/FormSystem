<?php
require_once("Database.php");
$Database = new Database();

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "InsertPersonData") { ?>
    <div class="text fw-bold">Add Person Data</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-6 col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Add Person Data</h5>
                    </div>
                    <form method="POST" id="AddPersonData" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class='row'>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="ProfileImg">Profile Image</label>
                                    <input class="form-control PersonFormInput" type="file" name="ProfileImg" id="ProfileImg">
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="FirstName">First Name</label>
                                    <input type="text" class="form-control PersonFormInput" name="FirstName" id="FirstName" placeholder="First Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="LastName">Last Name</label>
                                    <input type="text" class="form-control PersonFormInput" name="LastName" id="LastName" placeholder="Last Name">
                                </div>
                            </div>
                            <div class='row mt-2'>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="Country">Country</label>
                                    <select class="form-control PersonFormInput" name="Country" id="Country">
                                        <option value="">Select Country</option>
                                        <option value="Pakistan" data-country_id="1">Pakistan</option>
                                        <option value="England" data-country_id="2">England</option>
                                        <option value="Australia" data-country_id="3">Australia</option>
                                        <option value="Sri Lanka" data-country_id="4">Sri Lanka</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="State">State</label>
                                    <select class="form-control PersonFormInput" name="State" id="State">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="City">City</label>
                                    <select class="form-control PersonFormInput" name="City" id="City">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row mt-2'>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1">Gender</label> <br>
                                    <input type="radio" name="Gender" value="Male" checked> <span class="me-2">Male</span>
                                    <input type="radio" name="Gender" value="Female"> <span>Female</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success" name="submit">Submit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "Dashboard") { ?>
    <div class="text fw-bold">Dashboard</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-6 col-md-3">
                <div class="card">
                    <div class="card-body" id="cardbody">
                        <div id="map" style="height: 400px;"></div>
                        <div id="info">
                            <p class="mt-3"><b>Marker 1: </b><span id="marker1"></span></p>
                            <p><b>Marker 2: </b><span id="marker2"></span></p>
                            <p><b>Distance: </b><span id="distance"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "state") { 
    $country_id = $_REQUEST["country_id"];
    $result = $Database->fetch_country_details($country_id);
    echo '<option value="">Select State</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $state = json_decode($row['CountryDetails'], true);
        foreach ($state as $key => $value) {
            echo '<option value="'. $key .'" data-country="'. $country_id .'">'. $key .'</option>';
        }
    }
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "city") {
    $country_id = $_REQUEST["country_id"];
    $State = $_REQUEST["state"];
    $result = $Database->fetch_country_details($country_id);
    echo '<option value="">Select City</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $state = json_decode($row['CountryDetails'], true);
        foreach ($state as $key => $value) {
            if ($State == $key) {
                foreach ($value as $key => $city) {
                    echo '<option value="'. $city .'">'. $city .'</option>';
                }
            }
        }
    }
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "Submit_AddPersonData") {
    $ProfileImg = $_FILES["ProfileImg"];
    $FirstName = htmlspecialchars($_REQUEST["FirstName"]);
    $LastName = htmlspecialchars($_REQUEST["LastName"]);
    $Country = $_REQUEST["Country"];
    $State = $_REQUEST["State"];
    $City = $_REQUEST["City"];
    $Gender = $_REQUEST["Gender"];

    if ($ProfileImg && $FirstName && $LastName && $Country && $State && $City && $Gender != "") {
        $ImgName = $_FILES["ProfileImg"]["name"];
        $ImgTmpName = $_FILES["ProfileImg"]["tmp_name"];
        $path_info = pathinfo($ImgName);
        $file_extension = $path_info["extension"];
        if ($file_extension == "jpg" || $file_extension == "png") {
            $dir = "../Images";
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $ProfileImg = $dir."/".rand(00000,99999).'_'. $ImgName;
            move_uploaded_file($ImgTmpName, $ProfileImg);
            $result = $Database->AddPersonData($FirstName, $LastName, $Country, $State, $City, $Gender, $ProfileImg);
            if ($result) {
                echo 1;
            }else{
                echo "<script>alert('Some Thing Wents Wrong We Shall Resolve it Soon.');</script>";
            }
        } else {
            echo "ExtError";
        }
    } else{
        echo 0;
    }
    
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "ViewPersonData") { ?>
    <div class="text fw-bold">View Persons Data</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-6 col-md-3">
                <div class="card">
                    <div class="card-body">
                    <table id="ViewData" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Profile</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Gender</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                $result = $Database->fetch_PersonsData();
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $PersonId = $row['PersonId'];
                                    $ProfilePic = $row['ProfilePic'];
                                    $Profile = str_replace("../", "", $ProfilePic);
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $sno++; ?>
                                        </td>
                                        <td>
                                            <?php echo "<img src='" . $Profile . "' style='width: 100px; height: 40px;'>"; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['FirstName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['LastName']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['Gender']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['Country']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['State']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['City']; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success" value="<?php echo $PersonId; ?>" id="UpdatePersonData">Edit</button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" value="<?php echo $PersonId; ?>" id="DeletePersonData">Delete</button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "UpdatePersonData") { 
    $PersonId = $_REQUEST['PersonId'];
    $result = $Database->fetch_PersonData($PersonId);
    $row = mysqli_fetch_assoc($result);
    $ProfilePic = $row['ProfilePic'];
    $Profile = str_replace("../", "", $ProfilePic);
    ?>
    <div class="text fw-bold">Edit Person Data</div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-md-6 col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">Edit Person Data</h5>
                    </div>
                    <form method="POST" id="EditPersonData" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class='row'>
                                <input type="hidden" value="<?php echo $row['PersonId']; ?>" name="PersonId">
                                <input type="hidden" value="<?php echo $ProfilePic; ?>" name="UpdProfileImg">
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="ProfileImg">Profile Image</label>
                                    <div class="card" style="width: 18rem;">
                                        <img src="<?php echo $Profile; ?>" class="card-img-top">
                                        <div class="card-body">
                                            <input class="form-control" type="file" name="ProfileImg" id="ProfileImg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row mt-2'>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="FirstName">First Name</label>
                                    <input type="text" class="form-control PersonFormInput" value="<?php echo $row['FirstName']; ?>" name="FirstName" id="FirstName" placeholder="First Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="LastName">Last Name</label>
                                    <input type="text" class="form-control PersonFormInput" value="<?php echo $row['LastName']; ?>" name="LastName" id="LastName" placeholder="Last Name">
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="Country">Country</label>
                                    <select class="form-control PersonFormInput" name="Country" id="Country">
                                        <option <?php echo ($row["Country"] == "Pakistan") ? ("selected") : (""); ?> value="Pakistan" data-country_id="1">Pakistan</option>
                                        <option <?php echo ($row["Country"] == "England") ? ("selected") : (""); ?> value="England" data-country_id="2">England</option>
                                        <option <?php echo ($row["Country"] == "Australia") ? ("selected") : (""); ?> value="Australia" data-country_id="3">Australia</option>
                                        <option <?php echo ($row["Country"] == "Sri Lanka") ? ("selected") : (""); ?> value="Sri Lanka" data-country_id="4">Sri Lanka</option>
                                    </select>
                                </div>
                            </div>
                            <div class='row mt-2'>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="State">State</label>
                                    <select class="form-control PersonFormInput" name="State" id="State">
                                        <option value="<?php echo $row['State']; ?>"><?php echo $row['State']; ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1" for="City">City</label>
                                    <select class="form-control PersonFormInput" name="City" id="City">
                                        <option value="<?php echo $row['City']; ?>"><?php echo $row['City']; ?></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="fw-bold mb-1">Gender</label> <br>
                                    <div class="mt-1">
                                        <input type="radio" name="Gender" <?php echo ($row["Gender"] == "Male") ? ("checked") : (""); ?> value="Male"> <span class="me-2">Male</span>
                                        <input type="radio" name="Gender" <?php echo ($row["Gender"] == "Female") ? ("checked") : (""); ?> value="Female"> <span>Female</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success" name="submit">Submit Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
}

else if (isset($_REQUEST['action']) && $_REQUEST['action'] == "Submit_EditPersonData") {
    $PersonId = $_REQUEST["PersonId"];
    $ProfileImg = $_FILES["ProfileImg"];
    $FirstName = htmlspecialchars($_REQUEST["FirstName"]);
    $LastName = htmlspecialchars($_REQUEST["LastName"]);
    $Country = $_REQUEST["Country"];
    $State = $_REQUEST["State"];
    $City = $_REQUEST["City"];
    $Gender = $_REQUEST["Gender"];
    $UpdProfileImg = $_REQUEST['UpdProfileImg'];

    if ($FirstName && $LastName && $Country && $State && $City && $Gender != "") {
        $ImgName = $_FILES["ProfileImg"]["name"];
        $dir = "../Images";
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        if (isset($ProfileImg) && $ImgName != "") {
            $ImgTmpName = $_FILES["ProfileImg"]["tmp_name"];
            $path_info = pathinfo($ImgName);
            $file_extension = $path_info["extension"];
            if ($file_extension == "jpg" || $file_extension == "png") {  
                $ProfileImg = $dir."/".rand(00000,99999).'_'. $ImgName;
                move_uploaded_file($ImgTmpName, $ProfileImg);
                if (file_exists($UpdProfileImg)) {
                    unlink($UpdProfileImg);
                }
            } else {
                echo "ExtError";
            }
        } else {
            $ProfileImg = $UpdProfileImg;
        }

        $result = $Database->UpdatePersonData($PersonId, $FirstName, $LastName, $Country, $State, $City, $Gender, $ProfileImg);
        if ($result) {
            echo 1;
        }else{
            echo "<script>alert('Some Thing Wents Wrong We Shall Resolve it Soon.');</script>";
        }

    } else{
        echo 0;
    }
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'DeletePersonData') {
    $PersonId = $_REQUEST["PersonId"];
    $result = $Database->fetch_PersonData($PersonId);
    $row = mysqli_fetch_assoc($result);
    $ProfilePic = $row['ProfilePic'];
    if (file_exists($ProfilePic)) {
        unlink($ProfilePic);
    }
    $delete = $Database->Delete_PersonData($PersonId);
}
?>