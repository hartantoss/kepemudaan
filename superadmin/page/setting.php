<div class="row">
    <div class="col s12" style="margin-bottom:20px;">
        <div class="col s12" id="breadCrumpView"></div>
    </div>

    <div class="col s12">
        <form action="" method="POST">
            <div class="row">
                <div class="col s12 m6 l8">
                    <div class="input-field col s12">
                        <input placeholder="Nama Lengkap" id="namaForm" type="text" class="validate txt-clr">
                        <label for="namaForm">Nama Lengkap</label>
                    </div>
                    
                    <div class="input-field col s12">
                        <input placeholder="e-Mail" id="emailForm" type="text" class="validate txt-clr">
                        <label for="emailForm">e-Mail</label>
                    </div>
                    
                    
                    <div class="input-field col s12">
                        <input oninput="isPasswordGood()" placeholder="Password" id="passwordForm" type="password" class="validate txt-clr">
                        <label for="passwordForm">Password</label>
                    </div>  
                    <div class="col s12" id="noteView">
                        <p><b>Password harus memenuhi ketentuan berikut : </b></p>
                        <p id="angkaCheck" class="red-text">Mengandung angka</p>
                        <p id="spcialCheck" class="red-text">Mengandung spesial karakter</p>
                        <p id="more8Check" class="red-text">Lebih dari 8 karakter</p>
                    </div>
                </div> 
                <div class="col s12 m6 l4" style="text-align: center;">
                    <div class="row">
                        <div class="col s12">
                            <img class="materialboxed" style="margin:auto; height:200px;" id="avatarForm" src="<?php echo $URL;?>/images/avatar/1.png">
                        </div>
                        <!-- <div class="col s12">
                            <div class="btn-floating blue" onclick="chzAva(-1)"><</div>
                            <div class="btn-floating blue" onclick="chzAva(1)">></div>
                        </div>   -->
                        <div class="file-field input-field col s12">
                            <div class="btn btn-clr col s12" style="border-radius : 25px;">
                                <span>Edit Foto (400x400) </span>
                                <input id="newAvatarForm" type="file" multiple>
                            </div>
                            <div class="file-path-wrapper col s12">
                                <input class="file-path validate"  style="text-align: center; border-bottom:none;" type="text" placeholder="Upload square photo">
                            </div>
                        </div>
                    </div>
                </div>                     
            </div>
            <div id="tambahBtn" onclick="save()" class="col s12 btn btn-clr">simpan</div>
        </form>
    </div>
    
</div>
 

  <script>
     var breadCrump=[
        {
            "text":"Dasboard",
            "url":"<?php echo $URL; ?>/admin/homepage"
        },
        {
            "text":"Setting",
            "url":"<?php echo $URL; ?>/admin/setting"
        }
    ];

    var ccImg = 1;
    

    $(document).ready( function () {
        showItem();
        createBreadCrum(breadCrump);
        $("#noteView").css("display","none");
    } );


    function showItem(){
        var token = localStorage.getItem('token');
        var idAdmin = localStorage.getItem("iduser");
        var avatar=localStorage.getItem("avatar");
        var privilege=localStorage.getItem("privilege");
        $("#adminName").html(localStorage.getItem("nama").slice(0,12));
        $("#avatar").attr("src","<?php echo $URL?>/"+avatar);
        $("#avatarForm").attr("src","<?php echo $URL?>/"+avatar);
    

        $.ajax({
            url: '<?php echo $URL; ?>/API/showAdmin',
            method: 'POST',
            data: {
                "token":token,
                "idAdmin":idAdmin,
                "privilege":privilege,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);

                // console.log(idAdmin);
                if(myResponse.response_status=="true"){
                    $("#namaForm").val(myResponse.data[0].nama);
                    $("#emailForm").val(myResponse.data[0].username);
                    $("#passwordForm").val(myResponse.data[0].password);
                }
                else{
                    alert(myResponse.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
    }

    function save(){
        var token = localStorage.getItem('token');
        var idAdmin = localStorage.getItem("iduser");

        var nama= $("#namaForm").val();
        var username=$("#emailForm").val();
        var password=$("#passwordForm").val();
        const avaImg = $('#newAvatarForm').prop('files')[0];
            

        let formData = new FormData();
        formData.append('token', token);
        formData.append('idAdmin', idAdmin);
        formData.append('nama', nama);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('avatar', avaImg);

        // if(privilege=="USER"){
        //     var telp= $("#telpForm").val();
        //     var nik=$("#nikForm").val();
        //     formData.append('nik', nik);
        //     formData.append('telp', telp);
        // }

        
        $.ajax({
            url: '<?php echo $URL; ?>/API/editAdmin',
            method: 'POST',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            
            success: function (data) {
                var response= JSON.stringify(data);
                var myResponse=JSON.parse(response);
                localStorage.setItem("token", myResponse.newToken);
                localStorage.setItem("username", myResponse.data.username);
                localStorage.setItem("nama", myResponse.data.nama);
                localStorage.setItem("avatar", myResponse.data.avatar);

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

    function chzAva(imgVal){
        ccImg += parseInt(imgVal); 
        if (ccImg<1)
            ccImg=19;
        else if (ccImg>19)
            ccImg=1;
        console.log(ccImg);
        $("#avatarForm").attr("src","<?php echo $URL?>/images/avatar/"+ccImg+".png");
    }

    function containsLetter(str) {
        // RegExp untuk memeriksa apakah string mengandung setidaknya satu huruf
        const letterRegex = /[a-zA-Z]/;
        return letterRegex.test(str);
    }
    function containsNumber(str) {
        // RegExp untuk memeriksa apakah string mengandung setidaknya satu angka
        const numberRegex = /\d/;
        return numberRegex.test(str);
    }
    function containsSpecialCharacter(str) {
        // RegExp untuk memeriksa apakah string mengandung setidaknya satu karakter spesial
        const specialCharacterRegex = /[!@#$%^&*(),.?":{}|<>]/;
        return specialCharacterRegex.test(str);
    }

    function isPasswordGood(){
        var myPass=$("#passwordForm").val();
        var isContainNumber=false;
        var isContainSpecial=false;
        var isMoreThan8=false;
        $("#noteView").css("display","block");
        if(containsNumber(myPass)){
            $("#angkaCheck").removeClass("red-text");
            $("#angkaCheck").addClass("green-text");
            isContainNumber=true;
        }
        else{
            $("#angkaCheck").removeClass("green-text");
            $("#angkaCheck").addClass("red-text");
            isContainNumber=false;
        }
        if(containsSpecialCharacter(myPass)){
            $("#spcialCheck").removeClass("red-text");
            $("#spcialCheck").addClass("green-text");
            isContainSpecial=true;
        }
        else{
            $("#spcialCheck").removeClass("green-text");
            $("#spcialCheck").addClass("red-text");
            isContainSpecial=false;
        }
        if(myPass.length>8){
            $("#more8Check").removeClass("red-text");
            $("#more8Check").addClass("green-text");
            isMoreThan8=true;
        }
        else{
            $("#more8Check").removeClass("green-text");
            $("#more8Check").addClass("red-text");
            isMoreThan8=false;
        }


        if(isContainNumber&&isContainSpecial&&isMoreThan8){
            $("#tambahBtn").css("display","block")
        }
        else{
            $("#tambahBtn").css("display","none")
        }
    }
    
  </script>

        