<?php
include_once 'dbconnect.php';
$addr =  filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$satosh = filter_input(INPUT_POST, 'satoshi', FILTER_SANITIZE_NUMBER_INT);
$url = "https://api.etherscan.io/api?module=account&action=balance&address=0x" . $addr . "&tag=latest&apikey=YOURKEY";
$fgc = json_decode(file_get_contents($url), true);
$bal = $fgc["result"];
$etherconnection = new PDO("mysql:host=$DBhost; dbname=$DBname", $DBuser, $DBpass);
$check = $etherconnection->prepare("SELECT *  FROM `ewallet_eth` WHERE `address` = ? LIMIT 1"); //CHECK IF THE TRANSACTION IS ALREADY DONE
$check->execute(array($addr));
if ($check->rowCount() > 0) {
    if ($bal >= $satosh) {
        $html = array('msg' => 'true');
        echo '<div class="alert alert-success">
  <strong>Good news!</strong> Your payment has been completed.
</div>';

    } else {
        echo '

<img  src="https://chart.googleapis.com/chart?chs=165x165&cht=qr&chl=' . $addr . '">
<h5 style="color:black;text-align:center;">Please send <font color="cornflowerblue">' . $satosh . ' </font>ETH to <font color="cornflowerblue"><br><br><input style="text-align:center;" type="text" value="0x' . $addr . '" class="form-control add"></font></h5>
<font  color="cornflowerblue"><b>
Waiting for the payment...</b></font>
	';
    }
} else {
    $add = $etherconnection->prepare("INSERT INTO ewallet_eth(address,amount) VALUES(:id, :amount)");
    $add->bindParam(':id', $addr);
    $add->bindParam(':amount', $satosh);
    $add->execute();
}
?>