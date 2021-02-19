<!--
Complete Task 2

Author: Satinder Singh
What I uderstand from task 2 requiremnts, I build that here just database queryies not front end code.
 -->
<?php

// Connection Code 
// XXXXXXXX will be renamed according to server 
try {
	$dbh = new PDO("mysql:host=localhost;dbname=XXXXXXXX", "XXXXXXXX", "XXXXXXXXXX");
    
} catch (Exception $e) {
    die("ERROR: Couldn't connect. {$e->getMessage()}");
}

//First Task is login and logout

//Login Task
$username = filter_input(INPUT_GET, "username");                            //Get username from front-end page
$password = filter_input(INPUT_GET, "password");                            //Get password from front-end page

//command to select record from database table
$cmd = "SELECT id,username,password,walletPrice FROM databaseTableName WHERE username = '$username' and password = '$password'";
$statement = $dbh->prepare($cmd);
$result = $statement->execute();
//Empty array
$userlist = [];
while ($row = $statement->fetch()) {
    $user = [
        "id" => $row["id"],
        "username" => $row["username"],
        "password" => $row["password"],
        "walletPrice" => $row["walletPrice"]
    ];
    array_push($userlist, $user);     //Push to array
}

// Write the json encoded array to the HTTP Response
echo json_encode($userlist);
//JavaScript file will loop through the array and the enter values from the username and password field if it match then login suceesfull
//if not showing error then

//Logout
//Logout button which simple direct the user to the main page and commit referesh automatically

//Second Task -> Add Balance to Wallet
//Here I will use update query + select query to get the current wallet price

//Update Query

//Get new price
$addPrice = filter_input(INPUT_GET, "walletPrice");

//Update the price by adding selecting old price with new enter price
//LIke (Select walletPrice) + (Enter adding price)

$cmd = "update walletPrice set walletPrice = '$addPrice' where id = '$id'";
$statement = $dbh->prepare($cmd);
$result = $statement->execute(); 

//Task 3 -> Buy shares

//Make a seperate table and I call it BuyingListOfShares
//Whenever user want to buy new one it it add that share table with Share naem,Share Current value + userID + share quantity + totalCost to the table

// Here javaScript will perform in order to get sharevalue and sharename

//Insertion Code
$cmd = "insert into BuyingListOfShares values ('$userID','$shareName','$shareQTY','$shareCurrentValue','$totalCost')";
$statement = $dbh->prepare($cmd);
$result = $statement->execute(); 

//Task 3 -> Sell shares

// $shareCurrentValue value automatically update every 2 second because of market
// When user click on sell butoon on specific share then it goes into the BuyingListOfShares table searching for specific userid and share name
// Then sell the share by multiply shareQTY with shareCurrentValue and then deleted that row.


//Task 5 -> Porfolio (All shares that user buy with current value and Total cash to trade)

//For first inner step
//Select buy share with current value with specific user id in BuyingListOfShares table

$cmd2 = "SELECT shareName,shareCurrentValue FROM BuyingListOfShares WHERE username = '$userID'";
$statement2 = $dbh->prepare($cmd2);
$result2 = $statement2->execute();
$data = [];
while ($row = $statement2->fetch()) {
    $user = [
        "shareName" => $row["shareName"],
        "shareCurrentValue" => $row["shareCurrentValue"]
    ];
    array_push($data, $user);     //Push to array
}

// Write the json encoded array to the HTTP Response
echo json_encode($data);

//fetch that array with javaScript code 

//Next section will be total cash to trade to display
$cmd3 = "SELECT walletPrice FROM databaseTableName WHERE username = '$userID'";
$statement3 = $dbh->prepare($cmd3);
$result = $statement3->execute();
$list = [];
while ($row = $statement3->fetch()) {
    $user = [
        "walletPrice" => $row["walletPrice"]
    ];
    array_push($list, $user);     //Push to array
}

echo json_encode($list);


?>