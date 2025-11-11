
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <!-- cdn css link  -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-RXf+QSDCUq0a4tWstYz3fVZt2mt5eNf8LrbS1Nq8E+6aY+slcHyx1z5whmys03eRg8MWG2zP9Wq3hk7x7x1Ykg==" 
         crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- cdn js link -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-YgZ7W+Xq0YiW3RRo7K6zJ0e2M37LDpUor6+ZOhmO3RrIY3iN3z3MltZ8U0Yk7j8GZCZZxFh8m7q5Y4osr6Dy6A==" 
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



        <!-- bootstrap cdn link -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">National Hospital</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../admin/dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="../doctor/doctorlist.php">Doctors</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="../user/userlist.php">Users</a>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Patients
                        </a>
                        <ul class="dropdown-menu">
                            <!-- <li><a class="dropdown-item" href="#">Patients</a></li> -->
                            <li><a class="dropdown-item" href="#">Treatment_record</a></li>
                            <li><a class="dropdown-item" href="#">Appointmetns</a></li>
                        </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="row mt-2 mx-3">
        <div class="col-md-12">
            <h2>Welcome ,
                <span class="text-primary">
                <?php
                    if(isset($_SESSION['admin']))
                    {
                        echo $_SESSION['admin'];
                    }
                    else
                    {
                        $_SESSION['admin']='';
                    }
                    ?>
                </span>
            </h2>
        </div>
    </div>
    </body>
</html>
