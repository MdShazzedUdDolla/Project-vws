<?php 
/**
 * this file will contain funtions responisble for sanitizing data passed from users before their intraction with database
 * 
 */
 class sanitization
 {
    public function sanitize_data($data, $type) {
        switch ($type) {
          case 'string':
            return htmlspecialchars($data);
          case 'int':
            return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
          case 'float': // new case for float
            return filter_var($data, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_THOUSAND);
          case 'email':
            return filter_var($data, FILTER_SANITIZE_EMAIL);
          case 'url':
            return filter_var($data, FILTER_SANITIZE_URL);
          case 'phone':
            return filter_var($data , FILTER_SANITIZE_NUMBER_INT );
          default:
            return $data;
        }
      }




function sanitize($input) {
  // remove whitespaces from beginning and end of input
  $input = trim($input);
  
  // remove backslashes
  $input = stripslashes($input);
  
  // replace single quotes with escaped single quotes
  $input = str_replace("'", "\\'", $input);
  
  // replace double quotes with escaped double quotes
  $input = str_replace('"', '\"', $input);
  
  // convert special characters to HTML entities
  $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  
  return $input;
}
 
 }
?>