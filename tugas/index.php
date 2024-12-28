<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "soal3";

$konek = mysqli_connect($host, $user, $pass, $db);
if (!$konek) {
    die("Tidak Terhubung");
}
$nama = "";
$nim = "";
$fakultas = "";
$jurusan = "";
$sukses = "";
$error = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
} else{
    $op = "";
}
if($op == 'delete'){
    $id = $_GET['id'];
    $sql1 = "delete from mahasiswa where id = '$id'";
    $q1 = mysqli_query($konek, $sql1);
    if($q1){
        $sukses ="Berhasil hapus data";
    }
    else{
        $error ="Gagal menghapus data";
    }
}


if($op == 'edit'){
    $id = $_GET['id'];
    $sql1 = "select * from mahasiswa where id = '$id'";
    $q1 = mysqli_query($konek,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama'];
    $nim = $r1['nim'];
    $fakultas = $r1['fakultas'];
    $jurusan = $r1['jurusan'];

    if($nim == ''){
        $error ="Data tidak ada";
    }
}


if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $jurusan = $_POST['jurusan'];

    if ($nim && $nama && $fakultas && $jurusan) {
        if($op == 'edit'){ //update
            $sql1 = "update mahasiswa set nim ='$nim', nama = '$nama', fakultas = '$fakultas', jurusan = '$jurusan' where id = '$id'";
            $q1 = mysqli_query($konek, $sql1);
            if($q1){
                $sukses = " Data Diperbarui";
            }
            else{
                $error = "Data Gagal Diperbaru!";
            }
        } 
        else{ //insert
            $sql1 = "insert into mahasiswa(nama, nim, fakultas, jurusan) values ('$nama', '$nim', '$fakultas', '$jurusan')";
        $q1 = mysqli_query($konek, $sql1);
        if ($q1) {
            $sukses = "Data Berhasil Masuk";
        } else {
            $error = "Data gagal dimasukkan";
        }
        }
        
    } else {
        $error = "Masukkan semua data yang ada";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 750px
        }

        .card {
            margin-top: 20px
        }
    </style>
    <title>Submission</title>
</head>

<body>
    <div class="mx-auto">

        <!--Untuk Memasukkan Data-->
        <div class="card">
            <div class="card-header">
                Create or Edit</>
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">Nim</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="fakultas" name="fakultas"
                                value="<?php echo $fakultas ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="jurusan" id="jurusan">
                                <option value="">- Pilih Jurusan -</option>
                                <option value="teknikinformatika" <?php if ($jurusan == "Teknik Informatika")
                                    echo "selected" ?>>Teknik Informatika</option>
                                    <option value="sisteminformasi" <?php if ($jurusan == "Sistem Informasi")
                                    echo "selected" ?>>Sistem Informasi</option>
                                    <option value="manajemeninformatika" <?php if ($jurusan == "Manajemen Informatika")
                                    echo "selected" ?>>Manajemen Informatika</option>
                                    <option value="teknikkomputer" <?php if ($jurusan == "Teknik Komputer")
                                    echo "selected" ?>>
                                        Teknik Komputer</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan data" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>

            <!--Untuk Mengeluarkan Data-->
            <div class="card">
                <div class="card-header text-white bg-secondary">
                    Data Mahasiswa
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Nim</th>
                                <th scope="col">Fakultas</th>
                                <th scope="col">Jurusan</th>
                                <th scope="col">mau apa?</th>
                            </tr>
                        <tbody>
                            <?php
                                $sql2 = "select * from mahasiswa order by id desc";
                                $q2 = mysqli_query($konek, $sql2);
                                $urut = 1;
                                while ($r2 = mysqli_fetch_array($q2)) {
                                    $id = $r2['id'];
                                    $nama = $r2['nama'];
                                    $nim = $r2['nim'];
                                    $fakultas = $r2['fakultas'];
                                    $jurusan = $r2['jurusan'];
                                    ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $fakultas ?></td>
                                <td scope="row"><?php echo $jurusan ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id?>"> <button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>"onclick ="return confirm('Yakin dek?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                                }
                                ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</body>

</html>