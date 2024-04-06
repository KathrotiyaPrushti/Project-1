var divIndex = 0;
var $_name;
var tab = "daily";
var week_id =0; 
var imgDataArray = [];



// var popup_overlay = document.getElementById("popup-overlay");
$(function() {
    loadDailyContent()
    
    function openPopup(tab) {
            // Open the pop-up for the Daily tab
            // $('#addnotesmodal').modal('show');
            $('.modal').show();
            console.log('daily');
            $('#btn-n-add').prop('disabled', false);
            
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


    setInterval(refreshContent, 500);
    $('#daily').on('click', function(e) {
        e.preventDefault();
        loadDailyContent();
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

    //for refreshing the load content according tab on which we are rght now 
    function refreshContent() {
            loadDailyContent();
    }
    
});
function savedata() {
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