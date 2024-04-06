var divIndex = 0;
var $_name;
var tab = "";
var week_id =0; 
var imgDataArray = [];


const urlParams = new URLSearchParams(window.location.search);
const tabValue = urlParams.get('tab');
if(tabValue){
    tab = tabValue;
}
else{
    tab = "daily";
}

// var popup_overlay = document.getElementById("popup-overlay");
$(function() {
    loadDailyContent()
    
    function openPopup(tab) {
        if (tab == "daily") {
            // Open the pop-up for the Daily tab
            // $('#addnotesmodal').modal('show');
            $('.modal').show();
            console.log('daily');
            $('#btn-n-add').prop('disabled', false);
            
        } else if (tab == "weekly") {
            // Open the pop-up for the Weekly tab
            // ...code to open the weekly pop-up...
            console.log(tab);
            $('.Week').show();
            // popup_overlay.style.display = "flex";
            // $('#btn-n-save').hide();
            $('#btn-n-ad').prop('disabled', false);

            // $.ajax({
            //     url: "../Loading/get_userid.php",
            //     type: "GET",
            //     success: function(name) {
            //         $_name = name;
            //     }
            // })
        }
        $.ajax({
            url: "Loading/get_userid.php",
            type: "GET",
            success: function(name) {
                $_name = name;
            }
        })
    }

    //this will show the form and fetch the maxindex from table so we can give next index to the new stic
    $('#add-notes').on('click', function(event) {
        openPopup(tab)
    });

    $('.close').on('click', function(event) {
        $('.modal').hide();
        $('.Week').hide();
        $('#btn-n-add').prop('disabled', true);
        document.getElementById('note-has-title').value = '';
        document.getElementById('note-has-description').value = '';
        $('#addweeklyreport')[0].reset();
    });

    
    //for daily report add button
    $('#btn-n-add').on('click', function(event) {
        console.log(tab);
        savedata();
    });

    //for weekly report add button 
    $('#btn-n-ad').on('click', function(event) {
        console.log(tab);
        savedata();
    });
    setInterval(refreshContent, 500);
    $('#daily').on('click', function(e) {
        e.preventDefault();
        tab = "daily";
        console.log('dai;');
        loadDailyContent();
        // loadContent(tab);
        // openPopup(tab);
        // locadcard(tab);
    });
    $('#weekly').on('click', function(e) {
        e.preventDefault();
        console.log('week');
        tab = "weekly";
        loadWeeklyContent();
    });

    

    //FOR display daily report and do their filter function 
    function loadDailyContent() {
        // console.log('dai;');
        $.ajax({
            type: 'GET',
            url: 'Loading/daily_report.php',
            success: function(e) {
                $('#note-full-container').html(e);
                // applyFiltersAndVisibility('daily');
                var nameFilter = $('#name_search').val().toLowerCase();
                var dateFilter = $('#date_fil').val();

                $('.card-view').each(function() {
                    var nameMatch = $(this).find('.user_name').text().toLowerCase().includes(nameFilter);
                    var dateMatch = true;
                    if (dateFilter !== '') {
                        var noteDate = $(this).find('.note-date').text();
                        dateMatch = noteDate === dateFilter;
                    }
                    if (nameMatch && dateMatch) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            }
        });
    }

    //for weekly content redirect and its filtering report according to date or a week 

    //for refreshing the load content according tab on which we are rght now 
    function refreshContent() {
        if (tab === 'daily') {
            loadDailyContent();
        } else if (tab === 'weekly') {
            loadWeeklyContent();
        }
    }
    
});
function loadWeeklyContent() {
    $.ajax({
        type: 'GET',
        url: 'Loading/weekly_report.php',
        success: function(e) {
            $('#note-full-container').html(e);
            // applyFiltersAndVisibility('weekly');
        }
    });
}
function editWeekly(event,week , weekid) {
    // Retrieve the existing data for the weekly report using AJAX or any other method
    week_id = weekid;
    console.log(week_id);
    var weeklyData = week.closest('.weeklycontainer');
    // Update the form fields with the existing data
    document.getElementById('weekly-has-title').value = weeklyData.querySelector('.work_done').textContent;
    document.getElementById('future_work').value = weeklyData.querySelector('.next_week').textContent;
    
    // Update the individual work fields with the existing data
    let individualWorkData = weeklyData.getElementsByClassName('individual');
    
    Array.from(individualWorkData).forEach(element => {
        document.getElementById('individual' + element.id).value = element.textContent;
        console.log(element.textContent);
    })
    $('.Week').show();
    // savedata(week_id);
    $('#btn-n-ad').prop('disabled', false);
}

function savedata() {
    console.log(week_id);
    if (tab == 'daily') {
        var $_noteTitle = document.getElementById('note-has-title').value;
        var $_noteDescription = document.getElementById('note-has-description').value;
        // console.log($_noteTitle);
        var data = {
            title: $_noteTitle,
            description: $_noteDescription,
            // index: divIndex
        };
        $.ajax({
            url: 'Loading/save_data_daily.php', // Replace with the actual URL of your PHP script
            type: 'POST',
            data: data,

            success: function(response) {
                // Handle the response from the PHP script
                console.log('Data saved successfully0909090');
                // Optionally, you can perform additional actions after saving the data
            },
            error: function(error) {
                // Handle the error
                console.error('Error occurred while saving data:', error);
            }
        });
        document.getElementById('note-has-title').value = '';
        document.getElementById('note-has-description').value = '';
        // $('#note-full-container').prepend($html);
        // console.log($_noteTitle);
        // console.log($_noteDescription);
        $('.modal').hide();
        $('#btn-n-add').prop('disabled', true);
    }
    if (tab == 'weekly') {

        // console.log('veer');

        var $work = document.getElementById('weekly-has-title').value;
        var $future_work = document.getElementById('future_work').value;
        console.log($work);
        console.log($future_work);

        var individualWork = [];

        $('[id^="individual"]').each(function() {
            var memberId = $(this).attr('id').replace('individual', '');
            var work = $(this).val();
            individualWork.push({ memberId: memberId, work: work });
        });
        // console.log(individualWork);
        var data = {
            work: $work,
            individualWork: individualWork,
            future_work: $future_work,
            week_id:week_id,
        };
        
        $.ajax({
            url: 'Loading/save_data_weekly.php',
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
            }
        });
    
        $('.Week').hide();
        $('#btn-n-ad').prop('disabled', true);
        $('#addweeklyreport')[0].reset();
    }
    week_id = 0;
}


// function noofphoto(){
//     var container = document.getElementById("image");
//     container.innerHTML = "";
//     var count = parseInt(document.getElementById("no_of_photo").value);
    

//     for (var i = 1; i <= count; i++) {

//         var selectElement = document.createElement("select");
//         var options = [
//             { value: "", text: "Others" },
//             { value: "flowchart", text: "Flowchart" },
//             { value: "signup", text: "Sign Up Page" },
//             { value: "login", text: "Login Page" },
//             { value: "homescr", text: "Home Page" }
//         ];

//         options.forEach(function(option) {
//             var optionElement = document.createElement("option");
//             optionElement.setAttribute("value", option.value);
//             optionElement.textContent = option.text;
//             selectElement.appendChild(optionElement);
//         });

//         var img = document.createElement('input');
//         var s_id = document.createElement('input');
        

//         img.type = "file";
//         img.name = `img_id${i}`;
//         img.id = `img_id${i}`;

//         // type.options(options);
//         selectElement.id =`type${i}`;
//         selectElement.name=`type${i}`;

//         s_id.type ="text";
//         s_id.placeholder = `Student id`; 
//         s_id.id = `student_id${i}`;
//         s_id.name = `student_id${i}`;
//         // id.min = "0";
//         // id.placeholder = `Student ${i+1} id`; 
//         // inp.id = "Student_input";

//         container.appendChild(s_id);
//         container.appendChild(selectElement);
//         container.appendChild(img);
//     }
// }