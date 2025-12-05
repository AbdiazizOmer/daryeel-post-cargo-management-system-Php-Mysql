loadData();
fillaccoun();

let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#chargeModal").modal("show");
})


function fillaccoun() {

    let sendingData = {
        "action": "read_all_account"
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/charges.php",
        data: sendingData,

        success: function (data) {
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if (status) {
                response.forEach(res => {
                    html += `<option value="${res['id']}">${res['bank_name']}</option>`;

                })

                $("#account_id").append(html);


            } else {
                console.log(response);
            }

        },
        error: function (data) {

        }

    })
}

//insert Account
$("#chargeForm").submit(function(event){
    event.preventDefault();

    let conrl=$(".contrl").val();
    if(conrl==0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#chargeForm")[0].reset();
            }
        });
        return;
    }
    

    //gets the form data
    let form_data =new FormData($("#chargeForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","register_charge");
    }else{
        form_data.append("action","");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/charges.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let responses = data.dataa;
            if(response){
                $("#chargeForm")[0].reset();

                $("#chargeModal").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
            }else{
                $("#chargeForm")[0].reset();

                $("#chargeModal").modal("hide");
                setTimeout(5000);
                iziToast.error({timeout: 1000,title: 'Error..',message: responses,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
            }
            
            
            
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
        url: "api/charges.php",
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
                        if(r == "charge_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "fullName"){tr += `<td>${res[r]}</td>`;}
                        if(r == "name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "Amount"){tr += `<td>$${res[r]}</td>`;}
                        if(r == "month_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "year"){tr += `<td>${res[r]}</td>`;}
                        if(r == "description"){tr += `<td>${res[r]}</td>`;}
                        if(r == "bank_name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "userName"){tr += `<td>${res[r]}</td>`;}
                        if(r == "active"){
                            if(res[r]==0){tr += `<td><span class='badge  bg-danger text-right' style="float: right;">Pending</span></td>`;}
                            if(res[r]==1){tr += `<td><span class='badge  bg-success text-right' style="float: right;">Billed</span></td>`;}
                        }
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

//read Account to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readMethodtInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/methods.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].id);
                $("#name").val(response[0].name);
                $("#methodModal").modal("show");

                btnAction ="Update";
                
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}



// Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfo(id);
})