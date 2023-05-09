<?php
    require_once('./config/db.php');
    $search = @$_GET['search'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class='bg-gray-100 p-8 space-y-8'>
    <!-- Title -->
    <h1 class='font-bold text-3xl text-center' >Technical Test Web Developer</h1>
    <!-- Input Form -->
    <form class='max-w-4xl mx-auto border shadow bg-white p-8 rounded-xl space-y-4'>
        <div id='alert' class='space-y-2'></div>
        <div class="grid grid-cols-2 gap-4">
            <div class='flex flex-col space-y-2'>
                <label for="name">Nama Lengkap</label>
                <input type="text" id='name' name='name' class='border h-10 rounded-md px-3 outline-none focus:border-blue-600' />
            </div>
            <div class='flex flex-col space-y-2'>
                <label for="email">Email</label>
                <input type="email" id='email' name='email' class='border h-10 rounded-md px-3 outline-none focus:border-blue-600' />
            </div>
        </div>
        <div class='flex flex-col space-y-4'>
            <input type="file" id='file' name='file' class='hidden' accept="image/*" />
            <span>Photo</span>
            <div class='text-white bg-gray-500 w-32 h-36 rounded-md flex items-center justify-center bg-gray-400'>
                <img id='preview' src="" alt="" class='w-32 h-36 object-center object-cover rounded-md'>
            </div>
            <div>
                <label for="file" class='rounded-md bg-blue-400 hover:bg-blue-500 text-white cursor-pointer py-2 px-3'>Pilih Foto</label>
            </div>
        </div>
        <button type='button' id='btn-submit' class='rounded-md bg-green-400 hover:bg-green-500 text-white cursor-pointer py-2 px-3' >Submit</button>
    </form>

    <div class='max-w-4xl mx-auto border shadow bg-white p-8 rounded-xl space-y-4'>
        <form action="GET">
        <input type="text" id='search' name='search' class='border h-10 rounded-md px-3 outline-none focus:border-blue-600' placeholder='Cari..' value="<?= $search ?>"/>
        <button type='submit' id='btn-cari' class='rounded-md bg-blue-400 hover:bg-blue-500 text-white cursor-pointer py-2 px-3' >Cari</button>
        </form>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th class='border px-2 py-1'>Nama Lengkap</th>
                    <th class='border px-2 py-1'>Email</th>
                    <th class='border px-2 py-1'>Photo</th>
                    <th class='border px-2 py-1'>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try{
                    $query = "SELECT * FROM users";
                    $is_search = !empty($search);

                    $params = [];

                    if ($is_search) {
                        $query = $query . " WHERE name LIKE :search";
                        $params['search'] = '%' . $search . '%';
                    }
                    $sql = $connection->prepare($query);
                    $sql->execute($params);
                    $result = $sql->fetchAll(\PDO::FETCH_ASSOC);
                    } catch (\Throwable $e) { 
                    print_r($e);
                    } catch (\Exception $e) { // For PHP 5
                    print_r($e);
                    }
                    foreach($result as $row) {
                ?>
                <tr>
                    <td class='border px-2 py-1'><?= $row['name'] ?></td>
                    <td class='border px-2 py-1'><?= $row['email'] ?></td>
                    <td class='border px-2 py-1'><img src="<?= $row['photo'] ?>" class='h-32 w-24 object-center object-cover'/></td>
                    <td class='border px-2 py-1'><?= $row['status'] == 1 ? 'Aktif' : 'Non Aktif' ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- End Input Form -->
    <!-- Javascript -->
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./js/script.js"></script>
</body>
</html>