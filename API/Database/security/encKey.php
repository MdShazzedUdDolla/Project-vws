<?php 
/* gets the secret key from either envirement file or a secure location on file system of deployment server */
function getKey(){

    return "d40f5fc656de8fe04d9f3574deb38093c39df4b0b40e46daad4adc466d722eda";
}
/*
gets the secret key from either envirement file or a secure location on file system of deployment server
*/
function getAdminPass(){
 
    return ",i?W8=Z@7Q4ixvpJ1KK,=c>o+]NZY:=y~-)9EpG1MpMUK?JM_n?]Wt.]51-NX%?C^A8HrYTY*]dg8LN5Tt5qBJyTz_5~>.18>>q0";
}
/*
Sets the pepper to be used for hashing process to avoid dictionary attack 
 */
function getPepper(){
    return "jqmeyxrerfmtceznebpwbuvcnnazylrfrlwr";
}
?>