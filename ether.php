<?php
include_once 'dbconnect.php';
$address =  filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_INT);
$url = "https://api.etherscan.io/api?module=account&action=balance&address=0x" . $address . "&tag=latest&apikey=YOURKEY";
$api = json_decode(file_get_contents($url), true);
$balance = $api["result"];
$connection = new PDO("mysql:host=$DBhost; dbname=$DBname", $DBuser, $DBpass);
$check = $connection->prepare("SELECT *  FROM `ewallet_eth` WHERE `address` = ? LIMIT 1"); //CHECK IF THE TRANSACTION IS ALREADY DONE
$check->execute(array($address));
if ($check->rowCount() > 0) {
    if ($balance >= $amount) {
        $html = array('msg' => 'true');
        echo '<div class="alert alert-success">
  <strong>Good news!</strong> Your payment has been completed.
</div>';

    } else {
        echo '

<img  src="https://chart.googleapis.com/chart?chs=165x165&cht=qr&chl=' . $address . '">
<h5 style="color:black;text-align:center;">Please send <font color="cornflowerblue">' . $amount . ' </font>ETH to <font color="cornflowerblue"><br><br><input style="text-align:center;" type="text" value="0x' . $address . '" class="form-control add"></font></h5>
<font  color="cornflowerblue"><b>
Waiting for the payment...</b></font>
	';
    }
} else {
    $add = $connection->prepare("INSERT INTO ewallet_eth(address,amount) VALUES(:id, :amount)");
    $add->bindParam(':id', $address);
    $add->bindParam(':amount', $amount);
    $add->execute();
}
?>
