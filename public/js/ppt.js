let timer_cy = true;
// 服务端ip为127.0.0.1
ws = new WebSocket("ws://127.0.0.1:1235");
ws.onopen = function () {

};
ws.onmessage = function (e) {
    var data = eval("(" + e.data + ")");
    if (data.getResponder == 1) {
        document.getElementById("getResponder").play();
    }
    console.log(data);
    if (data.chengyu !== "")              //成语由workerman提供
    {
        $("#chengyu").text(data.chengyu);
    }
    if (data.cmd === 'show_page') {
        if (data.page === 'index') index();
        else if (data.page === 'timer') Clock();
        else if (data.page === 'friend') {
            FriendsHelp();
            $('.questionEntry').css('background-color', '').css("box-shadow", "");
        }
        else if (data.page === 'part4') showPart4();
        else if (data.page === 'board') Rank();
    } else if (data.cmd === 'start_timer') startCountDown();
    else if (data.cmd === 'stop_timer') stopCountDown();
    else if (data.cmd === 'reset_timer') {
        clockMode = data.time;
        resetCountDown();
    } else if (data.cmd === 'show_timercy') {
        timer_cy = !timer_cy;
        if ($("#clock").css('display') === 'block')
            Clock();
    } else if (data.cmd === 'set_extra_questions') {
        $("#questions").html('');
        for (q in data.data) {
            i = parseInt(q) + 1;
            $("#questions").append(
                '<div class="question" id="q' + i + '" style="display: none;">\n' +
                '<div class="questionBody">' + data.data[i-1][0] + '</div>\n' +
                '<button class="btn btn-primary showAnswerBtn" onclick="showAnswer(' + i + ')">显示答案</button>\n' +
                '<div class="answer answer'+i+'">' + data.data[i-1][1] + '</div>\n' +
                '<button class="btn btn-primary back" onclick="back();" >' +
                '<span class="glyphicon glyphicon-menu-left"></span>&nbsp; 返回</button>\n' +
                '</div>');
        }
    }
};

var clockMode = 100;

function index() {
    $("#clock").css("display", "none");
    $("#friendsHelp").css("display", "none");
    $("#rank").css("display", "none");
    $('#chengyubox').css('display', 'block');
    $('#chengyubox').addClass('chengyuContainer');
    $('#chengyubox').removeClass('chengyuContainer_in_clock');
}

function Clock() {
    $("#clock").css("display", "block");
    $("#friendsHelp").css("display", "none");
    $("#rank").css("display", "none");
    if (timer_cy)
        $('#chengyubox').css('display', 'block');
    else
        $('#chengyubox').css('display', 'none');
    $('#chengyubox').removeClass('chengyuContainer');
    $('#chengyubox').addClass('chengyuContainer_in_clock');

    $("#nav-clock").addClass("chosen");
    $("#nav-friendsHelp").removeClass("chosen");
    $("#nav-rank").removeClass("chosen");
}

function FriendsHelp() {
    $("#clock").css("display", "none");
    $("#friendsHelp").css("display", "block");
    $("#rank").css("display", "none");
    $('#chengyubox').css('display', 'none');

    $("#nav-clock").removeClass("chosen").addClass("notChosen");
    $("#nav-friendsHelp").addClass("chosen");
    $("#nav-rank").removeClass("chosen");
}

function showPart4() {
    FriendsHelp();
    $('.questionEntry').css('background-color', '').css("box-shadow", "");
    $('.mark-middle').css('background-color', '#FFA500');
    $('.mark-high').css('background-color', '#FF4500');
}

function Rank() {
    $("#clock").css("display", "none");
    $("#friendsHelp").css("display", "none");
    $("#rank").css("display", "block");
    $('#chengyubox').css('display', 'none');


    $("#nav-clock").removeClass("chosen");
    $("#nav-friendsHelp").removeClass("chosen");
    $("#nav-rank").addClass("chosen");

    $.post("getPPT.php", {
        ask: "rank"
    }, function (data) {
        console.log(data);
        data = eval("(" + data + ")");
        $("#rank-body").html(data.rankBody);
    });
}

function startCountDown() {
    $("#start").prop("disabled", true);
    $("#reset").prop("disabled", true);
    $("#countDown").removeClass("countDownFinish").addClass("countDown");
    if (clockMode == 60 || clockMode == 100) {
        document.getElementById("ready").play();
    } else {
        start();
        $('#stop').prop('disabled', false);
    }

}

function start() {
    $('#countDown').countdown(new Date().getTime() + clockMode * 1000)
        .on('update.countdown', function (event) {
            var format = '%M:%S';
            $(this).html(event.strftime(format));
            if (event.offset.minutes == 0 && event.offset.seconds <= 5) {
                document.getElementById('runningTime').play();
            }
        })
        .on('finish.countdown', function (event) {
            $(this).html('时间到！').removeClass("countDown").addClass("countDownFinish");
            document.getElementById('runningTime').load();
            document.getElementById('timesUp').play();
        });
}

function stopCountDown() {
    $("#start").prop("disabled", false);
    $("#stop").prop("disabled", true);
    $("#reset").prop("disabled", false);
    $("#countDown").countdown('stop');
    document.getElementById('runningTime').load();
}

function resetCountDown() {
    stopCountDown();
    if (clockMode == 60) {
        $("#countDown").html("01:00").removeClass("countDownFinish").addClass("countDown");
    } else if (clockMode == 10) {
        $("#countDown").html("00:10").removeClass("countDownFinish").addClass("countDown");
    } else if (clockMode == 20) {
        $("#countDown").html("00:20").removeClass("countDownFinish").addClass("countDown");
    } else if (clockMode == 100) {
        $("#countDown").html("01:40").removeClass("countDownFinish").addClass("countDown");
    }
    $("#reset").prop("disabled", true);
}

function showQuestion(q) {
    $(".entrance").css("display", "none");
    $("#q" + q).css("display", "block");
}

function back() {
    $(".question").css("display", "none");
    $(".entrance").css("display", "block");
}

function clock1min() {
    clockMode = 60;
    $("#countDown").html("01:00").removeClass("countDownFinish").addClass("countDown");
}

function clock10sec() {
    clockMode = 10;
    $("#countDown").html("00:10").removeClass("countDownFinish").addClass("countDown");
}

function clock20sec() {
    clockMode = 20;
    $("#countDown").html("00:20").removeClass("countDownFinish").addClass("countDown");
}

function clock1min40sec() {
    clockMode = 100;
    $("#countDown").html("01:40").removeClass("countDownFinish").addClass("countDown");
}

function showAnswer(i) {
    $(".answer"+i).show();
}