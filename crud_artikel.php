<?php 
include "koneksi.php";

if(isset($_POST['bsave'])){
    $title = mysqli_real_escape_string($koneksi, $_POST['ttittle']);
    $date = mysqli_real_escape_string($koneksi, $_POST['tdate']);
    $category = mysqli_real_escape_string($koneksi, $_POST['tcategory']);

    // Handle image upload
    $img_name = $_FILES['timg']['name'];
    $img_temp = $_FILES['timg']['tmp_name'];
    $img_folder = 'assets/images'.$img_name;

    if(!empty($title) && !empty($date) && !empty($category) && !empty($img_name)) {
        // Move uploaded file to the specified folder
        if(move_uploaded_file($img_temp, $img_folder)) {
            // Save new data
            $simpan = mysqli_query($koneksi, "INSERT INTO artikel (tittle, tanggal, category, img)  
            VALUES('$title', '$date', '$category', '$img_name')");

            if($simpan){
                echo "<script>
                    alert('Save data Success!');
                    document.location ='index.php'
                    </script>";
            } else {
                echo "<script>
                    alert('Save data Failed!');
                    document.location ='index.php'
                    </script>";
            }
        } else {
            echo "<script>
                alert('Failed to upload image!');
                document.location ='index.php'
                </script>";
        }
    } else {
        echo "<script>
            alert('All fields are required!');
            document.location ='index.php'
            </script>";
    }
}

if(isset($_POST['bchange'])){
    $id_tittle = mysqli_real_escape_string($koneksi, $_POST['id_tittle']);
    $title = mysqli_real_escape_string($koneksi, $_POST['ttittle']);
    $date = mysqli_real_escape_string($koneksi, $_POST['tdate']);
    $category = mysqli_real_escape_string($koneksi, $_POST['tcategory']);

    // Handle image upload
    $img_name = $_FILES['timg']['name'];
    $img_temp = $_FILES['timg']['tmp_name'];
    $img_folder = 'assets/images'.$img_name;

    if(!empty($title) && !empty($date) && !empty($category)) {
        if(!empty($img_name)) {
            // Move uploaded file to the specified folder
            move_uploaded_file($img_temp, $img_folder);
            $img_query = "img = '$img_name',";
        } else {
            $img_query = "";
        }

        // Update existing data
        $ubah = mysqli_query($koneksi, "UPDATE artikel SET
                                        tittle = '$title',
                                        $img_query
                                        tanggal = '$date',
                                        category = '$category'
                                        WHERE id_tittle = '$id_tittle'");

        if($ubah){
            echo "<script>
                alert('Update data Success!');
                document.location ='index.php'
                </script>";
        } else {
            echo "<script>
                alert('Update data Failed!');
                document.location ='index.php'
                </script>";
        }
    } else {
        echo "<script>
            alert('All fields are required!');
            document.location ='index.php'
            </script>";
    }
}

if(isset($_GET['delete'])){
    $id_tittle = mysqli_real_escape_string($koneksi, $_GET['delete']);
    
    // Query untuk menghapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM artikel WHERE id_tittle = '$id_tittle'");
    
    if($hapus){
        echo "<script>
            alert('Delete data Success!');
            document.location ='index.php'
            </script>";
    } else {
        echo "<script>
            alert('Delete data Failed!');
            document.location ='index.php'
            </script>";
    }
}
?>
