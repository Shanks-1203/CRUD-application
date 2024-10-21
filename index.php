<?php
    include('header.php');

    $popup = false;
    $delete_id = isset($_GET['delete_id']) ? $_GET['delete_id'] : null;
    $search_query = isset($_GET['query']) ? $_GET['query'] : null;


    if($delete_id){
        $query = "delete from `employee_info` where id='$delete_id'";
    
        $result = mysqli_query($connection, $query);
    
        if(!$result){
            die("Query failed".mysqli_error($connection));
        } else {
            $popup = true;
        }
    }

?>
    <div class="w-[90%] mx-auto mt-[3rem]">
        <?php include('search.php')?>
        <div class="flex justify-between items-center">
            <p class="text-xl font-medium">All Employees</p>
            <p class="py-[0.8rem] px-[1.5rem] rounded-md bg-[#80808060] flex items-center gap-2 cursor-pointer" onClick="document.location.href='form.php'">Add<img src="./Images/add.png" alt="add" class="w-[1.2rem]"></p>
        </div>
        <table class="table-auto mt-[1rem] w-full text-left">
            <thead class="h-[3rem] text-lg bg-[#80808060]">
                <tr>
                    <th class="table-header-text">Id</th>
                    <th class="table-header-text">First Name</th>
                    <th class="table-header-text">Last Name</th>
                    <th class="table-header-text">Age</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php

                    if($search_query){
                        $query = "select * from `employee_info` where `first_name` like '%$search_query%' or `last_name` like '%$search_query%'";
                    } else{
                        $query = "select * from `employee_info`";
                    }

    
                    $result = mysqli_query($connection, $query);
    
                    if(!$result){
                        die("Query failed".mysqli_error($connection));
                    } else {
    
                        while($row = mysqli_fetch_assoc($result)){
                            ?>
                                <tr class="h-[3rem] even:bg-[#80808020]">
                                    <td class="table-body-text"><?php echo $row['id']; ?></td>
                                    <td class="table-body-text"><?php echo $row['first_name']; ?></td>
                                    <td class="table-body-text"><?php echo $row['last_name']; ?></td>
                                    <td class="table-body-text"><?php echo $row['age']; ?></td>
                                    <td>
                                        <div class="flex justify-evenly items-center">
                                            <img src="./Images/pen.png" alt="edit" class="action-icons" onClick="editEmployee(<?php echo $row['id']; ?>)">
                                            <img src="./Images/recycle-bin.png" alt="edit" class="action-icons" onClick="showDeletePopup(<?php echo $row['id']; ?>, '<?php echo $row['first_name']; ?>', '<?php echo $row['last_name']; ?>')">
                                        </div>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                ?>
            </tbody>
        </table>
        <div id="deletePopup" class="fixed top-[50%] left-[50%] scale-0 transition-all translate-x-[-50%] translate-y-[-50%] py-[1rem] w-[25%] h-[22%] bg-[#808080] text-white rounded-md grid place-items-center">
            <p>Are you sure you want to delete the record?</p>
            <p id="employee-name">name</p>
            <div class="flex justify-center gap-[5rem] items-center text-black">
                <p class="px-[1.5rem] py-[0.8rem] bg-white rounded-md cursor-pointer" onClick="deleteEmployee()">Yes</p>
                <p class="px-[1.5rem] py-[0.8rem] bg-white rounded-md cursor-pointer" onClick="hideDeletePopup()">No</p>
            </div>
        </div>
        <div id="deleteConfirmation" class="fixed top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] py-[1rem] w-[20%] h-[20%] bg-[#808080] text-white rounded-md grid place-items-center <?php echo !$popup ? "hidden" : null ?>">
            <p>Record deleted successfully!</p>
            <p class="px-[1.5rem] py-[0.8rem] bg-white rounded-md cursor-pointer text-black" onClick="handleNavigation()">Okay!</p>
        </div>

    </div>

    <script>
        let deleteId = null;

        function editEmployee(id) {
            window.location.href = 'form.php?employee_id=' + id;
        }

        function showDeletePopup(id, fname, lname) {
            deleteId = id;
            document.getElementById('employee-name').innerText = `${fname} ${lname}?`;
            document.getElementById('deletePopup').classList.remove('scale-0');
        }

        function hideDeletePopup() {
            document.getElementById('deletePopup').classList.add('scale-0');
        }

        function deleteEmployee() {
            window.location.href = 'index.php?delete_id=' + deleteId;
        }

        function handleNavigation() {
            window.location.href = 'index.php';
        }

    </script>


</body>
</html>