<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION["loggedin"]!==true){
    header("location:login.php");
    exit;
}

if(isset($_SESSION['id']) && !empty(trim($_SESSION['id']))){
    require_once "config.php";

    $sql ="SELECT * FROM users WHERE id = ?";

    if($statement = mysqli_prepare($connection,$sql)){
        mysqli_stmt_bind_param($statement,"i",$id);
        $id=$_SESSION['id'];

        if(mysqli_stmt_execute($statement)){
            $output = mysqli_stmt_get_result($statement);
            if(mysqli_num_rows($output)==1){
                $row = mysqli_fetch_array($output,MYSQLI_ASSOC);
                $name = $row['name'];
                $email = $row['email'];
                $contactno = $row['contact_no'];
                
            }else{
                echo "Couldn't fetch information from the DB";
            }
        }else{
            echo "Something Went wrong. Please try again Later";
        }
    }
    mysqli_stmt_close($statement);
    mysqli_close($connection);
}else{
    echo "Id is missing in the session";
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <title>Login Page</title>
        <?php include "includes\header.php"; ?> 
        <style>
            .login-section-logo{
                padding-top: 20px !important;
                padding-bottom: 20px !important;
            }

            .top-spacing{
                padding-top:1px !important;
            }

            .navbar-nav {
                flex-direction: row;
            }
            main{
                left: 0;
                display: block !important;
                right: 0;
                margin-left: 250px;
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <header>
            <?php include "includes\dashboard_top_nav.php"; ?>
            <?php include "includes\dashboard_side_nav.php"; ?>
        </header>
       <main class="alignment">
            <div class="container">                
                <h5>My Profile</h5>
                <?php
                   
                    /*if(isset($_SESSION['success_status'])&& $_SESSION['success_status']==true){
                        echo "<div id='session-alert' class='alert alert-success'>Updated Successfully</div>";
                    }else if(isset($_SESSION['success_status'])&& $_SESSION['success_status']==false || isset($_SESSION['update_status']) && $_SESSION['update_status']==0){
                        echo "<div id='session-alert' class='alert alert-danger'>Something Went Wrong</div>";
                    }*/
                
                ?>
                <form method="post" action="server.php">
                    <input type="hidden" name="operation_type" value="update_profile">
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>">
                    <div class="form-group top-spacing">
                        <div class="row" >
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="user_Name">User Name</label>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12">
                               <input class="form-control" type="text" name="name" id="user_name" placeholder="User Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Email"> Email </label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input class="form-control" type="text" name="email" id="user_email" placeholder="Email">
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Contact No">Mobile No</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="mobile No" id="user_contact_no" placeholder="Contact No">
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Address">Address</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="address" id="user_address" placeholder="Address">
                            </div>
                        </div><br>

                        <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="City">City</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="city" id="user_city" placeholder="City">
                            </div>
                        </div>
                    </div> 
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="state">State</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="state" id="user_state" placeholder="State">
                            </div>
                        </div>
                        
                    </div>                  
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Pincode">Pincode</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="pincode" id="user_pin" placeholder="Pincode">
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Country">Country</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="country" id="user_country" placeholder="Country">
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Company Name">Company Name</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="company" id="user_company" placeholder="Company Name">
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Occupation">Occupation</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="occupation" id="user_occupation" placeholder="Occupation">
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group top-spacing">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12">
                                <label for="Years of Experience">Years of Experience</label>
                            </div>
                            <div class="col-md-8 col-lg-8 col-sm-12">
                                <input  class="form-control" type="text" name="years_of_experience " id="user_experience" placeholder="Years of Experience">
                            </div>
                        </div>
                        
                    </div>
                   
                
                    
                </form>
            </div>
       </main>
       <?php include "includes\\footer.php"; ?>
       <script>
            $(document).ready(function(){
                setTimeout(function(){
                    $("#session-alert").alert("close")
                },5000);
            });
           
       </script>
    </body>
</html>