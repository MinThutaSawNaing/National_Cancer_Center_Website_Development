<?php 
session_start();
include_once("../layouts/header.php") ?>

<?php include_once("../config/database.php")?>

<body>
        <?php if(isset($_POST['adduser'])){
            adduser();
            }
        ?>

        <div class="container Top">
                
                <div class="row justify-content-center">
                    <div class="col-md-6 col-md-offset-3">
                        <form method="post" class="mt-2">
                            <div class="form-group mt-2">
                                <label for="">User Name</label>
                                    <input type="text" name="username" class="form-control mt-2" required placeholder="Enter username....">
                            </div>
                            <?php 
                                if(isset($_POST['btn_adduser'])){
                                $userStatus = $_POST['username'] != "";
                                echo $userStatus ? "" : "<small class='text-danger mb-2'>Name is required!</small>";
                                }
                            ?>
                        

                            <div class="form-group mt-2">
                                <label for="">Phone</label>
                                    <input type="text" name="phone" class="form-control mt-2" required placeholder="Enter phone....">
                            </div>

                            <div class="form-group mt-2">
                                <label for="">Password</label>
                                    <input type="password" name="password" class="form-control mt-2" required placeholder="Enter password...">
                            </div>

                            <div class="form-group mt-2">
                                <label for="">Confirm Pasword</label>
                                    <input type="password" name="confirmpassword" class="form-control mt-2" required placeholder="Enter password again...">
                            </div>

                            <div class="form-gorup mt-2">
                                <label for="">User Role</label>
                                    <select name="usertype" class="form-control mt-2" id="">
                                        <option value="admin">----Admin----</option>
                                        <option value="doctor">----Doctor----</option>
                                        <option value="user">----Nurse----</option>
                                    </select> <br>
                            </div>
                            <button type="submit" name="btn_adduser" class="btn btn-primary">Add User</button>
                        </form>
                    </div>
                </div>
        </div>

        <?php 
        
            if(isset($_POST['btn_adduser'])){
                $name  = $_POST['username'];               
                $pass  = $_POST['password'];
                $cpass = $_POST['confirmpassword'];
                $phone = $_POST['phone'];
                $role  = $_POST['usertype'];

                // check both password match
                if($pass !== $cpass){
                    echo "<script>alert('Passwords do not match!');</script>";
                } else {

                    // hash the password 
                    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

                    // insert data to table (store hash, not plain password)
                    $adduser_query = "INSERT INTO users(username, password, phone, role) VALUES(?,?,?,?)";
                    $res = $pdo->prepare($adduser_query);
                    $res->execute([$name, $hashedPassword, $phone, $role]);

                    echo "<script>alert('User created successfully');</script>";
                }
            }
        ?>


</body>
</html>