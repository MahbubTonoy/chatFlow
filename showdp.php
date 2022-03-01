<script src="https://kit.fontawesome.com/113ecb3cb4.js" crossorigin="anonymous"></script>
<?php
$sqlcom = "SELECT SUname, ID FROM userdata WHERE SUname =  '$cookieuser'";
$runsql = mysqli_query($dbconnect, $sqlcom);
$getdata = mysqli_fetch_assoc($runsql);
$newfilename = "avatar/dp_" . $getdata['SUname'] . "_" . $getdata['ID'] . ".jpg";
?>

<style>
    .defdp {
        background-image: url('<?php echo $newfilename; ?>');
        background-size: cover;
        display: inline-block;
        background-position: center;
    }

    .updp {
        display: none;
        border-radius: 50%;
    }
    .updptxt {
        margin-top: 5px;
    }
    .defdp:hover .updp {
        display: block;
    }
</style>
<div style="position: relative;height: 150px;width: 150px; border-radius: 50%; border: 3px solid grey" class="defdp">
    <div class="updp" style="padding: 0px;position: absolute; top: -3px; left: -3px; height: 150px; width: 150px; background-color: black;opacity: 0.3; "></div>
    <div class="updp" style="padding: 0px;position: absolute; top: -5px; left: 25px;z-index:12;font-size: 16px; opacity: 1;color: white; text-align: center; padding-top: 8px">
        <div class = "updptxt"><font size="12px">
            <i class="fas fa-camera-retro"></i>
        </font><br />
        Change<br />Profile Picture
        </div>
    </div>
    <button style="opacity: 0; padding: 0px;position: absolute; top: -3px; left: -3px;z-index:13; height: 150px; width: 150px; background-color: black;opacity: 0.3;" type="button" class=" updp" data-toggle="modal" data-target="#myModal"></button>
</div>
<div class="modal text-left" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Change Profile Picture.</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Choose Your File Here:<br /><br />
                <b>Note: </b>Please Try To Upload 1:1 Ratio of Resulation Images For Better Outcome.<br />Maximum File Size is 2MB<br/>
                <form enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF'] . "?upload"; ?>">
                    <div class="custom-file">
                        <input type="file" name="dpup" class="custom-file-input" id="customFile" />
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <br /><br />
                    <input type="submit" class="btn btn-outline-primary btn-sm" value="Upload" />
                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>