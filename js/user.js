loadData();
redEmployee();
// redOffice();

let btnAction= "Insert";

$("#btnadd").click(function(){
    $("#userModal").modal("show");
})
//Image Show
let fileImage = document.querySelector("#image");
let showImage = document.querySelector("#show");
const redear = new FileReader();
fileImage.addEventListener("change",(e)=>{
    const selectedFile = e.target.files[0];
    redear.readAsDataURL(selectedFile)
})
redear.onload =e =>{
    showImage.src = e.target.result;
}

//Red employee option
function redEmployee(){
 
    let sendingData ={
        "action": "readEmployeeOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/user.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['emp_id']}">${res['fullName']}</option>`;
                   
                })
  
                $("#emp_id").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

//insert user
$("#userForm").submit(function(event){
  event.preventDefault();
  //gets the form data
  let form_data =new FormData($("#userForm")[0]);
  form_data.append("image", $("input[type=file]")[0].files[0]);
  //ads action to the form
  if(btnAction == "Insert"){
      form_data.append("action","UserRegister");
  }else{
      form_data.append("action","updateUser");
  }
  

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/user.php",
      data : form_data,
      processData : false,
      contentType : false,

      success :function(data){
          let status = data.status;
          let response = data.data;
          $("#userForm")[0].reset();

          $("#userModal").modal("hide");
          setTimeout(5000);

          iziToast.success({
            timeout: 1000,
            title: 'Saving..',
            message: response,
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

//read all users to table
function loadData(){
    $("#table1 tr").html('');
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/user.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';
            let th ='';

            if(status){

                response.forEach(res => {
                    th = "<tr>";
                    for(let i in res){
                        if(i == "IMAGE#"){th += `<th>${i}</th>`;}
                        if(i == "USRID#"){th += `<th>${i}</th>`;}
                        if(i == "NAME"){th += `<th>${i}</th>`;}
                        if(i == "JOB TYPE"){th += `<th>${i}</th>`;}
                        if(i == "USERNAME"){th += `<th>${i}</th>`;}
                        if(i == "STATUS"){th += `<th>${i}</th>`;}
                        if(i == "DATE"){th += `<th>${i}</th>`;}
                    }

                    th+= "<th>Action</th></tr>";

                    tr += "<tr>";
                    tr += "<tr>";
                    for (let r in res){
                        
                        if(r == "USRID#"){tr += `<td>${res[r]}</td>`;}
                        if(r == "IMAGE#"){
                            tr += `<td><div class="avatar me-3"><img  src="img/${res[r]}"></div></td>`;
                        }
                        if(r == "NAME"){tr += `<td>${res[r]}</td>`;}
                        if(r == "JOB TYPE"){tr += `<td>${res[r]}</td>`;}
                        if(r == "USERNAME"){tr += `<td>${res[r]}</td>`;}
                        if(r == "STATUS"){
                            if(res[r]=="Active"){
                                tr += `<td><span class='badge bg-primary'>${res[r]}</span></td>`;
                            }else{
                                tr += `<td><span class='badge bg-danger'>${res[r]}</span></td>`;
                            }
                            
                        }
                        if(r == "DATE"){tr += `<td>${res[r]}</td>`;}
                        
                        
                        
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['USRID#']}><i class="fas fa-edit"style="color: #fff"></i></a>
                    &nbsp;&nbsp 
                    <a class="btn btn-danger delete_info  btn-sm" delete_id=${res['USRID#']}><i class="fas fa-trash"style="color: #fff"></i></a> </td>`
                   tr+= "</tr>"
                });
                $("#table1 thead").append(th);
                $("#table1 tbody").append(tr);
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

//read user to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readUserInfo",
        "id" : id
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/user.php",
        data : sendingData,
        success :function(data){
            let status = data.status;
            let response = data.data;
            html ='';
            if(status){
                btnAction ="Update";
                
                $("#update_id").val(response[0].uid);
                html+= `<option selected value="${response[0].emid}">${response[0].name}</option>`;
                $("#username").val(response[0].username);
                
                $("#status").val(response[0].status);
                $("#show").attr('src',`img/${response[0].image}`);
                $("#userModal").modal("show");
                $("#emp_id").append(html);

               
            }else{
                displaymessagee("error", response);
            }

            

        },
        error : function(data){

        }
    })
}

//Delete user 
function deleteInfo(id){
    let sendingData ={
        "action":"daleteUser",
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
                url: "api/user.php",
                data : sendingData,
        
                success :function(data){
                    let status = data.status;
                    let response = data.data;
        
                    if(status){
                        iziToast.success({timeout: 1000,title: 'Deleted..',message: 'Your file has been deleted',
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
// Clicke delete button and then get id clicked
$("#table1").on("click","a.delete_info",function(){
    let id =$(this).attr("delete_id");
    deleteInfo(id);
})