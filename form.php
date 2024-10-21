<?php
    include('dbcon.php');
    $popup = false;

    $fname = "";
    $lname = "";
    $age = "";

    $employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : null;

    if($employee_id){
        $query = "select * from `employee_info` where `id` = '$employee_id'";

        $result = mysqli_query($connection, $query);

        if(!$result){
            die("Query failed".mysqli_error($connection));
        } else {
            $row = mysqli_fetch_assoc($result);
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $age = $row['age'];
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = htmlspecialchars($_POST["first_name"]);
        $lname = htmlspecialchars($_POST["last_name"]);
        $age = htmlspecialchars($_POST["age"]);

        if ($employee_id) {
            $query = "update `employee_info` set `first_name` = '$fname', `last_name` = '$lname', `age` = '$age' WHERE `id` = $employee_id";
        } else {
            $query = "insert into `employee_info` (`first_name`, `last_name`, `age`) values ('$fname', '$lname', '$age')";
        }

        if(!$fname || !$lname || !$age){
            header('location:form.php?error=Please fill all the details');
        }

        $result = mysqli_query($connection, $query);

        if(!$result){
            die("Query failed".mysqli_error($connection));
        } else {
            $popup = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $employee_id ? "Edit" : "Add"?> Employee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="form.css">
</head>
<body class="min-h-screen">
    <h1 class="text-3xl font-bold bg-[#808080] text-white p-[2rem] text-center"><?php echo $employee_id ? "Edit" : "Add"?> Employee</h1>
    <div class="w-full h-[89vh] grid place-items-center relative">

        <p class="absolute top-[6%] left-[6%] cursor-pointer flex items-center gap-2 text-xl <?php echo $popup ? "hidden" : null ?>" onClick="document.location.href='index.php'"><img src="./Images/back.png" alt="back" class="w-[1.2rem]">Back</p>

        <form action="" method="POST" class="w-[25%] mt-[2rem] flex flex-col gap-[2rem] px-[3rem] py-[3.5rem] bg-[#80808060] rounded-md <?php echo $popup ? "hidden" : null ?>">
            <div>
                <p>First Name</p>
                <input type="text" class="input" name="first_name" value=<?php echo $fname?>>
            </div>
            <div>
                <p>Last Name</p>
                <input type="text" class="input" name="last_name" value=<?php echo $lname?>>
            </div>
            <div>
                <p>Age</p>
                <input type="number" class="input" name="age" value=<?php echo $age?>>
            </div>
            <input type="submit" class="px-[1.7rem] mx-auto py-[0.8rem] bg-white cursor-pointer rounded-md w-fit h-fit" value="<?php echo $employee_id ? 'Update' : 'Add'; ?>">
            <?php
                if(isset($_GET['error'])){
                    echo '<p class="text-red-500 text-center">'.$_GET['error'].'</p>';
                }
            ?>
        </form>
    </div>

    <div class="bg-[#808080] text-white rounded-md w-[20%] h-[25%] absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] grid place-items-center transition-all <?php echo !$popup ? "hidden" : null ?>">
        <p class="text-xl text-center">Employee <?php echo $employee_id ? "Updated" : "Added"; ?> Successfully</p>
        <div class="px-[1.5rem] text-black bg-white py-[0.8rem] rounded-md mx-auto w-fit cursor-pointer" onClick="document.location.href='index.php'">Okay!</div>
    </div>

</body>
</html>