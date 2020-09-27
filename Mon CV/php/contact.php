<?php

  $array = array("firstname" => "",
                "name" => "",
                "email" => "",
                "phone" => "",
                "message" => "",
                "firstnameError" => "",
                "nameError" => "",
                "emailError" => "",
                "phoneError" => "",
                "messageError" => "",
                "isSuccess" => false
                );

  $emailTo = "alense2002@yahoo.fr";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";

    if (empty($array["firstname"])) {
      $array["firstnameError"] = "Je veux connaître ton prénom! ";
      $array["isSuccess"] = false;
    }
    else
      $emailText .= "Firstname: {$array["firstname"]}\n";     //  .= pour concatener et \n pour revenir à la ligne, {} pour mopntrer que ce sont des variables.

    if (empty($array["name"])) {
       $array["nameError"] = "Et toi, Je veux tout savoir. Même ton nom! ";
       $array["isSuccess"] = false;
     }
     else
       $emailText .= "Name: {$array["name"]}\n";

    if (!isEmail($array["email"])){
       $array["emailError"] = "T'essaies de me rouler? Ce n'est pas un email ça!";
       $array["isSuccess"] = false;
     }
    else
      $emailText .= "Email: {$array["email"]}\n";

    if (!isPhone($array["phone"])) {
      $array["phoneError"] = "Que des chiffres et des lettres, stp!";
      $array["isSuccess"] = false;
    }
    else
      $emailText .= "Phone: {$array["phone"]}\n";

    if (empty($array["message"])) {
      $array["messageError"] = "Qu'est-ce que tu veux me dire? ";
      $array["isSuccess"] = false;
    }
    else
      $emailText .= "Message: {$array["message"]}\n";

    if ($array["isSuccess"]) {
      $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
      mail($emailTo, "Un message de votre site", $emailText, $headers);
    }

    echo json_encode($array);   //Renvoie le resultat travail de php au json

  }

  function isPhone(){
    return preg_match("/^[0-9 ]", $var);
  }

  function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);  //Comparer les emails
  }

  // La fonction verifyInput() permet de protéger notre site contre les hackers.
  function verifyInput($var){
    $var = trim($var);        // trim() supprime les espaces, les tab, les champs, ... dans le formulaires
    $var = stripslashes($var);  // supprime les antislashes.
    $var = htmlspecialchars($var);  //

    return $var;
  }

?>
