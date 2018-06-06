


var ws=new WebSocket("ws://127.0.0.1:1234");
ws.onmessage=function (e) {
    var data=eval("("+e.data+")");
    if (data.chengyu!==undefined)              //成语由workerman提供
    {
        $(".thumbnail").children("p").html(data.chengyu);
    }
    if (data.part==="part1"){
        if (data.msg!==undefined){
            $("#part1-msg").append(data.msg);
        }
        if (data.alrt!==undefined){
            $("#alrt").html(data.alrt);
            $("#alertModal").modal("show");
        }
    }
    if (data.part==="part3"){
        if (data.msg!==undefined){
            $("#part3-msg").append(data.msg);
        }
        if (data.alrt!==undefined){
            $("#alrt").html(data.alrt);
            $("#alertModal").modal("show");
        }
    }
    if (data.part==="part4"){
        if (data.msg!==undefined){
            $("#part4-msg").append(data.msg);
        }
        if (data.alrt!==undefined){
            $("#alrt").html(data.alrt);
            $("#alertModal").modal("show");
        }
    }

};

function showPage(page) {
    json = '{"cmd":"show_page", "page":"'+page+'"}';
    ws.send(json)
}

function startTimer() {}
function stopTimer() {}
function resetTimer(time) {
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
    $("ul li").removeClass("active");
    $("#nav-part1").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","block");
    $("#part2").css("display","none");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","none");


}

/**
 * 切换至第二关
 */
function part2() {
    $("ul li").removeClass("active");
    $("#nav-part2").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","none");
    $("#part2").css("display","block");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","none");
}

/**
 * 切换至亲友助阵
 */
function extraPart() {
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
    $("ul li").removeClass("active");
    $("#nav-part4").addClass("active");

    $("#home").css("display","none");
    $("#part1").css("display","none");
    $("#part2").css("display","none");
    $("#extraPart").css("display","none");
    $("#part3").css("display","none");
    $("#part4").css("display","block");
}

/**
 * 第一关——操作
 */
function Part1Action(action){
    var group=$("#part1-group").val();
    var data={
        part:"part1",
        group:group,
        act:action
    };
    ws.send(JSON.stringify(data));
}

/**
 * 第一关，开始
 */
function Part1Start(){
    var select=$("#part1-group");
    var group=select.val();
    var data={
        part:"part1",
        group:group,
        act:"start"
    };
    ws.send(JSON.stringify(data));

    select.attr("disabled",true);
    $("#part1-btn").children("button").attr("disabled",false);
    $("#part1-end").attr("disabled",false);
    $("#part1-start").attr("disabled",true);
}

/**
 * 第一关，时间到
 */
function Part1End() {
    var select=$("#part1-group");
    var group=select.val();
    var data={
        part:"part1",
        group:group,
        act:"end"
    };
    ws.send(JSON.stringify(data));

    select.attr("disabled",false);
    $("#part1-btn").children("button").attr("disabled",true);
    $("#part1-end").attr("disabled",true);
    $("#part1-start").attr("disabled",false);
}

/**
 * 第二关，提交成绩
 */
function Part2Submit() {
    var groupOneSelect=$("select[name=part2-groupOne]");
    var groupTwoSelect=$("select[name=part2-groupTwo]");

    var groupOne=groupOneSelect.val();
    var groupTwo=groupTwoSelect.val();

    if (groupOne==""||groupTwo==""){
        $("#alrt").html("请选择两个组后，再提交");
        $("#alertModal").modal('show');
        return;
    }
    if (groupOne==groupTwo){
        $("#alrt").html("两个组不能选成一样的");
        $("#alertModal").modal('show');
        return;
    }

    var groupOneCount=0;
    var groupTwoCount=0;

    if ($("input[name=part2-q1-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part2-q1-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part2-q2-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part2-q2-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part2-q3-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part2-q3-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part2-q4-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part2-q4-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part2-q5-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part2-q5-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }



    var success=1;
    $.post("save.php",{
        part:"part2",
        group:groupOne,
        score:groupOneCount
    },function (data) {
        data=eval("("+data+")");
        if (data.msg!==undefined){
            $("#part2-msg").append(data.msg);
        }
        if (data.error!==undefined){
            $("#part2-msg").append(data.error);
            success=0;
        }
    });
    $.post("save.php",{
        part:"part2",
        group:groupTwo,
        score:groupTwoCount
    },function (data) {
        data=eval("("+data+")");
        if (data.msg!==undefined){
            $("#part2-msg").append(data.msg);
        }
        if (data.error!==undefined){
            $("#part2-msg").append(data.error);
            success=0;
        }
    });

    if (success){
        groupOneSelect.children("option").prop("selected",false);
        groupTwoSelect.children("option").prop("selected",false);
        groupOneSelect.children(".part2-select-default").prop("selected",true);
        groupTwoSelect.children(".part2-select-default").prop("selected",true);
        $("input[type=checkbox]").prop("checked",false);
    }
}

/**
 * 第二关，切换成语
 */
function Part2Next(){
    var data={
        part:"part2",
        act:"next"
    };
    ws.send(JSON.stringify(data));
}

/**
 * 第三关——操作
 */
function Part3Action(action){
    var group=$("#part3-group").val();
    var data={
        part:"part3",
        group:group,
        act:action
    };
    ws.send(JSON.stringify(data));
}

/**
 * 第三关，开始
 */
function Part3Start(){
    var select=$("#part3-group");
    var group=select.val();
    var data={
        part:"part3",
        group:group,
        act:"start"
    };
    ws.send(JSON.stringify(data));

    select.attr("disabled",true);
    $("#part3-btn").children("button").attr("disabled",false);
    $("#part3-end").attr("disabled",false);
    $("#part3-start").attr("disabled",true);
}

/**
 * 第三关，时间到
 */
function Part3End() {
    var select=$("#part3-group");
    var group=select.val();
    var data={
        part:"part3",
        group:group,
        act:"end",
        time:"60"
    };
    ws.send(JSON.stringify(data));

    select.attr("disabled",false);
    $("#part3-btn").children("button").attr("disabled",true);
    $("#part3-end").attr("disabled",true);
    $("#part3-start").attr("disabled",false);
}

/**
 * 第四关，提交成绩
 */
function Part4Submit() {
    var groupOneSelect=$("select[name=part4-groupOne]");
    var groupTwoSelect=$("select[name=part4-groupTwo]")

    var groupOne=groupOneSelect.val();
    var groupTwo=groupTwoSelect.val();

    if (groupOne==""||groupTwo==""){
        $("#alrt").html("请选择两个组后，再提交");
        $("#alertModal").modal('show');
        return;
    }
    if (groupOne==groupTwo){
        $("#alrt").html("两个组不能选成一样的");
        $("#alertModal").modal('show');
        return;
    }

    var groupOneCount=0;
    var groupTwoCount=0;

    if ($("input[name=part4-q1-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part4-q1-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part4-q2-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part4-q2-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part4-q3-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part4-q3-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part4-q4-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part4-q4-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }

    if ($("input[name=part4-q5-groupOne-win]").is(":checked")){
        groupOneCount++;
    }
    if ($("input[name=part4-q5-groupTwo-win]").is(":checked")){
        groupTwoCount++;
    }


    var success=1;
    $.post("save.php",{
        part:"part4",
        group:groupOne,
        score:groupOneCount
    },function (data) {
        data=eval("("+data+")");
        if (data.msg!==undefined){
            $("#part4-msg").append(data.msg);
        }
        if (data.error!==undefined){
            $("#part4-msg").append(data.error);
            success=0;
        }
    });
    $.post("save.php",{
        part:"part4",
        group:groupTwo,
        score:groupTwoCount
    },function (data) {
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
        groupTwoSelect.children("option").prop("selected",false);
        groupOneSelect.children(".part4-select-default").prop("selected",true);
        groupTwoSelect.children(".part4-select-default").prop("selected",true);
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
                score:1
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
function eliminateGroup(){
    var select=$("select[name=eliminate-group]");
    var group=select.val();
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
        part:"part1",
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