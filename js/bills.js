loadData();
fill_employe();


let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#billModal").modal("show");
})

function fill_employe() {

  let sendingData = {
    "action": "read_all_employeeee"
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/bills.php",
    data: sendingData,

    success: function (data) {
      let status = data.status;
      let response = data.data;
      let html = '';
      let tr = '';

      if (status) {
        response.forEach(res => {
        
          html += `<option value="${res['emp_id']}">${res['employe_name']}</option>`;


        })

        $("#emp").append(html);


      } else {
        console.log(response);
      }

    },
    error: function (data) {

    }

  })
}

$("#billForm").on("change", "select.emp", function () {
    let employee = $(this).val();
    fill_salary(employee);
})


function fill_salary(employee) {
let sendingData = {
    "action": "read_employe_salary",
    "employee": employee

}

$.ajax({
    method: "POST",
    dataType: "JSON",
    url: "Api/bills.php",
    data: sendingData,

    success: function (data) {
    let status = data.status;
    let response = data.data;
    console.log("name", response)
    let html = '';
    let tr = '';

    if (status) {

        response.forEach(res => {
        $("#sal").val(res['salary']);

        })



    } else {
        displaymessage("error", response);
    }

    },
    error: function (data) {

    }

})
}

//insert Account
$("#billForm").submit(function(event){
    event.preventDefault();

    let conrl=$(".contrl").val();
    if(conrl==0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#billForm")[0].reset();
            }
        });
        return;
    }
    

    //gets the form data
    let form_data =new FormData($("#billForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","register_bills");
    }else{
        form_data.append("action","");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/bills.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#billForm")[0].reset();

                $("#billModal").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                    location.reload(true);
                    }
                });
            
            
            
            btnAction ="Insert";
        },
        error : function(data){
            console.log(data);
        }
    })


})

//read all office to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/bills.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){

                response.forEach(res => {
                    tr += "<tr>";
                    for (let r in res){
                        if(r == "id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "employe_name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "salary"){tr += `<td>$${res[r]}</td>`;}
                        if(r == "userName"){tr += `<td>${res[r]}</td>`;}
                        if(r == "date"){tr += `<td >${res[r]}</td>`;}
                    }
                   tr+= "</tr>"
                });
                $("#table1 tbody").append(tr);
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}
