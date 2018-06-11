
let part = '1';

var ws=new WebSocket("ws://127.0.0.1:1234");
ws.onmessage=function (e) {
    var data=eval("("+e.data+")");
    if (data.chengyu!==undefined)              //成语由workerman提供
    {
        $(".thumbnail").children("p").html(data.chengyu);
    }
    if (data.msg!==undefined){
        $("#msg").prepend(data.msg + '<br/>');
    }
    if (data.alrt!==undefined){
        $("#alrt").html(data.alrt);
        $("#alertModal").modal("show");
    }

};

function showPage(page) {
    json = '{"cmd":"show_page", "page":"'+page+'"}';
    ws.send(json)
}

function startTimer() {
    ws.send('{"cmd": "start_timer"}');
}
function stopTimer() {
    ws.send('{"cmd": "stop_timer"}');

}
function resetTimer(time) {
    ws.send('{"cmd": "reset_timer", "time":"'+time+'"}');
}

function showTimerChengyu() {
    ws.send('{"cmd": "show_timercy"}');
}


$(".part2-result").children(".result").children("label").children("input").click(function () {
    if ($(this).is(":checked")) {
        if ($(this).parent("label").parent(".result").siblings(".result").children("label").children("input").is(":checked")) {
            $(this).parent("label").parent(".result").siblings(".result").children("label").children("input").prop("checked", false);
        }
    }
});

$(".part4-result").children(".result").children("label").children("input").click(function () {
    if ($(this).is(":checked")) {
        if ($(this).parent("label").parent(".result").siblings(".result").children("label").children("input").is(":checked")) {
            $(this).parent("label").parent(".result").siblings(".result").children("label").children("input").prop("checked", false);
        }
    }
});


/**
 * 切换至主页
 */
function home() {
    part = 'home';
    showPage('index');
    resetClientView();
    $("ul li").removeClass("active");
    $("#nav-home").addClass("active");

    $("#home").css("display","block");
    $("#part1").css("display","none");
    $("#part2").css("display","none");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","none");

}

/**
 * 切换至第一关
 */
function part1() {
    part = 'part1';
    showPage('index');

    $("ul li").removeClass("active");
    $("#nav-part1").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","block");
    $("#part2").css("display","none");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","none");
    $("#part1-start").show();
    $("#part2-start").hide();
}

/**
 * 切换至第二关
 */
function part2() {
    part = 'part2';
    showPage('timer');
    resetTimer(100);

    $("ul li").removeClass("active");
    $("#nav-part2").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","none");
    $("#part2").css("display","block");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","none");
    $("#part1-start").hide();
    $("#part2-start").show();
}
/**
 * 切换至亲友助阵
 */
function extraPart() {
    part = 'extraPart';
    resetClientView();
    showPage('friend');
    $("ul li").removeClass("active");
    $("#nav-extraPart").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","none");
    $("#part2").css("display","none");
    $("#extraPart").css("display","block");
    $("#part3").css("display","none");
    $("#part4").css("display","none");
}
/**
 * 切换至第三关
 */
function part3(){
    part = 'part3';
    $("ul li").removeClass("active");
    $("#nav-part3").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","none");
    $("#part2").css("display","none");
    $("#extraPart").css("display","none");
    $("#part3").css("display","block");
    $("#part4").css("display","none");
}

/**
 * 切换至第四关
 */
function part4() {
    part = 'part4';
    showPage('part4');
    $("ul li").removeClass("active");
    $("#nav-part4").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","none");
    $("#part2").css("display","none");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","block");
}

// 第一关下一题
let out_group = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
let first = 0;
function part1Next() {
    $("#part1start").attr('disabled', false);
    $('#part1next').attr('disabled', true);
    let group = $("#part1-group").val();
    let game = $("#part1-game").val();
    group = parseInt(group);
    if (first) {
        do {
            group = group + 1;
            if (group === 13) {
                group = 1;
                game = parseInt(game) + 1;
                $("#part1-game").val(game);
            }
        } while (out_group[group] === 1);
    } else first = 1;
    $("#part1-group").val(group);
    let data = {
        part: 'part1',
        game: game,
        group: group
    };
    ws.send(JSON.stringify(data));
    stopTimer();
    showPage('index');
    ws.send('{"cmd":"clear_answer"}')
}
function part1Answer() {
    $('#part1answer').attr('disabled', 'true');
    $('#part1start').attr('disabled', true);
    $('#part1next').attr('disabled', false);
    let group = $("#part1-group").val();
    let game = $("#part1-game").val();
    let data = {
        part: 'part1',
        act: 'set_answer',
        game: game,
        group: group
    };
    ws.send(JSON.stringify(data));
    stopTimer();
}
function part1Wrong() {
    let group = $("#part1-group").val();
    group = parseInt(group);
    out_group[group - 1] = 1;
    part1Next();
    eliminateGroupS('group' + group);
}

function part1Start() {
    $('#part1start').attr('disabled', true);
    $('#part1answer').attr('disabled', false);
    showPage('timer');
    resetTimer(20);
    startTimer();
}

/**
 * 第二关——操作
 */
function Part2Action(action){
    var group=$("#part2-group").val();
    var data={
        part: part,
        group:group,
        act: action
    };
    ws.send(JSON.stringify(data));
}


/**
 * 第二关，时间到
 */
function Part2End() {
    var select=$("#part2-group");
    var group=select.val();
    var data={
        part:part,
        group:group,
        act:"end"
    };
    ws.send(JSON.stringify(data));

    select.attr("disabled",false);
    $("#part2-btn").children("button").attr("disabled",true);
    $("#part2-end").attr("disabled",true);
    $("#part2-start").attr("disabled",false);
}

/** 第二关 开始计时*/
function Part2Start() {
    resetTimer(100);
    startTimer();
    $("#part2-show-question").attr('disabled', false);
    $('#part2-start').attr('disabled', true);
}

/**
 * 第二关，切换成语
 */
function Part2Question(){
    $('#part2-show-question').attr('disabled', true);
    var group=$("#part2-group").val();
    var data={
        part:"part2",
        act:"start",
        group: group
    };
    ws.send(JSON.stringify(data));
    $("#part2-btn").children("button").attr("disabled",false);
    $("#part2-end").attr("disabled",false);
}

function part3Question() {
    let data = {
        part: 'part3',
        act: 'question'
    };
    ws.send(JSON.stringify(data));
    resetTimer(35);
    showPage('timer');
}
let part3running = false;
function part3Time() {
    if (part3running) {
        stopTimer();
        $("#part3timer").text('开始计时');
        part3running = false;
    } else {
        resetTimer(35);
        startTimer();
        $("#part3timer").text('停止计时');
        part3running = true;
    }
}


/**
 * 第四关，提交成绩
 */
function Part4Submit(mark) {
    var groupOneSelect=$("select[name=part4-groupOne]");

    var groupOne=groupOneSelect.val();

    if (groupOne==""){
        $("#alrt").html("请选择一个组");
        $("#alertModal").modal('show');
        return;
    }

    var success=1;
    $.post("save.php",{
        part:"part4",
        group:groupOne,
        score:mark
    },function (data) {
        console.log(data);
        data=eval("("+data+")");
        if (data.msg!==undefined){
            $("#part4-msg").append(data.msg);
        }
        if (data.error!==undefined){
            $("#part4-msg").append(data.error);
            success=0;
        }
    });

    if (success){
        groupOneSelect.children("option").prop("selected",false);
        groupOneSelect.children(".part4-select-default").prop("selected",true);
        $("input[type=checkbox]").prop("checked",false);
    }
}

/**
 * 亲友助阵，提交成绩
 */
function extraPartSubmit(){
    var success=1;
    var checkbox=$("input[name=extraPart-group]");
    checkbox.each(function () {
        if ($(this).is(":checked")){
            var group=$(this).val();
            $.post("save.php",{
                group:group,
                part:"extrapart",
                score:2
            },function (data) {

                data=eval("("+data+")");
                if (data.msg!==undefined){
                    $("#extraPart-msg").append(data.msg);
                }
                if (data.error!==undefined){
                    $("#extraPart-msg").append(data.error);
                    success=0;
                }
            });

        }
    });
    if(success){
        checkbox.prop("checked",false);
    }
}

/**
 * 淘汰组
 */
function eliminateGroup() {
    var select=$("select[name=eliminate-group]");
    eliminateGroupS(select.val());
}
function eliminateGroupS(select){
    var group=select;
    if (group!==""){
        $.post("save.php",{
            part:"eliminate",
            group:group,
            score:1
        },function (data) {
            data=eval("("+data+")");
            if(data.error!==undefined){
                $("#alrt").html(data.error);
                $("#alertModal").modal('show');
                select.children("option").prop("selected",false);
                select.children("option[value=]").prop("selected",true);
                return;
            }
            if(data.msg!==undefined){
                $("#alrt").html(group+"：已淘汰");
                $("#alertModal").modal('show');
                select.children("option").prop("selected",false);
                select.children("option[value=]").prop("selected",true);
            }
        });
    }
}

/**
 * 打开客户端抢答器
 */
function showResponder(){
    data={
        part:"part4",
        act:"showResponder"
    };
    ws.send(JSON.stringify(data));
}

/**
 * 打开客户端成语显示
 */
function showChengyu() {
    data={
        part:"part1",   // TODO:
        act:"showChengyu"
    };
    ws.send(JSON.stringify(data));
}

/**
 * 复位抢答器
 */
function resetResponder() {
    data={
        part:"part4",
        act:"resetResponder"
    };
    ws.send(JSON.stringify(data));
}

/**
 * 复位平板显示画面
 */
function resetClientView(){
    data={
        reset:"client"
    };
    ws.send(JSON.stringify(data));
}