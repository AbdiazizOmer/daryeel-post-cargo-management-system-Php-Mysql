loadData();
$("#btnadd").click(function(){
    $("#areaModal").modal("show");
})
let btnAction= "Insert";

//insert Account
$("#areaForm").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#areaForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","areaRegister");
    }else{
        form_data.append("action","updateArea");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/area.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#areaForm")[0].reset();

            $("#areaModal").modal("hide");
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


function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/area.php",
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
//read Customer to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readAreaInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/area.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].id);
                $("#name").val(response[0].areaname);
                $("#country").val(response[0].country);
                $("#areaModal").modal("show");

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
