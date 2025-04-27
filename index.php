<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function convertNumberToWords($number) {
    $words = array(
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen',
        17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
        20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
        60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    );

    $units = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];

    if ($number == 0) return 'Zero';

    $numStr = strval($number);
    $numGroups = array_reverse(str_split(str_pad($numStr, ceil(strlen($numStr) / 3) * 3, '0', STR_PAD_LEFT), 3));
    $textParts = [];

    foreach ($numGroups as $index => $group) {
        $num = intval($group);
        if ($num == 0) continue;

        $hundred = floor($num / 100);
        $remainder = $num % 100;
        $groupText = '';

        if ($hundred) {
            $groupText .= $words[$hundred] . ' Hundred';
        }
        if ($remainder) {
            if ($remainder < 20) {
                $groupText .= ($groupText ? ' ' : '') . $words[$remainder];
            } else {
                $groupText .= ($groupText ? ' ' : '') . $words[floor($remainder / 10) * 10];
                if ($remainder % 10) {
                    $groupText .= ' ' . $words[$remainder % 10];
                }
            }
        }
        if ($units[$index]) {
            $groupText .= ' ' . $units[$index];
        }
        array_unshift($textParts, $groupText);
    }

    return implode(' ', $textParts);
}

function convertNumberToKhmerWords($number) {
    $khmerWords = array(
        0 => 'សូន្យ', 1 => 'មួយ', 2 => 'ពីរ', 3 => 'បី', 4 => 'បួន',
        5 => 'ប្រាំ', 6 => 'ប្រាំមួយ', 7 => 'ប្រាំពីរ', 8 => 'ប្រាំបី', 9 => 'ប្រាំបួន',
        10 => 'ដប់', 11 => 'ដប់មួយ', 12 => 'ដប់ពីរ', 13 => 'ដប់បី',
        14 => 'ដប់បួន', 15 => 'ដប់ប្រាំ', 16 => 'ដប់ប្រាំមួយ',
        17 => 'ដប់ប្រាំពីរ', 18 => 'ដប់ប្រាំបី', 19 => 'ដប់ប្រាំបួន',
        20 => 'ម្ភៃ', 30 => 'សាមសិប', 40 => 'សែសិប', 50 => 'ហាសិប',
        60 => 'ហុកសិប', 70 => 'ចិតសិប', 80 => 'ប៉ែតសិប', 90 => 'កៅសិប'
        
    );

    $units = ['', 'ពាន់', 'លាន', 'ប៊ីលាន', 'ទ្រីលាន'];

    if ($number == 0) return 'សូន្យ';

    $numStr = strval($number);
    $numGroups = array_reverse(str_split(str_pad($numStr, ceil(strlen($numStr) / 3) * 3, '0', STR_PAD_LEFT), 3));
    $textParts = [];

    foreach ($numGroups as $index => $group) {
        $num = intval($group);
        if ($num == 0) continue;

        $hundred = floor($num / 100);
        $remainder = $num % 100;
        $groupText = '';

        if ($hundred) {
            $groupText .= $khmerWords[$hundred] . ' រយ';
        }
        if ($remainder) {
            if ($remainder < 20) {
                $groupText .= ($groupText ? ' ' : '') . $khmerWords[$remainder];
            } else {
                $groupText .= ($groupText ? ' ' : '') . $khmerWords[floor($remainder / 10) * 10];
                if ($remainder % 10) {
                    $groupText .= ' ' . $khmerWords[$remainder % 10];
                }
            }
        }
        if ($units[$index]) {
            $groupText .= ' ' . $units[$index];
        }
        array_unshift($textParts, $groupText);
    }

    return implode(' ', $textParts);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['number'])) {
    $inputNumber = $_POST['number'];


    if (!ctype_digit($inputNumber)) {
        $error = "Please enter a valid number.";
        $result = null;
    } else {
        $inputNumber = intval($inputNumber);
        $englishWords = convertNumberToWords($inputNumber) . ' Riel';
        $khmerWords = convertNumberToKhmerWords($inputNumber) . ' រៀល';
        $dollarAmount = $inputNumber / 4000;
        $dollars = ($dollarAmount == floor($dollarAmount)) ? number_format($dollarAmount, 0) . ' $' : number_format($dollarAmount, 2) . ' $';
        $result = "$inputNumber : $englishWords : $dollars : $khmerWords\n";
        $file = fopen("results.txt", "a");
        fwrite($file, $result);
        fclose($file);
    }
} else {
    $result = null;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number to Words Converter</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Battambang:wght@100;300;400;700;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        body {
            font-family: "Poppins","Battambang", sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .container {
            background: white;
            padding: 20px;
            width: 50%;
            margin: auto;
            box-shadow: 0px 0px 10px #aaa;
            border-radius: 10px;
        }
        input, button {
            margin: 10px;
            padding: 10px;
            width: 80%;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 2rem;
        }
        button {
            background:rgb(0, 81, 255);
            color: white;
            cursor: pointer;
            font-size: 1.5rem;
            font-weight: bold;
        }
        button:hover {
            background:rgb(0, 56, 177);
        }
        .result {
            margin-top: 20px;
            font-size: 25px;
        }
        h2{
            font-size: 2.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Please input your data</h2>
    <form method="post">
        <input type="number" name="number" placeholder="Enter number" required>
        <button type="submit">Submit</button>
    </form>

    <div class="result" id="result">
        <?php
        if (isset($result)) {
            echo "<p>" . nl2br(htmlspecialchars($result)) . "</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
