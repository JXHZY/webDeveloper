<?php

function validate_registration_form($form) {
    $errors = [];
    
    $firstName = $form["firstName"];
    $lastName = $form["lastName"];
    $userName = $form["userName"];
    $password = $form["password"];        
    
    if(strlen(trim($firstName))>0)
    {
        $firstNameValid = true; //Validate
    }
    else
    {
        $firstNameValid = false;
    }
    if(!$firstNameValid) {
        $errors["firstName"] = "First name is required";
    }
    
    if(strlen(trim($lastName))>0)
    {
        $lastNameValid = true; //Validate
    }
    else
    {
        $lastNameValid = false;
    }
    if(!$lastNameValid) {
        $errors["lastName"] = "Last name is required";
    }
    
    //check user name
    $userNameValid = filter_var($form["userName"], FILTER_VALIDATE_EMAIL);
    if(!$userNameValid) {
        $errors["userName"] = "User name is required and should be a valid email address";
    }

    //check password
    if(strlen(trim($password))>=4)
    {
        $passwordValid = true; //Validate
    }
    else
    {
        $passwordValid = false;
    }
    if(!$passwordValid) {
        $errors["password"] = "Password is required and should have at least 4 characters";
    }
        
    return $errors;
}

?>
