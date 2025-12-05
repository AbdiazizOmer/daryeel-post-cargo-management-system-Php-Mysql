loadData();


let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#jobinsertmodal").modal("show");
})

//insert job
$("#jobinsertform").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#jobinsertform")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","jobRegister");
    }else{
        form_data.append("action","updateJob");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/jobs.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#jobinsertform")[0].reset();

            $("#jobinsertmodal").modal("hide");
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

//read all jobs to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/jobs.php",
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
                        if(r == "job_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "fee"){tr += `<td>$ ${res[r]}</td>`;}
                        if(r == "description"){tr += `<td>${res[r]}</td>`;}
                        if(r == "Date_created"){tr += `<td>${res[r]}</td>`;}
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['job_id']}><i class="fas fa-edit"style="color: #fff"></i></a></td>`
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

//read jobs to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readJobInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/jobs.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].job_id);
                $("#name").val(response[0].name);
                $("#sal").val(response[0].fee);
                $("#dis").val(response[0].description);
                $("#jobinsertmodal").modal("show");

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