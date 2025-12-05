loadData();
setTimeout(function(){
    document.querySelectorAll(".sidebar-item").forEach(function(item){
        item.addEventListener("click",function(){
            // console.log("clicked...............");
            item.querySelector(".submenu").classList.toggle("active");
            // var element = document.getElementsByClassName('active');
            addStyle(item, 'submenu', {
            color: 'red',
            fontSize: '20px'
            });
        })
        
    })
},1000)

function loadData(){
    let sendingData ={
        "action":"getUserMenue"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/userAuthority.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let menueElement ='';
            let category ='';
            let subcategory ='';

            if(status){

                response.forEach(menu => {
                    if(menu['category_name']!==category){
                        if(category!==''){
                            menueElement +='</li></ul>';

                        }
                        menueElement +=`
                        <li
                            class="sidebar-item  has-sub">
                            <a  class='sidebar-link slink'>
                                <i class="${menu['category_icon']}"></i>
                                <span>${menu['category_name']}</span>
                            </a>
                            <ul class="submenu ">
                                
                                
                        `;
                        category=menu['category_name'];
                    }
                    menueElement+=`
                    <li class="submenu-item">
                        <a href="${menu['link']}">${menu['link_name']}</a>
                    </li> 
                    `;

                });
                $("#userMenue").append(menueElement);
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}



{/* <li class="submenu-item ">
                                    <a href="user.php">User list</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="userAuthority.php">User Privileges</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="main_menues.php">Main Menues</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="sub_menues.php">Sub Menues</a>
                                </li> */}