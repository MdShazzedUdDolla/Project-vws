<?php 
    include_once "../../API/Database/config.php";
    function checkForPrevRecord($user_auto){
      
        $sql = "SELECT 1 FROM `functional_capacity_gpuser_date` where USR_AUTO_KEY = ?";
        $conn = startConnection();
        $result = SafeRunSelect($conn, $sql, [$user_auto]);
        if($result!=null){
            while($row = $result->fetch_assoc()) {
                if($row['1']==1){
                    closeConnection($conn);
                    return true;
                  

                }else{
                    closeConnection($conn);
                    return false;
                   
                }
            }
        }
        return false;
    }

?>