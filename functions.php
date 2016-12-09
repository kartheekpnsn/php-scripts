<?php
# # cipher for encryption and decryption
define("ENCRYPTION_KEY", "!@#$%^&*12345678");

# # function for encryption
# pure_string = plain text
function encrypt($pure_string)
{
    $iv_size          = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv               = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, ENCRYPTION_KEY, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
    return $encrypted_string;
}
# # function for decryption
# encrypted_string = cipher text
# encryption_key = key used for encryption
function decrypt($encrypted_string, $encryption_key)
{
    $iv_size          = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
    $iv               = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
    return $decrypted_string;
}
# # function to check login of a user -- needs to be modified
# sql = query used for checking (usually a select query)
# uname = username of the user (to start the session if success)
# page = the page to be redirected if successful
function CheckLogin($sql, $uname, $page)
{
    include "sql-connection.php";
    if (!mysqli_query($con, $sql)) {
        $str = 0;
        header("location: index.php?error_login=" . $str);
    } else {
        session_start();
        $_SESSION['userID'] = $uname;
        header("location:" . $page);
    }
}
# # function to count number of rows
# sql = query for checking (usually a select query)
# page = the page to be redirected if successful
function getNRows($sql, $page)
{
    $result   = selectQuery($sql, $page);
    $rowcount = mysqli_num_rows($result);
    return ($rowcount);
}
# # function to close mysql session
# con = connection object created when mysql connection was created
function closeSession($con)
{
    mysqli_close($con);
}
# # function to executing insert/delete/update queries
# sql = query for checking (insert/delete/update queries)
# page = the page to be redirected if successful
function insertUpdateDelete($sql, $page)
{
    include "sql-connection.php";
    # $sql="INSERT INTO users(email_id,pwd) values('$email_id','$password')";
    if (!mysqli_query($con, $sql)) {
        $str = 0;
        if ($page != "") {
            header("location: " . $page . "?error=" . $str);
        }
    } else {
        $str = 1;
        if ($page != "") {
            header("location: " . $page . "?success=" . $str);
        }
    }
}
# # function to executing select query
# sql = query for checking (select query)
# page = the page to be redirected if successful
function selectQuery($sql, $page)
{
    include "sql-connection.php";
    # $sql="SELECT * FROM users where email_id='$email_id'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        die("Could not get the data");
    }
    # # Next steps
    # use $result
    # while($row = mysqli_fetch_assoc($result)){ echo $row['colname1']; echo $row['colname2']; .. }
    return ($result);
}
# # function to process and move the files to a location
# file = file object from form posting $_FILES['name']
# page = the page to be redirected if successful
function uploadFile($file, $page)
{
    $name = $file['name'];
    $path = "../uploads/" . basename($name);
    if (move_uploaded_file($file['tmp_name'], $path)) {
        return $path;
    } else {
        header("Location:" . $page . "?usuccess=0");
    }
}
?>
