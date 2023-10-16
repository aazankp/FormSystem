$(document).ready(function(){
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    closeBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("open");
        menuBtnChange();
    });
    function menuBtnChange() {
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        }else {
            closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
        }
    }

    function Dashboard(){
        $.ajax({
            url: "vendor/Process.php?action=Dashboard", 
            type: "POST",
            success: function(result){
                $("#Body_Content").html(result);

                const map = L.map('map').setView([25.3792, 68.3682], 10);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                }).addTo(map);

                let marker1;
                let marker2;

                map.on('click', function(get) {
                    var latLng = get.latlng;
                    console.log(latLng);
                    if (!marker1) {
                        $('#marker1').text(formatCoords(latLng));
                        marker1 = createMarker(latLng);
                    } else if (!marker2) {
                        $('#marker2').text(formatCoords(latLng));
                        marker2 = createMarker(latLng);
                        calculateDistance();
                    } else {
                        alert('You can only place two markers.');
                    }

                    function createMarker(latLng) {
                        return L.marker(latLng).addTo(map);
                    }

                    function formatCoords(coords) {
                        return 'Latitude: ' + coords.lat.toFixed(6) +', Longitude: ' + coords.lng.toFixed(6);
                    }        

                    function calculateDistance() {
                        if (marker1 && marker2) {
                            const distance = marker1.getLatLng().distanceTo(marker2.getLatLng());
                            const distanceInKm = (distance / 1000).toFixed(2);
                            $('#distance').text(distanceInKm + ' /km');
                        }
                    }
                });
            }
        });
    }
    
    Dashboard();
    
    $(document).on("click", "#dashboard", function(){
        Dashboard();
    });
    
    $(document).on("click", "#InsertPersonData", function(){
        $.ajax({
            url: "vendor/Process.php?action=InsertPersonData", 
            type: "POST",
            success: function(result){
                $("#Body_Content").html(result);
            }
        });
    });

    $(document).on("change", "#Country", function(){
        var country_id = $(this).find("option:selected").data("country_id");
        $.ajax({
            url: "vendor/Process.php?action=state", 
            type: "POST",
            data: {country_id : country_id},
            success: function(result){
                $("#State").html(result);
            }
        });
    });

    $(document).on("change", "#State", function(){
        var state = $(this).val();
        var country_id = $(this).find("option:selected").data("country");
        $.ajax({
            url: "vendor/Process.php?action=city", 
            type: "POST",
            data: {
                country_id : country_id,
                state : state
            },
            success: function(result){
                $("#City").html(result);
            }
        });
    });

    function InputValidation(){
        var fields = [
            { id: "ProfileImg"},
            { id: "FirstName"},
            { id: "LastName"},
            { id: "Country"},
            { id: "State"},
            { id: "City"}
        ];

        for (var i = 0; i < fields.length; i++) {
            var fieldValue = $("#" + fields[i].id).val();
            var errorElement = $("#" + fields[i].id);            
            if (fieldValue == "") {
                errorElement.css("border-color", "red");;
            }else {
                errorElement.css("border-color", "green");;
            }
        }
    }

    $(document).on("submit", "#AddPersonData", function(event) {
        event.preventDefault();
        var formdata = new FormData(this)
        InputValidation();
        $.ajax({
         url: "vendor/Process.php?action=Submit_AddPersonData", 
         type: "POST",
         data: formdata,
         cache: false,
         processData: false,
         contentType: false,
         success: function(result){
            console.log(result);
            if (result == 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your Data has been Submitted',
                    showConfirmButton: false,
                    timer: 2000
                })
                $("#AddPersonData").trigger("reset");
                $(".PersonFormInput").css("border-color", "#DEE2E6");
            }
            if (result == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Fill Input Fields!',
                  })
            }
            if (result == "ExtError") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Profile Picture Format Should jpg or png!',
                  })
            }
         }});
     });

     function ViewPersonData(){
        $.ajax({
            url: "vendor/Process.php?action=ViewPersonData", 
            type: "POST",
            success: function(result){
                $("#Body_Content").html(result);
                var table = $('#ViewData').DataTable( {
                    lengthChange: false,
                    buttons: [ 'copy', 'excel', 'pdf', 'print', 'colvis' ]
                } );
                table.buttons().container().appendTo( '#ViewData_wrapper .col-md-6:eq(0)' );
            }
        });
    }

    $(document).on("click", "#ViewPersonData", function(){
        ViewPersonData();
    });

    $(document).on("submit", "#EditPersonData", function(event) {
        event.preventDefault();
        var formdata = new FormData(this)
        InputValidation();
        $.ajax({
         url: "vendor/Process.php?action=Submit_EditPersonData", 
         type: "POST",
         data: formdata,
         cache: false,
         processData: false,
         contentType: false,
         success: function(result){
            console.log(result);
            if (result == 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your Data has been Submitted',
                    showConfirmButton: false,
                    timer: 2000
                })
                ViewPersonData();
            }
            if (result == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please Fill Input Fields!',
                  })
            }
            if (result == "ExtError") {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Profile Picture Format Should jpg or png!',
                  })
            }
        }});
    });

    $(document).on("keypress", ".PersonFormInput", function(){
        var fieldValue = $(this).val();
        var errorElement = $("#" + $(this).attr('id'));            
        if (fieldValue !== "") {
            errorElement.css("border-color", "#DEE2E6");
        }
    });

    $(document).on("change", ".PersonFormInput", function(){
        var fieldValue = $(this).val();
        var errorElement = $("#" + $(this).attr('id'));            
        if (fieldValue !== "") {
            errorElement.css("border-color", "#DEE2E6");
        }
    });

    $(document).on("click", "#UpdatePersonData", function(){
        var PersonId = $(this).val();
        $.ajax({
            url: "vendor/Process.php?action=UpdatePersonData", 
            type: "POST",
            data: {PersonId : PersonId},
            success: function(result){
                $("#Body_Content").html(result);
            }
        });
    });

    $(document).on('click', '#DeletePersonData', function () {
        var PersonId = $(this).val(); 
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
                    url: "vendor/Process.php?action=DeletePersonData", 
                    type: "POST",
                    data: {PersonId:PersonId},
                    success: function(result){
                        console.log(result);
                        ViewPersonData();
                }});
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your data has been deleted.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        })        
    });

});