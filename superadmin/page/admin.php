<style>
   .collection-item.avatar {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .collection-item.avatar:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        background-color: #fafafa;
        cursor: pointer;
    }
    .collection-item.avatar .secondary-content i:hover {
        transform: scale(1.2);
        transition: transform 0.2s ease;
    }

    /* Tooltip */
    .tooltip-icon {
        display: inline-block;
        margin-left: 8px;
        position: relative;
        font-family: 'Material Symbols Outlined';
        font-size: 20px;
        color: #9ca3af;
        cursor: pointer;
        vertical-align: middle;
    }

    .tooltip-icon::after {
        content: attr(data-tooltip);
        position: absolute;
        width: 240px;
        background: #1f2937;
        color: #fff;
        padding: 10px;
        border-radius: 8px;
        font-size: 0.875rem;
        top: 120%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease-in-out;
        z-index: 10;
    }

    .tooltip-icon:hover::after {
        opacity: 1;
    }


</style>
<!--=========================== Modal Add ==============================-->
    <!-- Modal Structure -->
    <div id="modAddAdmin" class="modal">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <h4><b>Data User</b></h4>
                    <div class="input-field col s12">
                        <input placeholder="Nama Lengkap" id="namaForm" value="" type="text" class="validate">
                        <label for="namaForm">Nama Lengkap</label>
                    </div>
                    <div class="input-field col s12" >
                        <input placeholder="e-Mail" id="usernameForm" value="" type="text" class="validate">
                        <label for="usernameForm">e-Mail</label>
                    </div>
                    
                    <div class="input-field col s12" id="passwordDiv">
                        <input placeholder="Password" id="passwordForm" value="" type="text" class="validate">
                        <label for="passwordForm">Password</label>
                    </div>
                    <div class="input-field col s12">
                        <select id="jenisForm" onchange="setRoleView()">
                            <option value="SUPERADMIN" class="superadminOnly" selected>Super Admin</option>
                            <option value="ADMIN" class="superadminOnly">Admin</option>
                            <!-- <option value="ADMIN" class="superadminOnly">Admin</option> -->
                        </select>
                        <label>Pilih Admin</label>
                    </div>
                    <div class="input-field col s12" id="roleView">
                        <input placeholder="Nama Instansi" id="roleForm" value="" type="text" class="validate autocomplete">
                        <label for="roleForm">Instansi</label>
                    </div>
                    <input type="hidden" id="idAdminForm" value="">
                    <div id="preloaderView" class="col s12" style="display: none;">
                        <div class="progress">
                            <div class="indeterminate"></div>
                        </div>
                    </div>
                </div>
                <div onclick="addNewData()" id="tambahBtn" class="btn">Tambah</div>
                <div onclick="editData()" id="editBtn" class="btn">Simpan</div>
            </form>
        </div>
    </div>
<!-- ========================================================================= -->

<div class="col s12" style="margin-bottom:20px;">
    <div class="col s12" id="breadCrumpView"></div>
</div>
<div class="col s12">
    <div class="col s12">
        <input class="col s12" type="text" placeholder="Cari Nama atau Username" id="searchUser" oninput="searchUser()">
    
    </div>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s6"><a class="active" href="#superadminTab">Superadmin</a></li>
                <li class="tab col s6"><a href="#adminTab">Admin</a></li>
            </ul>
        </div>
        <div id="superadminTab" class="col s12">
            <div class="col s12" id="listDataSuperadmin">
        
            </div>
        </div>
        <div id="adminTab" class="col s12">
            <div class="col s12" id="listDataAdmin">
        
            </div>
        </div>
    </div> 
    
    
</div>

<a class="btn-floating blue" onclick="clearForm()" style="position:fixed; right:10px; bottom:10px;"><i class=" material-icons">add</i></a>
<script>
    var myResponAllData=[];
    var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Management User",
            "url":"<?php echo $URL; ?>/admin/adminDashboard"
        }
    ];

    $(document).ready( function () {
        showItem();
        showRole();
        createBreadCrum(breadCrump);
    } );

    function setRoleView() {
        $("#roleView").css('display', $("#jenisForm").val() === "ADMIN" ? "block" : "none");
    }

    function showItem(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showAdmin',
            method: 'POST',
            data: {
                "token":token,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponAllData=JSON.parse(response);

                
                if(myResponAllData.response_status=="true"){
                    $("#listDataSuperadmin").html("");
                    $("#listDataAdmin").html("");
                    var adminList=`<ul class="collection row" style="border:none">`;
                    var superadminList=`<ul class="collection row" style="border:none">`;

                    for(a=0; a<myResponAllData.data.length;a++){
                        
                        if(myResponAllData.data[a].jenis=="SUPERADMIN")
                            // superadminList+=`
                            //     <li class="collection-item avatar s12 m6">
                            //         <img src="<?php echo $URL; ?>/${myResponAllData.data[a].avatar}" alt="" class="circle">
                            //         <span class="title">${myResponAllData.data[a].nama} [${myResponAllData.data[a].jenis}]</span>
                            //         <p>${myResponAllData.data[a].username}</p>
                            //         <a href="#" class="secondary-content">
                            //             <i class="material-icons blue-text tooltipped" onclick="resetPass(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Reset Password">restart_alt</i>
                            //             <i class="material-icons purple-text tooltipped" onclick="showEditAdmin(${a})" data-position="bottom" data-tooltip="Edit Data">edit</i>
                            //             <i class="material-icons red-text tooltipped" onclick="deleteData(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Delete">delete</i>
                            //         </a>
                            //     </li>
                            // `;
                            superadminList+=`
                                
                                 <li class="collection-item avatar hoverable" style="display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="<?php echo $URL; ?>/${myResponAllData.data[a].avatar}" alt="" class="circle" style="margin-right: 16px;">
                                        <div>
                                            <span class="title" style="font-weight: 600;">${myResponAllData.data[a].nama} <span class="grey-text text-darken-1">[${myResponAllData.data[a].jenis}]</span></span>
                                            <p class="grey-text">${myResponAllData.data[a].username}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="material-icons blue-text text-darken-2 tooltipped" style="margin: 0 5px; cursor:pointer;" onclick="resetPass(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Reset Password">restart_alt</i>
                                        <i class="material-icons purple-text text-darken-2 tooltipped" style="margin: 0 5px; cursor:pointer;" onclick="showEditAdmin(${a})" data-position="bottom" data-tooltip="Edit Data">edit</i>
                                        <i class="material-icons red-text text-darken-2 tooltipped" style="margin: 0 5px; cursor:pointer;" onclick="deleteData(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Delete">delete</i>
                                    </div>
                                </li>
                            `;
                        else if(myResponAllData.data[a].jenis=="ADMIN")
                            adminList+=`
                                <li class="collection-item avatar hoverable" style="display: flex; align-items: center; justify-content: space-between;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="<?php echo $URL; ?>/${myResponAllData.data[a].avatar}" alt="" class="circle" style="margin-right: 16px;">
                                        <div>
                                            <span class="title" style="font-weight: 600;">${myResponAllData.data[a].nama} <span class="grey-text text-darken-1">[${myResponAllData.data[a].jenis}]</span></span>
                                            <p class="grey-text">${myResponAllData.data[a].username}</p>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="material-icons blue-text text-darken-2 tooltipped" style="margin: 0 5px; cursor:pointer;" onclick="resetPass(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Reset Password">restart_alt</i>
                                        <i class="material-icons purple-text text-darken-2 tooltipped" style="margin: 0 5px; cursor:pointer;" onclick="showEditAdmin(${a})" data-position="bottom" data-tooltip="Edit Data">edit</i>
                                        <i class="material-icons red-text text-darken-2 tooltipped" style="margin: 0 5px; cursor:pointer;" onclick="deleteData(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Delete">delete</i>
                                    </div>
                                </li>
                            `;
                        
                        
                        
                    }
                    adminList+=`<ul>`;
                    superadminList+=`<ul>`;
                    $("#listDataSuperadmin").html(superadminList);
                    $("#listDataAdmin").html(adminList);
                    $('.tooltipped').tooltip();
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
    }


    function showRole(){
        var token = localStorage.getItem('token');
        $.ajax({
            url: '<?php echo $URL; ?>/API/showRole',
            method: 'POST',
            data: {
                "token":token,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponAllData=JSON.parse(response);

                if(myResponAllData.response_status=="true"){
                    var autoData = {};
                    myResponAllData.data.forEach(function(item) {
                        var key = Object.keys(item)[0];  // ambil key pertama, misal "aaa"
                        autoData[key] = null; // assign null seperti format Materialize
                    });

                    $('input.autocomplete').autocomplete({
                        data: autoData
                    });
                }
                else{
                    alert(myResponAllData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
        
    }
  
    function deleteData(x){
        var token = localStorage.getItem('token');
        var idAdmin = x;

        // alert("masuk");
        if(confirm("Are you really want to delete this data ?")){
            $.ajax({
                url: '<?php echo $URL; ?>/API/deleteAdmin',
                method: 'POST',
                data: {
                    "token":token,
                    "idAdmin":idAdmin,
                },
                
                success: function (data) {
                    var response= JSON.stringify(data);
                    var myResponse=JSON.parse(response);
                    showAlert(myResponse.message);
                    showItem();               
                }
            });
        }
    }

    function resetPass(x){
        var token = localStorage.getItem('token');
        var idAdmin = x;
        Swal.fire({
            title: "Are you really want to reset this data ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Reset it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?php echo $URL; ?>/API/resetPassAdmin',
                    method: 'POST',
                    data: {
                        "token":token,
                        "idAdmin":idAdmin,
                    },
                    
                    success: function (data) {
                        var response= JSON.stringify(data);
                        var myResponse=JSON.parse(response);
                        Swal.fire({
                            title: "Reset!",
                            html: "Your password has been reset to <b><i>"+myResponse.new_pass+"</i></b>",
                            icon: "success"
                        });
                        // showAlert(myResponse.message);
                        // alert("Password Baru : "+myResponse.new_pass);
                        showItem();               
                    }
                });
               
            }
        });

        // alert("masuk");
        // if(confirm("Are you really want to reset this data ?")){
        //     $.ajax({
        //         url: '<?php echo $URL; ?>/API/resetPassAdmin',
        //         method: 'POST',
        //         data: {
        //             "token":token,
        //             "idAdmin":idAdmin,
        //         },
                
        //         success: function (data) {
        //             var response= JSON.stringify(data);
        //             var myResponse=JSON.parse(response);
        //             showAlert(myResponse.message);
        //             alert("Password Baru : "+myResponse.new_pass);
        //             showItem();               
        //         }
        //     });
        // }
    }

    function clearForm(){
        $("#namaForm").val("");
        $("#usernameForm").val("");
        $("#passwordForm").val("");
        $("#roleForm").val("");
        $("#modAddAdmin").modal("open");
        $('select').formSelect();
        $("#tambahBtn").css("display","block");
        $("#editBtn").css("display","none");
        $("#passwordDiv").css("display","block");
        setRoleView();
    }

    function showEditAdmin(a){
        $("#namaForm").val(myResponAllData.data[a].nama);
        $("#usernameForm").val(myResponAllData.data[a].username);
        $("#idAdminForm").val(myResponAllData.data[a].id);
        $("#passwordForm").val("");
        $("#jenisForm").val(myResponAllData.data[a].jenis);
        $("#roleForm").val(myResponAllData.data[a].role);
        $("#modAddAdmin").modal("open");
        $('select').formSelect();
        $("#tambahBtn").css("display","none");
        $("#editBtn").css("display","block");
        $("#passwordDiv").css("display","none");
        setRoleView();
        // if(myResponAllData.data[a].jenis!="SUPERADMIN"){
        //     $("#tambahBtn").css("display","none");
        //     $("#editBtn").css("display","none");

        // }
    }

    function addNewData(){
        var token = localStorage.getItem('token');

        var nama= $("#namaForm").val();
        var username=$("#usernameForm").val();
        var password=$("#passwordForm").val();
        var jenis=$("#jenisForm").val();
        var role=$("#roleForm").val();
        $("#preloaderView").css("display","block");

        $.ajax({
            url: '<?php echo $URL; ?>/API/addNewAdmin',
            method: 'POST',
            data: {
                "token":token,
                "nama":nama,
                "username":username,
                "jenis":jenis,
                "role":role,
                "password":password,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);
                $("#preloaderView").css("display","none");
                $("#modAddAdmin").modal("close");
                showAlert(myResponse.message);
                
                showItem();               
            },
            error: function(jqXHR, textStatus, errorThrown) {

                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information, and tell the developer about the error!');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);

            },
        });
    }

    function editData(){
        var token = localStorage.getItem('token');

        var nama= $("#namaForm").val();
        var username=$("#usernameForm").val();
        var role=$("#roleForm").val();
        var idAdmin=$("#idAdminForm").val();
        // var password=$("#passwordForm").val();
        var jenis=$("#jenisForm").val();
        $("#preloaderView").css("display","block");

        $.ajax({
            url: '<?php echo $URL; ?>/API/editAdmin',
            method: 'POST',
            data: {
                "token":token,
                "nama":nama,
                "username":username,
                "jenis":jenis,
                "role":role,
                "idAdmin":idAdmin,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);
                $("#preloaderView").css("display","none");
                $("#modAddAdmin").modal("close");
                showAlert(myResponse.message);
                
                showItem();               
            },
            error: function(jqXHR, textStatus, errorThrown) {

                alert('An error occurred... Look at the console (F12 or Ctrl+Shift+I, Console tab) for more information, and tell the developer about the error!');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);

            },
        });
    }

    function searchUser(){
        var searchItem= $("#searchUser").val().toLowerCase();
        $("#listDataSuperadmin").html("");
        $("#listDataAdmin").html("");
        if(searchItem=="")
            showItem();
        else{
            $("#listDataSuperadmin").html("");
            $("#listDataPekerja").html("");
            $("#listDataPerusahaan").html("");
            var adminList=`<ul class="collection row">`;
            var superadminList=`<ul class="collection row">`;

                    
            for(a=0; a<myResponAllData.data.length;a++){
                var nama=myResponAllData.data[a].nama.toLowerCase();
                var username=myResponAllData.data[a].username.toLowerCase();
                if(nama.match(searchItem)||username.match(searchItem)){
                   
                    if(myResponAllData.data[a].jenis=="SUPERADMIN")
                        superadminList+=`
                            <li class="collection-item avatar s12 m6">
                                <img src="<?php echo $URL; ?>/${myResponAllData.data[a].avatar}" alt="" class="circle">
                                <span class="title">${myResponAllData.data[a].nama} [${myResponAllData.data[a].jenis}]</span>
                                <p>${myResponAllData.data[a].username}</p>
                                <a href="#" class="secondary-content">
                                    <i class="material-icons blue-text tooltipped" onclick="resetPass(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Reset Password">restart_alt</i>
                                    <i class="material-icons purple-text tooltipped" onclick="showEditAdmin(${a})" data-position="bottom" data-tooltip="Edit Data">edit</i>
                                    <i class="material-icons red-text tooltipped" onclick="deleteData(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Delete">delete</i>
                                </a>
                            </li>
                        `;
                    else if(myResponAllData.data[a].jenis=="ADMIN")
                        adminList+=`
                            <li class="collection-item avatar s12 m6">
                                <img src="<?php echo $URL; ?>/${myResponAllData.data[a].avatar}" alt="" class="circle">
                                <span class="title">${myResponAllData.data[a].nama} [${myResponAllData.data[a].jenis}]</span>
                                <p>${myResponAllData.data[a].username}</p>
                                <a href="#" class="secondary-content">
                                    <i class="material-icons blue-text tooltipped" onclick="resetPass(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Reset Password">restart_alt</i>
                                    <i class="material-icons purple-text tooltipped" onclick="showEditAdmin(${a})" data-position="bottom" data-tooltip="Edit Data">edit</i>
                                    <i class="material-icons red-text tooltipped" onclick="deleteData(${myResponAllData.data[a].id})" data-position="bottom" data-tooltip="Delete">delete</i>
                                </a>
                            </li>
                        `;
                    
                }
                
            }
            adminList+=`<ul>`;
            superadminList+=`<ul>`;
            $("#listDataSuperadmin").html(superadminList);
            $("#listDataAdmin").html(adminList);
            $('.tooltipped').tooltip();
        }
    }

   
</script>