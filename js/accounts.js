loadData();


let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#accounMoal").modal("show");
})

//insert Account
$("#accountForm").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#accountForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","AccountRegister");
    }else{
        form_data.append("action","updateAccounts");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/accounts.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#accountForm")[0].reset();

            $("#accounMoal").modal("hide");
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
        url: "api/accounts.php",
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
                        if(r == "bank_name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "account_num"){tr += `<td>${res[r]}</td>`;}
                        if(r == "country"){tr += `<td>${res[r]}</td>`;}
                        if(r == "status"){
                            if(res[r]=="Active"){
                                tr += `<td><span class='badge bg-primary'>${res[r]}</span></td>`;
                            }else{
                                tr += `<td><span class='badge bg-danger'>${res[r]}</span></td>`;
                            }
                            
                        }
                        if(r == "balance"){tr += `<td>${res[r]}</td>`;}
                        
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['id']}><i class="fas fa-edit"style="color: #fff"></i></a>
                    </td>`
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
        "action":"readAccountInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/accounts.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].id);
                $("#name").val(response[0].bank_name);
                $("#accnum").val(response[0].account_num);
                $("#country").val(response[0].country);
                $("#status").val(response[0].status);
               
                $("#amount").val(response[0].balance);
                $("#accounMoal").modal("show");

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