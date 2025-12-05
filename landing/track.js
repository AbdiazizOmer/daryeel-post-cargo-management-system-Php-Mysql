$("#track").hide();

function ClearFields() {
    document.getElementById("search").value = "";
    location.reload();
    
    // $("#track")[0].reset();
    // $("#track").hide();
}


//click search
$("#trackbtn").click(function(){
    let searchtext =document.querySelector("#search").value;
    let sendingData ={
        "action":"fetchinfo",
        "search" : searchtext
    };
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "../api/track.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;

            if(status){
                if(response == 0){
                    iziToast.error({timeout: 1000,title: 'Error..',message: 'Unknown Tracking Number',
                    onClosing: function () {
                    location.reload(true);
                    }
                });
                }else{
                    $('#search').val('');
                    $('#search').attr('readonly', 'true');
                    $('#search').css('background-color' , '#E6E6F0');
                    $("#trackbtn").hide();
                    $("#track").show();
                    $("#trckid").append(response[0].TrackingID);
                    $("#cname").append(response[0].cname);
                    $("#rname").append(response[0].re_name);
                    $("#ctell").append(response[0].tell);
                    $("#payment").append(response[0].status_price);
                    if(response[0].status == "1"){$("#status").append("<span class='badge badge-pill bg-info'>Pending</span>");}
                    else if(response[0].status == "2"){$("#status").append("<span class='badge badge-pill bg-primary'>Order Confirmed</span>");}
                    else if(response[0].status == "3"){$("#status").append("<span class='badge badge-pill bg-secondary'>Prepare Order</span>");}
                    else if(response[0].status == "4"){$("#status").append("<span class='badge badge-pill bg-primary'>On the way</span>");}
                    else if(response[0].status == "5"){$("#status").append("<span class='badge badge-pill bg-secondary'>Arrived At Destination</span>");}
                    else if(response[0].status == "6"){$("#status").append("<span class='badge badge-pill bg-success'>Delivered</span>");}
                    else if(response[0].status == "7"){$("#status").append("<span class='badge badge-pill bg-danger'>Canceled</span>");}
                    if(response[0].status == "1"){
                
                        document.getElementById("step1").className += "active";
                    }
                    else if(response[0].status == "2"){
                        document.getElementById("step1").className += "active";
                        document.getElementById("step2").className += "active";
                    }
                    else if(response[0].status == "3"){
                        document.getElementById("step1").className += "active";
                        document.getElementById("step2").className += "active";
                        document.getElementById("step3").className += "active";
                    }
                    else if(response[0].status == "4"){
                        document.getElementById("step1").className += "active";
                        document.getElementById("step2").className += "active";
                        document.getElementById("step3").className += "active";
                        document.getElementById("step4").className += "active";
                    }
                    else if(response[0].status == "5"){
                        document.getElementById("step1").className += "active";
                        document.getElementById("step2").className += "active";
                        document.getElementById("step3").className += "active";
                        document.getElementById("step4").className += "active";
                        document.getElementById("step5").className += "active";
                    }
                    else if(response[0].status == "6"){
                        document.getElementById("step1").className += "active";
                        document.getElementById("step2").className += "active";
                        document.getElementById("step3").className += "active";
                        document.getElementById("step4").className += "active";
                        document.getElementById("step5").className += "active";
                        document.getElementById("step6").className += "active";
                    }
                    else{
                    }
                    
                    $("#track").show();
                    
                }
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })







    // console.log(searchtext);
    // 
})
