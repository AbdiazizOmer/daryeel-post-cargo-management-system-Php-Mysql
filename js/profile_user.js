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

$("#profilebtn").click(function(){
    $("#profileModal").modal("show");
    fetchInfo();
})

function fetchInfo(){
    let id=$("#update_id").val();
    let sendingData ={
        "action":"readUserProfileInfo",
        "update_id" : id
    }
    console.log(id);
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
                $("#username").val(response[0].username);
                
                $("#show").attr('src',`img/${response[0].image}`);

               
            }else{
                console.log("error", response);
            }

            

        },
        error : function(data){

        }
    })
}
//insert user
$("#UserProfileForm").submit(function(event){
    event.preventDefault();
    //gets the form data
    let form_data =new FormData($("#UserProfileForm")[0]);
    form_data.append("image", $("input[type=file]")[0].files[0]);
    //ads action to the form

        form_data.append("action","updateUserProfile");
    
  
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
            $("#UserProfileForm")[0].reset();
  
            $("#profileModal").modal("hide");
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