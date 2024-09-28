<?php
session_start();
require("./database/conn.php");
require("./function.php");

if (!isset($_SESSION['current_word']) || empty($_SESSION['current_word'])) {
    $dataKata = getRandomKata($mysqli, getRandomNumber($mysqli));
    $_SESSION['current_word'] = $dataKata;
} else {
    $dataKata = $_SESSION['current_word'];
}

$kata = str_split($dataKata['kata']);
$point = isset($_SESSION['point']) ? $_SESSION['point'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit_points'])) {
        $username = $_POST['username'];
        $stmt = $mysqli->prepare("INSERT INTO point_game (nama_user, total_point) VALUES (?, ?)");
        $stmt->bind_param("si", $username, $point);
        
        if ($stmt->execute()) {
            $_SESSION['point'] = 0;
            unset($_SESSION['current_word']);
            echo "<script>alert('Points saved successfully!');</script>";
        } else {
            echo "<script>alert('Error saving points: " . $mysqli->error . "');</script>";
        }
        
        $dataKata = getRandomKata($mysqli, getRandomNumber($mysqli));
        $_SESSION['current_word'] = $dataKata;
        $kata = str_split($dataKata['kata']);
    } elseif (isset($_POST['kata'])) {
        $isCorrect = true;
        $pointDetails = [];
        $totalPointsThisRound = 0;

        foreach ($kata as $index => $correctLetter) {
            $inputHuruf = isset($_POST['kata'][$index]) ? $_POST['kata'][$index] : '';
            $pointChange = 0;

            if ($index == 2 || $index == 6) {
                $pointChange = 0;
                $totalPointsThisRound += 0;
            } elseif ($inputHuruf === '') {
                $pointChange = -2;
                $totalPointsThisRound -= 2;
                $isCorrect = false;
            } elseif (strtolower($inputHuruf) === strtolower($correctLetter)) {
                $pointChange = 10;
                $totalPointsThisRound += 10;
            } else {
                $pointChange = -2;
                $totalPointsThisRound -= 2;
                $isCorrect = false;
            }

            $pointDetails[] = "$inputHuruf -> " . ($pointChange >= 0 ? '+' : '') . "$pointChange point";
        }

        $point += $totalPointsThisRound;
        $_SESSION['point'] = $point;

        $pointDetailsString = implode("\n", $pointDetails);
        $alertMessage = $isCorrect ? "Jawaban benar!" : "Jawaban salah.";
        $alertMessage .= "\nJawaban yang benar: " . ucfirst(strtolower($dataKata['kata']));
        $alertMessage .= "\nDetail perhitungan point:\n$pointDetailsString";
        $alertMessage .= "\nTotal point ronde ini: " . ($totalPointsThisRound >= 0 ? '+' : '') . "$totalPointsThisRound";
        $alertMessage .= "\nTotal point keseluruhan: $point";

        echo "<script>
        alert(`" . str_replace("`", "\\`", $alertMessage) . "`);
        </script>";

        $dataKata = getRandomKata($mysqli, getRandomNumber($mysqli));
        while ($dataKata == $_SESSION['current_word']){
            $dataKata = getRandomKata($mysqli, getRandomNumber($mysqli));
        }
        $_SESSION['current_word'] = $dataKata;
        $kata = str_split($dataKata['kata']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kata Tebak-Tebakan</title>
</head>
<body>
    <h1>Clue: <?= htmlspecialchars($dataKata['clue']); ?></h1>

    <form action="" method="POST">
        <?php foreach ($kata as $index => $huruf): ?>
            <?php
            $value = '';
            if ($index == 2 || $index == 6) {
                $value = $huruf;
            }
            ?>
            <input type="text" name="kata[]" maxlength="1" value="<?= htmlspecialchars($value); ?>" <?= $value ? "disabled" : "" ?> style="width: 20px; text-align: center;" />
            
            <?php if ($index == 2 || $index == 6): ?>
                <input type="hidden" name="kata[]" value="<?= htmlspecialchars($huruf); ?>" />
            <?php endif; ?>
        <?php endforeach; ?>
        <br><br>
        <button type="submit">Jawab</button>
    </form>
    
    <form action="" method="POST">
        <?php if ($point != 0): ?>
            <input type="text" name="username" placeholder="Enter your name" required style="margin-top: 10px;" />
            <button type="submit" name="submit_points" style="margin-top: 10px;">Simpan Poin</button>
        <?php endif; ?>
    </form>
    
    <?php if (isset($_SESSION['point'])): ?>
        <h2>Your Total Points: <?= $_SESSION['point']; ?></h2>
    <?php endif; ?>
</body>
</html>