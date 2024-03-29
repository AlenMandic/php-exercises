<?php
include_once 'receipt_class.php';

$receipt = new Receipt();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <h2 class="title">PREDRAČUN BR. 2022-16950-63 ZA USLUGU SMJEŠTAJA</h2>

    <table class="item-table table1">
        <tr>
            <th>Usluga</th>
            <th>Cijena</th>
            <th>Količina</th>
            <th>Ukupno</th>
        </tr>
        <?php echo $receipt->generateTable1HTML(); ?>
    </table>

    <p class="included smaller-text">Uključeno u cijenu (bez dodatne naplate): turistička pristojba</p>

    <h2 class="payments-title">DINAMIKA PLAĆANJA</h2>

    <table class="payment-table">
        <tr>
            <th>Uplata</th>
            <th>Naćin plaćanja</th>
            <th>Vrijeme plaćanja</th>
            <th>Iznos</th>
        </tr>
        <?php echo $receipt->generateTable2HTML(); ?>
    </table>

    <p class="smaller-text">Uplatom akontacije gost potvrđuje da je upoznat te se slaže s Općim uvjetima pružanja usluga smještaja u privatnim objektima.</p>

  </div>
 </body>
</html>