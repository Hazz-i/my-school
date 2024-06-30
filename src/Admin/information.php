<?php
    include '../../helper/connection.php';
    include '../../helper/auth.php';
    include '../Layout/Admin/_top.php';
?>

<!-- Page content here -->
<div class="grid items-center ps-[20rem] pt-[7rem]">
    <span class="flex items-center justify-between mb-5">
        <!-- ADD INFORMATION -->
        <div class="flex gap-2 items-center justify-center">
            <h1 class="text-2xl font-bold">Information</h1>
            <button class="btn btn-sm text-white mt-1" onclick="document.getElementById('add_modal').showModal()"><i class="bx bx-plus-circle"></i></button>
        </div>
        <!-- END ADD INFORMATION -->

        <!-- SEARCH -->
        <form action="" method="GET" class="flex items-center">
            <label class="input input-bordered flex items-center gap-2 bg-white me-10 shadow-md text-black">
                <input type="text" name="search" class="grow" placeholder="Search by title" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                <button type="submit"><i class="bx bx-search"></i></button>
            </label>
        </form>
        <!-- END SEARCH -->
    </span>
    <div class="overflow-x-scroll max-w-[95rem] max-h-[48rem] border rounded-box shadow-md me-10">
        <table class="table">
            <!-- head -->
            <thead class="text-black text-lg">
                <tr>
                    <th>No</th>
                    <th>Information Title</th>
                    <th class="text-center">Content</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-black">

            <?php
                include '../../helper/connection.php';

                $search = isset($_GET['search']) ? $_GET['search'] : '';
        
                $sql = "SELECT * FROM informations";

                if (!empty($search)) {
                    $sql .= " WHERE (title LIKE ?)";
                } 

                $stmt = $connection->prepare($sql);

                if (!empty($search)) {
                    $searchParam = "%$search%";
                    $stmt->bind_param("s", $searchParam);
                }

                $stmt->execute();
                $result = $stmt->get_result();

                $no = 1;

                if ($result->num_rows == 0) {
                    echo "<tbody>";
                    echo "<tr>";
                    echo "<td colspan='6' class='text-center'>No Data.</td>";    
                    echo "</tr>";
                    echo "</tbody>";
                }

                while($data = $result->fetch_assoc()){
            ?>
                    <!-- row 1 -->
                    <tr>
                        <th>
                            <span class="text-sm"><?php echo $no ?></span>
                        </th>
                        <td>
                                <div>
                                    <div class="font-bold"><?php echo $data['title'] ?></div>
                                    <div class="text-sm opacity-50"><?php echo $data['location'] ?></div>
                                </div>
                            </div>
                        <td>
                            <p class="text-sm max-h-10 overflow-x-scroll">
                                <?php echo $data["description"]?>
                            </p>
                        </td>
                        <td class="flex items-center justify-center"><img src="./uploads/<?php echo $data["image"] ?>" class="max-w-20 max-h-20 rounded-md"></td>
                        <td class="text-center text-nowrap"><?php echo $data["information_date"] ?></td>
                        <th>
                            <span class="flex items-center justify-center gap-1">
                                <button class="btn btn-sm bg-black text-white border-none text-lg" onclick="openUpdateModal(<?php echo $data['information_id']; ?>)"><i class="bx bx-edit"></i></button>    
                                <button class="btn btn-sm bg-red-500 text-white border-none text-lg" onclick="deleteInformation(<?php echo $data['information_id']?>)"><i class="bx bx-trash"></i></button>
                            </span> 
                        </th>
                    </tr>
            <?php
                $no++;
                }

                echo "</tbody>";
                echo "</table>";
            ?>
    </div>

    <!-- MODAL ADD -->
    <dialog id="add_modal" class="modal">
            <form action="./informationCRUD/create.php" class="mb-10 border w-[40rem] shadow-md py-5 px-10 mt-4 rounded-box bg-gray-100 modal-box text-black" enctype="multipart/form-data" method="POST">
                    <h1 class="text-2xl font-bold text-black">Add information</h1>
        
                    <span class="grid gap-2 mt-5">
                            <input type="file" name="image" class="file-input file-input-bordered file-input-sm w-full border bg-white" required/>
                            <div class="flex flex-col">
                                <label for="title" class="text-lg font-semibold text-black">Information Title</label>
                                <input type="text" name="title" id="title" class="input input-bordered bg-white" placeholder="Enter Information Title" />
                            </div>
                            <div class="flex flex-col">
                                <label for="location" class="text-lg font-semibold text-black">Location</label>
                                <input type="text" name="location" id="location" class="input input-bordered bg-white" placeholder="Enter Information location" />
                            </div>
                            <div class="flex flex-col">
                                <label for="content" class="text-lg font-semibold text-black">Content</label>
                                <textarea name="description" id="content" class="input input-bordered bg-white h-40 py-1" placeholder="Enter Content"></textarea>
                            </div>
                    </span>
                    <div class="flex justify-end mt-4">
                        <button class="btn text-white w-36" type="sumbit">Save</button>
                    </div>
            </form>

            <form method="dialog" class="modal-backdrop">
                    <button>close</button>
            </form>
    </dialog>
    <!-- END MODAL ADD -->

    <!-- MODAL UPDATE -->
    <dialog id="update_modal" class="modal">
        <form id="updateForm" class="mb-10 border w-[40rem] shadow-md py-5 px-10 mt-4 rounded-box bg-gray-100 modal-box text-black" enctype="multipart/form-data" method="POST" action="./informationCRUD/delete.php?information_id=<?php echo $data['information_id']?>">
            <h1 class="text-2xl font-bold text-black">Update information</h1>
            <div id="formContent">
                <!-- NANTI BERISI CONTENT -->
            </div>
            <div class="flex justify-end mt-4">
                <button class="btn text-white w-36" onclick="updateInformation()">Save</button>
            </div>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <!-- END MODAL UPDATE -->

    <!-- MODAL DELETE -->
    <dialog id="delete_information_modal" class="modal">
        <div class="modal-box bg-white text-black">
            <h3 class="font-bold text-lg">Confirm Delete</h3>
            <p class="py-4">Anda yakin untuk menghapus data?</p>
            <div class="modal-action">
                <button class="btn btn-outline mr-2" onclick="document.getElementById('delete_information_modal').close()">Cancel</button>
                <button class="btn btn-error text-white" onclick="confirmDelete()">Delete</button>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
    <!-- END MODAL DELETE -->

</div>

<script>

    let updateId;
    let deleteId;


    // BUKA MODAL UPDATE
    function openUpdateModal(informationId) {
        updateId = informationId;
        document.getElementById('update_modal').showModal();
        
        // Use AJAX to load the form content
        fetch('./informationCRUD/edit.php?id=' + informationId)
            .then(response => response.text())
            .then(data => {
                document.getElementById('formContent').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }


    // UPDATE INFORMATION
    function updateInformation() {
        const form = document.getElementById('updateForm');
        const formData = new FormData(form);
        formData.append('id', updateId);

        if (typeof updateId === 'undefined' || updateId === null) {
            console.error('updateId tidak didefinisikan');
            return;
        }

        fetch('./informationCRUD/update.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.text();
        })
        .then(data => {
            console.log(data);
            if (data.includes("Error")) {
                window.location.reload();
            } else {
                toastr.error("Terjadi kesalahan");
            }
        })
        .catch(error => {
            toastr.error("Error");
        });
    }


    // DELETE INFORMATION
    function deleteInformation(getIformationID){
        deleteId = getIformationID;
        document.getElementById('delete_information_modal').showModal();
    }


    function confirmDelete(){
        if (deleteId) {
            fetch('./informationCRUD/delete.php?information_id=' + deleteId)
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    closeModal();
                })
                .catch(error => {
                    console.error('Error:', error);
                    window.location.reload();
                    closeModal();
                });
        }
    }

</script>

<?php
    include '../Layout/Admin/_bottom.php';
?>

