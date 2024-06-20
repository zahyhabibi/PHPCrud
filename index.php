<?php
include "koneksi.php";

$order = isset($_GET['order']) ? $_GET['order'] : 'id_tittle';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'ASC';

// Toggle sort direction
$sort = ($sort == 'ASC') ? 'DESC' : 'ASC';

// Search logic
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

$query = "SELECT * FROM artikel WHERE tittle LIKE '$search%' ORDER BY $order $sort";
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Crud Artikel - PHP MySQL</title>
</head>
<body>
    <div class="d-flex p-5 justify-content-between">
        <h4>Tables Blog</h4>
        <button type="button" class="btn btn-primary mb-3 ms-auto" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
    </div>
    <div class="container">
        <div class="card">
            <h5 class="card-header text-primary">Data Blog</h5>
            <div class="card-body">
            <form method="GET" action="index.php" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="ms-auto" placeholder="Search by Title">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>
                <table class="table table-bordered table-striped table-hover">
                <tr>
        <th>
            <a class="text-dark list-group-item list-group-item-action" href="?order=id_tittle&sort=<?php echo $sort; ?>">
                ID
                <?php if ($order == 'id_tittle') echo $sort == 'ASC' ? '▲' : '▼'; ?>
            </a>
        </th>
        <th>
            <a class="text-dark list-group-item list-group-item-action" href="?order=tittle&sort=<?php echo $sort; ?>">
                Tittle
                <?php if ($order == 'tittle') echo $sort == 'ASC' ? '▲' : '▼'; ?>
            </a>
        </th>
        <th>
            <a class="text-dark list-group-item list-group-item-action" href="?order=img&sort=<?php echo $sort; ?>">
                Gambar
                <?php if ($order == 'img') echo $sort == 'ASC' ? '▲' : '▼'; ?>
            </a>
        </th>
        <th>
            <a class="text-dark list-group-item list-group-item-action" href="?order=tanggal&sort=<?php echo $sort; ?>">
                Date
                <?php if ($order == 'tanggal') echo $sort == 'ASC' ? '▲' : '▼'; ?>
            </a>
        </th>
        <th>
            <a class="text-dark list-group-item list-group-item-action" href="?order=category&sort=<?php echo $sort; ?>">
                Category
                <?php if ($order == 'category') echo $sort == 'ASC' ? '▲' : '▼'; ?>
            </a>
        </th>
        <th>Option</th>
    </tr>

    <?php
            $no = 1;
            $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
            $query = "SELECT * FROM artikel WHERE tittle LIKE '$search%' ORDER BY $order $sort";
            $tampil = mysqli_query($koneksi, $query);
            while ($data = mysqli_fetch_array($tampil)) :
            ?>
                    <tr>
                        <td><?= $data['id_tittle'] ?></td>
                        <td><?= $data['tittle'] ?></td>
                        <td><img src="assets/images<?= $data['img'] ?>" alt="<?= $data['tittle'] ?>" style="width:100px;"></td>
                        <td><?= $data['tanggal'] ?></td>
                        <td><?= $data['category'] ?></td>
                        <td class="d-flex justify-content-center">
                            <a class="btn btn-primary m-2" href="#"data-bs-toggle = "modal" data-bs-target="#modalDetail<?= $data['id_tittle'] ?>" >Details</a>
                            <a class="btn btn-warning m-2" href="#" data-bs-toggle = "modal" data-bs-target="#modalUbah<?= $data['id_tittle'] ?>">Edit</a>
                            <a class="btn btn-danger m-2" href="crud_artikel.php?delete=<?= $data['id_tittle'] ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                        </td>
                    </tr>

                <!-- Modal -->
                <div class="modal fade" id="modalDetail<?= $data['id_tittle'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="crud_artikel.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_tittle" value="<?= $data['id_tittle']?>">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" value="<?= $data['tittle']?>" name="ttittle" class="form-control" placeholder="Masukan Title" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date Update</label>
                                        <input class="form-control" value="<?= $data['tanggal'] ?>" type="text" name="tdate" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label  class="form-label">Category</label>
                                        <input class="form-control" type="text" value="<?= $data['category']?>" name="tcategory" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Select an image:</label>
                                        <input value="<?= $data['img']?>" class="form-control" name="timg" type="file" id="myfile" readonly>
                                        <img src="assets/images<?= $data['img'] ?>" alt="<?= $data['tittle'] ?>" style="width:100px;">
                                        <label class="form-text">gambar saat ini</label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button name="bchange" type="submit" class="btn btn-primary">Change</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal -->  


                <!-- Modal -->
                <div class="modal fade" id="modalUbah<?= $data['id_tittle'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ubah Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="crud_artikel.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id_tittle" value="<?= $data['id_tittle']?>">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" value="<?= $data['tittle']?>" name="ttittle" class="form-control" placeholder="Masukan Title">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date:</label>
                                        <input class="form-control" value="<?= $data['tanggal'] ?>" type="date" name="tdate">
                                    </div>
                                    <div class="mb-3">
                                        <label  class="form-label">Category</label>
                                        <select class="form-select" name="tcategory">
                                            <option value="<?= $data['category']?>"><?= $data['category'] ?></option>
                                            <option value="news">News</option>
                                            <option value="entertaint">entertaint</option>
                                            <option value="hiburan">Hiburan</option>
                                            <option value="prakiraan cuaca">Prakiraan Cuaca</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Select an image:</label>
                                        <input value="<?= $data['img']?>" class="form-control" name="timg" type="file" id="myfile">
                                        <img src="assets/images<?= $data['img'] ?>" alt="<?= $data['tittle'] ?>" style="width:100px;">
                                        <label class="form-text">gambar saat ini, maksimal ukuran gambar 1MB</label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button name="bchange" type="submit" class="btn btn-primary">Change</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal -->  


                    <?php endwhile; ?>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="crud_artikel.php" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="ttittle" class="form-control" placeholder="Masukan Title">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date:</label>
                                        <input class="form-control" type="date" name="tdate">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Category</label>
                                        <select class="form-select" name="tcategory">
                                            <option value="news">News</option>
                                            <option value="entertaint">entertaint</option>
                                            <option value="hiburan">Hiburan</option>
                                            <option value="prakiraan cuaca">Prakiraan Cuaca</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Select an image:</label>
                                        <input class="form-control" name="timg" type="file" id="myfile">
                                        <label class="form-text">maksimal ukuran gambar 1MB</label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button name="bsave" type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal -->  
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
