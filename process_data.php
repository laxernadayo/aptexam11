
<?php 
require_once('config/database.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contactno = $_POST['contactno'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $noty = [];
    if (empty($name) || !preg_match("/^[a-zA-Z .,-]+$/",$name)) {
        $noty = ['status' => 'fail', 'msg' => 'Invalid Full Name'];
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $noty = ['status' => 'fail', 'msg' => 'Invalid Email'];
    }
    if (!preg_match("/^[0-9]{11}$/",$contactno)) {
        $noty = ['status' => 'fail', 'msg' => 'Invalid Contact Number'];
    }

    if (!empty($noty)) {
        echo json_encode(array('noty' => $noty));
        exit;
    }

    $sql = "INSERT INTO Profile(`Name`, `Email`, `ContactNumber`, `Birthdate`, `Age`, `Gender`) VALUES(:name,:email,:contactno,:birthdate,:age,:gender)";
    $statement = $pdo->prepare($sql);
    $data = [
        ':name' => $name,
        ':email' => $email,
        ':contactno' => $contactno,
        ':birthdate' => $birthdate,
        ':age' => $age,
        ':gender' => $gender
    ];
    $query = $statement->execute($data);
    if ($query) {
        $noty = ['status' => 'success', 'msg' => 'Added record successfully'];
    }
    else {
        $noty = ['status' => 'success', 'msg' => 'Added record failed'];
    }
    echo json_encode(array('noty' => $noty));
}
?>