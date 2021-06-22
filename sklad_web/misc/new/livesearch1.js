$(document).ready(function(){

    var state = false;
    var showEmptyMessage = true;

    $('#search input[type=text]').keyup(function(e) {
    clearTimeout($.data(this, 'timer'));
    if (e.keyCode == 13)
        search(true);
    else
        $(this).data('timer', setTimeout(search, 300));
    });

function showLoading(state){
    if (state) {
        $('.top-form .result').addClass('loading');
    } else {
        $('.top-form .result').removeClass('loading');
    }
};

function showFocus(state){
    if (state) {
        showEmptyMessage = true;
    } else {
        showEmptyMessage = false;
    }
};

function setFocusSearch(state){
    showFocus(focusSearch = state);
};


$(document).click(function(event) {
        setFocusSearch(false);
        $('.top-form .result').html('');
        event.stopPropagation();
    });

$("#search").focus(function(){
    $('div.search').removeClass('loading');
        setFocusSearch(true);
        search(true);
    }).blur(function(){
        $('div.search').addClass('loading');
        setFocusSearch(false);
    });

function search() {
    var existingString = $("#search input[type=text]").val();
    if (existingString.length < 1 || state) {
        $('.top-form .result').html('');
        return;
    }
    else
    {
        showEmptyMessage = false;
        showLoading(true);
        $.get('/suggest.php', {'data' : existingString},
        function(data) {
            if (data.length > 0)
            {
                showLoading(false);
                $(".top-form .result").show();
                $(".top-form .result").html(data);
            }
        });
    }
}



});
