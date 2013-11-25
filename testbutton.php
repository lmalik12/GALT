<?php
 
 $success = True;
 $db_conn = OCILogon("ora_k9e8", "a33807116", "ug");

$X_button = resource newt_button(5, 12, "X"); 

 OCILogoff($db_conn);
 $success = False;

?>

//  $form = newt_form();
// $X_button = resource newt_button(5, 12, "X");  
//  newt_form_add_component($form, $X_button);
    