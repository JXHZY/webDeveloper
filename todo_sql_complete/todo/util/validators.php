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

?>