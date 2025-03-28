<?php
require_once 'function.php';
$connect = get_sql();

$id_klienta = $_COOKIE['id'];

$rezerwacja = "SELECT * FROM rezerwacja WHERE ID_Klient = '$id_klienta'";
$result = mysqli_query($connect, $rezerwacja);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twoje aktywne rezerwacje</title>
    <link rel="stylesheet" href="aktywne.css">

</head>

<body>
<div class="naglowek">
        <ul>
            <li><a href="index.php">Strona główna </a></li>
            <li style="float:right"><a href="wyloguj.php">Wyloguj się</a></li>
        </ul>
    </div>
    <div class="container">
    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
        <form method='post' action='oplacenie.php'>
            <table>
                <tr>
                    <th>Akcja:</th>
                    <th>Sala:</th>
                    <th>Data:</th>
                    <th>Godzina:</th>
                    <th>Ilość biletów:</th>
                    <th>Miejsce:</th>
                    <th>Cena biletu:</th>
                    <th>Status:</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td>
                            <?php if ($row['status'] == 0) { ?>
                                <input type='radio' name='thisIDRezerwacja' value='<?= $row["ID_Rezerwacja"] ?>'>
                            <?php } else { ?>
                                <input type='radio' name='thisIDRezerwacja' value='<?= $row["ID_Rezerwacja"] ?>' disabled>
                            <?php } ?>
                        </td>
                        <td><?= $row['ID_Sala'] ?></td>
                        <td><?= $row['data'] ?></td>
                        <td><?= $row['godzina'] ?></td>
                        <td><?= $row['ilosc_biletow'] ?></td>
                        <td><?= $row['miejsce'] ?></td>
                        <td><?= $row['cena'] ?></td>
                        <td><?php echo ($row['status'] == 0) ? "Nieopłacona" : "Opłacona"; ?></td>
                    </tr>
                <?php
                }
                ?>
                
            </table>
            <input type='submit' class="btn" value='Opłać'>
            </form>
            

       
    <?php
    } else {
    ?>
        Nie masz rezerwacji...
    <?php
    }
    ?>
    </div>
</body>

</html>

