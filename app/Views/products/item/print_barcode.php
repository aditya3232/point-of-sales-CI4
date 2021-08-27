<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Product <?= $item['barcode']; ?></title>
</head>

<body style="width:300px">
    <?php
        // This will output the barcode as HTML output to display in the browser
        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
        echo $generator->getBarcode($item['barcode'], $generator::TYPE_CODE_128);
    ?>
    <br>
    <?= $item['barcode']; ?>
</body>

</html>