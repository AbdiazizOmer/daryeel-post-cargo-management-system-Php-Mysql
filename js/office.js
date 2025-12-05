loadData();


let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#officeinsertmodal").modal("show");
})

//insert office
$("#officesertform").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#officesertform")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","officeRegister");
    }else{
        form_data.append("action","updateOffice");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/office.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#officesertform")[0].reset();

            $("#officeinsertmodal").modal("hide");
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
        url: "api/office.php",
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
                        tr += `<td>${res[r]}</td>`;
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['office_id']}><i class="fas fa-edit"style="color: #fff"></i></a>
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

//read office to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readOfficeInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/office.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].office_id);
                $("#address").val(response[0].address);
                $("#city").val(response[0].city);
                $("#country").val(response[0].country);
                $("#phone").val(response[0].phone);
                $("#officeinsertmodal").modal("show");

                btnAction ="Update";
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}


//Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfo(id);
})