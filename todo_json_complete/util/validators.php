<?php

//check how many words input into description, the length must smaller than 120
function validateRequired($description){
    $length = strlen($description);
    if (($length == 0) || ($length>120)){
        return false;
    }
    else 
    {
        return true;
    }
}

function validate($value, $noChars) {
    $valid = isset($value);
    if ($valid) {
        $valid = hasRequiredLength($value, $noChars);
    }
    return $valid;
}

function hasRequiredLength($value, $noChars) {
    $valid = false;
    $trimmedValue = trim($value);
    if (strlen($trimmedValue) >= $noChars) {
        $valid = true;
    }
    return $valid;
}

/**
 * Password Verify
 *      6 to 12 characters
 *      alpha numeric (at least 1 alpha and at least 1 numeric)
 *      special characters ($, _)
 * @param string $password
 */
/*function verify_password($password){
    $valid=true;
    $length=strlen($password);
    if ($length<6 || $length>12){
        $valid = false;
    }
    if (!preg_match('/[a-zA-Z]/',$password) || !preg_match('/[0-9]/',$password)){
        $valid = false;
    }
    if (preg_match('/'.preg_quote('^\'£$%^&*()}{@#~?><,@|-=-_+-¬', '/').'/', $password)){
        $valid = false;
    }
    return $valid;
}*/
?>