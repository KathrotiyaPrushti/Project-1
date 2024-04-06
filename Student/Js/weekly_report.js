var divIndex = 0;
var $_name;
var tab = "daily";
var week_id =0; 
var imgDataArray = [];



// var popup_overlay = document.getElementById("popup-overlay");
$(function() {
    loadWeeklyContent();
    
    function openPopup() {
            // Open the pop-up for the Weekly tab
            // ...code to open the weekly pop-up...
            $('.Week').show();
            // popup_overlay.style.display = "flex";
            // $('#btn-n-save').hide();
            $('#btn-n-ad').prop('disabled', false);

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
        openPopup()
    });

    $('.close').on('click', function(event) {
        // $('.modal').hide();
        $('.Week').hide();
        $('#btn-n-add').prop('disabled', true);
        // document.getElementById('note-has-title').value = '';
        // document.getElementById('note-has-description').value = '';
        $('#addweeklyreport')[0].reset();
    });

    
    // //for daily report add button
    // $('#btn-n-add').on('click', function(event) {
    //     console.log(tab);
    //     savedata();
    // });

    //for weekly report add button 
    $('#btn-n-ad').on('click', function(event) {
        console.log(tab);
        savedata();
    });
    setInterval(loadWeeklyContent, 500);
    
    $('#weekly').on('click', function(e) {
        e.preventDefault();
        console.log('week');
        tab = "weekly";
        loadWeeklyContent();
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

    
});
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

        // console.log('veer');

        var $work = document.getElementById('weekly-has-title').value;
        var $future_work = document.getElementById('future_work').value;
        var $link = document.getElementById('links').value;
        // console.log($work);
        // console.log($future_work);
        console.log($link);

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
            link:$link,
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
    
    week_id = 0;
}