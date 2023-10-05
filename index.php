<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "dbpasien";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nama = "";
$nomedik = "";
$alamat = "";
$tgl_lahir = "";
$gender = "";
$kontak = "";
$diagnosa = "";
$tgl_terima = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from datapasien where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data dihapus";
    } else {
        $error = "Terjadi Kesalahan";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from datapasien where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama'];
    $nomedik = $r1['nomedik'];
    $alamat = $r1['alamat'];
    $tgl_lahir = $r1['tgl_lahir'];
    $gender = $r1['gender'];
    $diagnosa = $r1['diagnosa'];
    $kontak = $r1['kontak'];
    $tgl_terima = $r1['tgl_terima'];

    if ($id == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { //create
    $nama       = $_POST['nama'];
    $nomedik    = $_POST['nomedik'];
    $alamat     = $_POST['alamat'];
    $tgl_lahir  = $_POST['tgl_lahir'];
    $gender     = $_POST['gender'];
    $diagnosa   = $_POST['diagnosa'];
    $kontak     = $_POST['kontak'];
    $tgl_terima = $_POST['tgl_terima'];

    if ($nama && $nomedik && $alamat && $tgl_lahir && $gender && $diagnosa && $kontak && $tgl_terima) {
        if ($op == 'edit') { //update
            $sql1 = "update datapasien set nama ='$nama',nomedik = '$nomedik',alamat ='alamat',tgl_lahir ='$tgl_lahir',gender = '$gender',diagnosa = '$diagnosa',kontak = '$kontak',tgl_terima = '$tgl_terima' where id = '$id' ";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data diupdate";
            } else {
                $error = "Update gagal";
            }
        } else { //insert
            $sql1 = "insert into datapasien (nama,nomedik,alamat,tgl_lahir,gender,diagnosa,kontak,tgl_terima) values('$nama','$nomedik','$alamat','$tgl_lahir','$gender','$diagnosa','$kontak','$tgl_terima')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data disimpan";
            } else {
                $error = "Terjadi kesalahan";
            }
        }
    } else {
        $error = "Lengkapi data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 1500px
        }

        .card {
            margin-top: 20px;
        }

        .form-control {
            height: 35px;  
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- masukin data -->
        <div class="card">
            <h5 class="card-header">Create/Edit Data</h5>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control " id="nama" name="nama" value="<?php echo $nama ?>" placeholder="Nama Pasien...">
                            </div>
                            <div class="mb-3 row">
                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>" placeholder="Alamat...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="gender" id="gender">
                                        <option value="">- Pilih Jenis -</option>
                                        <option value="P" <?php if ($gender == "P") echo "selected" ?>>P</option>
                                        <option value="L" <?php if ($gender == "L") echo "selected" ?>>L</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="kontak" class="col-sm-2 col-form-label">Kontak</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="kontak" name="kontak" value="<?php echo $kontak ?>" placeholder="Kontak...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomedik" class="form-label">Nomor Rekam Medis</label>
                                <input type="text" class="form-control" id="nomedik" name="nomedik" value="<?php echo $nomedik ?>" placeholder="Nomor Rekam Medis...">
                            </div>
                            <div class="mb-3 row">
                                <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="<?php echo $tgl_lahir ?>">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="diagnosa" name="diagnosa" value="<?php echo $diagnosa ?>" placeholder="Diagnosa...">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tgl_terima" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="tgl_terima" name="tgl_terima" value="<?php echo $tgl_terima ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>

                </form>
            </div>
        </div>

        <!-- ngeluarin data -->
        <div class="card">
            <h5 class="card-header text-white bg-secondary">Data Pasien</h5>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">No Rekam Medis</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Tanggal Lahir</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Diagnosa</th>
                            <th scope="col">Kontak</th>
                            <th scope="col">Tanggal Masuk</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from datapasien order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nama = $r2['nama'];
                            $nomedik = $r2['nomedik'];
                            $alamat = $r2['alamat'];
                            $tgl_lahir = $r2['tgl_lahir'];
                            $gender = $r2['gender'];
                            $diagnosa = $r2['diagnosa'];
                            $kontak = $r2['kontak'];
                            $tgl_terima = $r2['tgl_terima'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $nomedik ?></td>
                                <td scope="row"><?php echo $alamat ?></td>
                                <td scope="row"><?php echo $tgl_lahir ?></td>
                                <td scope="row"><?php echo $gender ?></td>
                                <td scope="row"><?php echo $diagnosa ?></td>
                                <td scope="row"><?php echo $kontak ?></td>
                                <td scope="row"><?php echo $tgl_terima ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
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
    </div>
</body>

</html>
