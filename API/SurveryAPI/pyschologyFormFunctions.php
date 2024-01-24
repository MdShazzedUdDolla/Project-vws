<?php 
 require_once "../../API/Database/config.php";
    function getQuestions(){
        $sql = "SELECT * FROM perceived_stress_questions";
        $conn = startConnection();
        $resultQuestions = runSelect($conn, $sql);
     
        $rows[]  = [];
        if($resultQuestions!=null){
           while( $row= $resultQuestions -> fetch_row() ){
              $rows[] = $row;
           }
     
           return $rows;
        }
     }
     
     function getScale($id){
        $sql = "SELECT * FROM perceived_stress_scale";
        $conn = startConnection();
        $resultQuestions = runSelect($conn, $sql);
     
        $html = '<select class="form-select" name="Scale'.$id.'" id="Scale'.$id.'" required>';
        $html .= '<option value="" selected="selected" disabled>Please select a value</option>';
        if($resultQuestions!=null){
           while( $row= $resultQuestions -> fetch_assoc() ){
              $html .=  '<option value='.$row['Scale'].'>'.$row['Scale']."-".$row['Description'].'</option>';
           }
     
           $html .= '</select>';
           return $html;
        }
     }
     
?>