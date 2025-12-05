loadData();


let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#CouriorModal").modal("show");
})

//insert ShipType
$("#CouriorForm").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#CouriorForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","CouriorRegister");
    }else{
        form_data.append("action","updateCourior");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/courior.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#CouriorForm")[0].reset();

            $("#CouriorModal").modal("hide");
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

//read all ShipType to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/courior.php",
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
                    &nbsp;&nbsp 
                    <a class="btn btn-danger delete_info  btn-sm" delete_id=${res['id']}><i class="fas fa-trash"style="color: #fff"></i></a> </td>`
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

//read courior to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readCouriorInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/courior.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].id);
                $("#name").val(response[0].name);
                $("#type").val(response[0].couriorType);
                $("#phone").val(response[0].phone);
                $("#CouriorModal").modal("show");

                btnAction ="Update";
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

//read ShipType to modal to update
function deleteInfo(id){
    let sendingData ={
        "action":"daleteCourior",
        "id" : id
    };
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                dataType: "JSON",
                url: "api/courior.php",
                data : sendingData,
        
                success :function(data){
                    let status = data.status;
                    let response = data.data;
                    let html='';
                    let tr ='';
        
                    if(status){
                        iziToast.success({timeout: 1000,title: 'Deleted..',message: response,
                            onClosing: function () {
                                location.reload(true);
                            }
                        });
                       
                    }else{
                        console.log(response);
                    }
        
                    
        
                },
                error : function(data){
        
                }
            })
          
        }
      })

    
}

//Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfo(id);
})

// //Clicke delete button and then get id clicked
$("#table1").on("click","a.delete_info",function(){
    let id =$(this).attr("delete_id");
    deleteInfo(id);
})