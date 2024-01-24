function fetchData(){
    alert('hello');

        //var frm = $('#graphFilter');
        frm.submit(function (ev) {
            ev.preventDefault();
            $.ajax({
                type: frm.attr('method'),
                url: frm.attr('action'),
                data: frm.serialize(),
                success: function (data) {
                    var divresult = document.getElementById('resultData');
                    divresult.innerHTML = data;
                    divresult.style.display = "block";
                    sessionStorage.setItem("result", data);
                    var myCanvasElement = document.getElementById('graph');
                    //myCanvasElement.width+=0;
                }
            });
         
        });
   

}