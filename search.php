<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
  require "bootstrap.php";
  require "connectscript.php";
  require "logouter.php";
  require "securedata.php";
  ?>
  <?php
  $searchq = '';
   if(isset($_REQUEST['q'])) {
     $searchq =  msec($_REQUEST['q']);
    }
  ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <?php require "header.php"; ?>
  <title>Search '<?php echo $searchq; ?>' | <?php require 'sitename.php'; ?></title>
  
</head>
<body>
  <div class = "container">
  <?php require "navbar.php"; ?>
    <div class = "main" >
      <div style = "margin: 5px;" class = "searchresult">
        <?php
        if(isset($_REQUEST['q'])){
          echo "<div class = 'col-sm-12'>
            <h4 style = 'margin: 10px 0px 0px 10px;'>Showing Result For <i>$searchq</i> </h4>
            <hr style = 'margin:0px; display:inline-block;height: 1px; background-color: #ddd; width: 100%;'/>
          </div>";
          if(empty(msec($_REQUEST['q']))){
            echo "<div style = 'margin-top:0px; padding: 20px;' class = 'alert alert-danger'>Plese Input Someone's Name To Find Them
              <form style = 'margin: 10px;' class = 'row' action = 'search.php' method = 'get'>
                <input style = 'margin: 2px 10px 2px 0px;' class = 'form-control col-sm-11' type = 'search' name = 'q' placeholder = 'Search Friends...' />
                <input type = 'submit' value = 'Search' class = 'btn btn-primary' />
              </form>
            </div>";
          } else {
            echo "<div style = 'margin: auto;' >";
              $searchdata = msec($_REQUEST['q']);
              $sqlcom = "SELECT * FROM userdata WHERE Fullname LIKE '%$searchdata%' OR Username LIKE '%$searchdata%' OR Fname LIKE '%$searchdata%' OR Lname LIKE '%$searchdata%' OR Email LIKE '%$searchdata%';";
              $runsql = mysqli_query($dbconnect, $sqlcom);
              if(mysqli_num_rows($runsql) == 0){
                echo "<div style = 'margin-top:0px; padding: 20px;' class = 'alert alert-warning'>Could Not Found Any Person Named <b><i>$searchq</i></b>
                <form style = 'margin: 10px;' class = 'row' action = 'search.php' method = 'get'>
                <input style = 'margin: 2px 10px 2px 0px;' class = 'form-control col-sm-11;' type = 'search' name = 'q' placeholder = 'Search Friends...' />
                <input type = 'submit' value = 'Search' class = 'btn btn-primary' style = 'margin:2px;' />
              </form>
                </div>";
              } else {
                while($mydata = mysqli_fetch_assoc($runsql)){
                  if($mydata['DP'] == 'N/A'){
                    if($mydata['Gender'] == "male"){
                      echo "<div class = 'srchres row'>";
                      echo "<style>
                      .showdphere {
                         background-image:url('avatar/default/chatflow_default_m.png'); 
                         background-size: cover; 
                         background-position:center; 
                         height: 120px; 
                         width:120px; 
                         border-radius: 50%; 
                         border: 3px solid #dbf5ff; 
                        }
                        </style>
                        ";
                      echo "<div class = 'col-md-2 col-sm-12' style = 'margin-left: 10px;margin-bottom: 15px;'>
                        <div class = 'showdphere'></div>
                      </div>
                      ";
                      echo "<div class = 'col-md-8'>
                        <div style = 'font-size:22px; margin-top:15px;'>".$mydata['Fullname']."</div>
                        <div style = 'font-size:16px; font-weight:thin; color: #aaaaaa;'>@".$mydata['Username']."</div>
                      </div>
                      ";
                      $getid = $mydata['SUname'];
                      echo "<div style = 'float:right;' class = 'col-md-1'>";
                      if($_COOKIE['user'] != $getid){
                        echo "<a href = 'chatflow.php?msgid=$getid'>
                      <button style = 'margin-right:5px;margin-bottom: 15px;' class = 'btn btn-outline-primary'>Message</button></a>";
                      }
                      echo "<!---<a href = 'peoples.php?profileid=$getid'><button style = 'margin-right:5px;margin-bottom: 15px;' class = 'btn btn-outline-success'>Profile</button></a>--->
                        </div><br/>
                        <div style = 'clear:both'></div>
                        ";
                      echo "</div>
                      ";
                      
                    } else {
                      echo "<div class = 'srchres row'>
                      ";
                      echo "<style>
                      .showdpherefem {
                         background-image:url('avatar/default/chatflow_default_f.png'); 
                         background-size: cover; 
                         background-position:center; 
                         height: 120px; 
                         width:120px; 
                         border-radius: 50%; 
                         border: 3px solid #dbf5ff; 
                        }
                      </style>
                      ";
                      echo "<div class = 'col-md-2 col-sm-12' style = 'margin-left: 10px;margin-bottom: 15px;'>
                        <div class = 'showdpherefem'></div>
                      </div>
                      ";
                      echo "<div class = 'col-md-8'>
                        <div style = 'font-size:22px; margin-top:15px;'>".$mydata['Fullname']."</div>
                        <div style = 'font-size:16px; font-weight:thin; color: #aaaaaa;'>@".$mydata['Username']."</div>
                      </div>
                      ";
                      $getid = $mydata['SUname'];
                      echo "<div style = 'float:right;' class = 'col-md-1'>";
                      if($_COOKIE['user'] != $getid){
                        echo "<a href = 'chatflow.php?msgid=$getid'>
                      <button style = 'margin-right:5px;margin-bottom: 15px;' class = 'btn btn-outline-primary'>Message</button></a>";
                      }
                      echo "<!---<a href = 'peoples.php?profileid=$getid'><button style = 'margin-right:5px;margin-bottom: 15px;' class = 'btn btn-outline-success'>Profile</button></a>--->
                        </div><br/>
                        <div style = 'clear:both'></div>
                        ";
                      echo "</div>
                      ";
                    }
                    
                  } else {
                    echo "<div class = 'srchres row'>
                    ";
                    echo "<style>
                      .showdpheredp".$mydata['ID']." {
                         background-image:url('".$mydata['DP']."'); 
                         background-size: cover; 
                         background-position:center; 
                         height: 120px; 
                         width:120px; 
                         border-radius: 50%; 
                         border: 3px solid #dbf5ff; 
                        }
                      </style>
                      ";
                    echo "<div class = 'col-md-2 col-sm-12' style = 'margin-left: 10px;margin-bottom: 15px;'>
                      <div class = 'showdpheredp".$mydata['ID']."'></div>
                    </div>
                    ";
                    
                    echo "<div class = 'col-md-8'>
                      <div style = 'font-size:22px; margin-top:15px;'>".$mydata['Fullname']."</div>
                      <div style = 'font-size:16px; font-weight:thin; color: #aaaaaa;'>@".$mydata['Username']."</div>
                    </div>
                    ";
                    $getid = $mydata['SUname'];
                    echo "<div style = 'float:right;' class = 'col-md-1'>";
                    if($_COOKIE['user'] != $getid){
                      echo "<a href = 'chatflow.php?msgid=$getid'><button style = 'margin-right:5px;margin-bottom: 15px;' class = 'btn btn-outline-primary'>Message</button></a>";
                    }
                    echo "<!---<a href = 'peoples.php?profileid=$getid'><button style = 'margin-right:5px;margin-bottom: 15px;' class = 'btn btn-outline-success'>Profile</button></a>--->
                        </div><br/>
                        <div style = 'clear:both'></div>
                        ";
                    echo "</div>
                    ";
                  }
                }
              }
              
            echo "</div>
            ";
          }
        } else {
          echo "<div style = 'margin-top:0px; padding: 20px;' class = 'alert alert-primary'>Search For Friends
              <form style = 'margin: 10px;' class = 'row' action = 'search.php' method = 'get'>
                <input style = 'margin: 2px 10px 2px 0px;' class = 'form-control col-sm-11' type = 'search' name = 'q' placeholder = 'Search Friends...' />
                <input type = 'submit' value = 'Search' class = 'btn btn-primary' />
              </form>
            </div>";
        }
          
        ?>
        <style>
        .srchres {
          margin: 10px;
          border-bottom: 1px solid #eee;
        }

        </style>
      </div>
    </div>
    
  </div>
  
</body>
</html>