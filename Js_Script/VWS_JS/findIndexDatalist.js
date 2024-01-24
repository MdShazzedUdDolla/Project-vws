$(document).ready(function() {
    var data = {};
    $("#patients option").each(function(i, el) {
        data[$(el).data("value")] = $(el).val();
    });
   


    $('#check').click(function() {
      if($('#nameDrop')!==null) {
        var value = $('#nameDrop').val();
        //console.log(value);
        $('#user_auto_key').val($('#patients [value="' + value + '"]').data('value'));
       
      }
       
    });

    $('#deleteButton').click(function() {
      if($('#nameDropDelete')!==null) {
        var value = $('#nameDropDelete').val();
       // console.log(value);
        $('#user_auto_key').val($('#patients [value="' + value + '"]').data('value'));
       
      }
       
    });


    $('#updateButton').click(function() {

     // alert('Update pressed');
      if($('#nameDropUpdate')!==null) {
        var value = $('#nameDropUpdate').val();
       // console.log(value);
        $('#user_auto_key').val($('#patients [value="' + value + '"]').data('value'));
       
      }
       
    });
   
  });