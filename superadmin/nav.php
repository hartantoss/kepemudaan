<style>
	@media screen and (max-width: 2000px) {
		#navbarku{
			display:block;
			width:17%;
		}
		.minmen{
			display:none;
		}
		#backarow{
			display:none;
		}
	}
	@media screen and (max-width: 1880px) {
		#navbarku{
			display:block;
			width:20%;
		}
		.minmen{
			display:none;
		}
		#backarow{
			display:none;
		}
	}
	@media screen and (max-width: 800px) {
		#navbarku{
			display:none;
			width:250px;
			overflow:scroll;
			overflow-x:hidden;
		}
		.minmen{
			display:block;
		}
		#backarow{
			display:block;
		}
	}
	/* ===== Scrollbar CSS ===== */
	/* Firefox */
	* {
		scrollbar-width: thin;
		scrollbar-color: #e1dfe2 #ffffff;
	}

	/* Chrome, Edge, and Safari */
	*::-webkit-scrollbar {
		width: 10px;
	}

	*::-webkit-scrollbar-track {
		background: #ffffff;
	}

	*::-webkit-scrollbar-thumb {
		background-color: #e1dfe2;
		border-radius: 10px;
		border: 3px dashed #cbc8c8;
	}


	.men a div{
		padding:10px;
		/* background:white; */
		color:black;
	}
	.men a div:hover{
		background:#f2f2f2;
	}
	.men a div i{
		margin-right:15px;
	}
	nav{
		z-index: 2;
	}
	.sdMenu{
		color: #18181b;
		padding:7px !important;
		font-size:18px;
		display: flex !important;
		/* justify-content: center !important; */
        align-items: center !important;
	}
	
	
	.sdMenu i{
		color: #18181b;
		font-size:30px;
		padding:7px !important;
		background:white;
		border-radius:15px;
		margin-right:5px;
		width:fit-content !important;
	}
	.sdMenu:hover{
		background:white !important;
		border-radius:15px;
		/* box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
		box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
	}
	.sdMenu:hover i{
		background:#52b1e3 !important;
		color:white;
		/* #ededed; */
	}

	#navbarkuList:hover{
		overflow-y:scroll; 
	}
</style>

<!--====================================SIDENAV============================================-->
<ul id="slide-out" class="sidenav" style="height: 100%; width: 80%; overflow-y:scroll;overflow-x:scroll;font-family: 'Poppins', sans-serif;">    
</ul>
<!--======================================================================================-->


<div id="navbarku" class="col xxl3 xl2 l1 hide-on-med-and-down " style="font-family: 'Poppins', sans-serif;position:fixed; left:0px; top:0px; height:100%; padding:0px; margin:0px;">
	<div id="navbarkuList" class="men col s12" style="font-size:14px; height: 100%; padding:10px; ">
		
	</div>
</div>

<div class="col xl12 l12 m12 s12" style="font-family: 'Poppins', sans-serif; position:fixed; right:0px; top:0px;  width: 100%;">
	<div class="col 12" style=" position: absolute; top: 10px; right: 10px;">
		
		<div class="col s12 right" style="color:silver; text-align:left; display: flex; align-items: center; justify-content: space-between;">
			
			<div style="text-align:right;">
				<b style="margin: 0 auto;"><span id="prevNavView">Admin</span></b><br/>
				<span id='adminName' style="font-size:20px;"></span>
			</div>
			<img class="right" id="avatar" src="<?php echo $URL;?>/images/avatar/1.png" style="margin-left:10px; height:50px; border-radius:50%; padding:2px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
			
		</div>
	</div>
	
</div>
<a href="#" data-target="slide-out" class="sidenav-trigger hide-on-large-only left" style="position:fixed; top:10px; left:10px; padding:5px;">
	<i class="material-symbols-outlined">menu</i>
</a>

<script>
	var myResponNavData=[];
	if (
		localStorage.getItem("username") === null||
		localStorage.getItem("token") === null||
		localStorage.getItem("iduser") === null||
		localStorage.getItem("avatar") === null||
		localStorage.getItem("nama") === null) {
		
		alert("Please login first");
		window.location="<?php echo $URL; ?>";
	}
	
	else{
		$("#adminName").html(localStorage.getItem("nama").slice(0,12));
		$("#prevNavView").html(localStorage.getItem("privilege"));
		$("#avatar").attr("src","<?php echo $URL?>/"+localStorage.getItem("avatar"));
		showNavItem();
	}
	function setNavbarAccessibility(){
		$(".sdMenu").css("display","none");
	
		if(localStorage.getItem("privilege") === "SUPERADMIN")
			$(".superAdminMenu").css("display","block");
		if(localStorage.getItem("privilege") === "ADMIN")
			$(".adminMenu").css("display","block");
		if(localStorage.getItem("privilege") === "PERUSAHAAN")
			$(".perusahaanMenu").css("display","block");
	
	}
	
	function logout(){
		localStorage.removeItem("token");
		localStorage.removeItem("iduser");
		localStorage.removeItem("nama");
		localStorage.removeItem("username");
		localStorage.removeItem("privilege");
		window.location="<?php echo $URL; ?>/login";       
	}
	// console.log(localStorage.getItem("iduser"));


	
    function showNavItem(){
        var token = localStorage.getItem('token');

        $.ajax({
            url: '<?php echo $URL; ?>/API/showNavigator',
            method: 'POST',
            data: {
                "token":token,
            },
            
            success: function (data) {
                var response= JSON.stringify(data);
                myResponNavData=JSON.parse(response);
                
				// console.log(myResponNavData);
                if(myResponNavData.response_status=="true"){
                    $("#slide-out").html("");
                    $("#navbarkuList").html("");
                    var sideNavList='<li style="padding:5% 5% 5% 5%; margin-bottom:30px;" ><a href="#"><img class="center" src="<?php echo $URL;?>/images/logo.png" style="height:100px; margin-bottom:10px;" alt=""></a></li>';
                    var navbarkuList='<a style="padding:15% 15% 0px 15%;" href="#"><img class="center" src="<?php echo $URL;?>/images/logo.png" style="width:200px; margin-bottom:10px" alt=""></a>';
					var myRoles=myResponNavData.additional.allowed_role.split(';');
                    for(a=0; a<myResponNavData.data.length;a++){ 
						sideNavList+=`
							
							<li  class="col s12" style="margin:0px; padding: 0px;">
								<a class="col s12 ${myResponNavData.data[a].class}" 
								href="<?php echo $URL;?>${myResponNavData.data[a].url}" 
								>
									<i style="padding:0px 8px !important;" class="material-symbols-outlined right">${myResponNavData.data[a].icon}</i>
									<span>${myResponNavData.data[a].nama}</span>
								</a>
							</li>
						`;
						navbarkuList+=`
							<a class="col s12 ${myResponNavData.data[a].class}" href="<?php echo $URL;?>${myResponNavData.data[a].url}">
								<i class="material-symbols-outlined">${myResponNavData.data[a].icon}</i>
								<span>${myResponNavData.data[a].nama}</span>
							</a>
						`;						
                    }
                    sideNavList+=`<li><a class="col s12 sdMenu" href="#" onclick="logout()"><i style="padding:0px 8px !important;" class="material-symbols-outlined left">cancel</i>keluar</a></li>`;
					navbarkuList+=`<a class="col s12 sdMenu superAdminMenu pekerjaMenu perusahaanMenu" href="#" onclick="logout()"><i class="material-symbols-outlined left">cancel</i>keluar</a>`;
                    $("#slide-out").html(sideNavList);
                    $("#navbarkuList").html(navbarkuList);
					setNavbarAccessibility();
                }
                else{
                    
                    alert(myResponNavData.message);
                }
                // console.log(JSON.stringify(myResponse.token));
                // alert(data);
            }
        });
    }

</script>