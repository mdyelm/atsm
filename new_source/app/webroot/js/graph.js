var option = {
    //Boolean - 邵ｦ霆ｸ縺ｮ逶ｮ逶帙ｊ縺ｮ荳頑嶌縺崎ｨｱ蜿ｯ
    scaleOverride: true,
    //** 竊代′true縺ｮ蝣ｴ蜷域怏蜉ｹ **
    //Number - 逶ｮ逶帙ｊ縺ｮ髢馴囈
    scaleSteps: 4,
    //Number - 逶ｮ逶帙ｊ蛹ｺ蛻�ｊ縺ｮ髢馴囈
    scaleStepWidth: 10,
    //Number - 逶ｮ逶帙ｊ縺ｮ譛蟆丞､
    scaleStartValue: 0,
    //繝ｩ繝吶Ν陦ｨ遉ｺ(Y霆ｸ)
    scaleLabel: "<%=value%>",
    //String - 逶ｮ逶帙ｊ縺ｮ邱壹�濶ｲ 
    scaleLineColor: "rgba(0,0,0,.1)",
    //Number - 逶ｮ逶帙ｊ縺ｮ邱壹�蟷�  
    scaleLineWidth : 8,
    //Boolean - 逶ｮ逶帙ｊ繧定｡ｨ遉ｺ縺吶ｋ縺九←縺�°  
    scaleShowLabels : true,
    //String - 逶ｮ逶帙ｊ縺ｮ繝輔か繝ｳ繝�
    scaleFontFamily: "'Helvetica Neue'",
    //scaleFontFamily : "'Arial'",
    //Number - 逶ｮ逶帙ｊ縺ｮ繝輔か繝ｳ繝医し繧､繧ｺ 
    // scaleFontSize : 6,
    scaleFontSize: 15,
    //String - 逶ｮ逶帙ｊ縺ｮ繝輔か繝ｳ繝医せ繧ｿ繧､繝ｫ bold竊貞､ｪ蟄�  
    scaleFontStyle: "normal",
    //String - 逶ｮ逶帙ｊ縺ｮ繝輔か繝ｳ繝� 
    scaleFontColor: "#666",
    ///Boolean - 繝√Ε繝ｼ繝医�閭梧勹縺ｫ繧ｰ繝ｪ繝�ラ繧呈緒逕ｻ縺吶ｋ縺�
    scaleShowGridLines: true,
    //String - 繝√Ε繝ｼ繝郁レ譎ｯ縺ｮ繧ｰ繝ｪ繝�ラ濶ｲ
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - 繝√Ε繝ｼ繝郁レ譎ｯ縺ｮ繧ｰ繝ｪ繝�ラ縺ｮ螟ｪ縺�
    scaleGridLineWidth: 1,
    //Boolean - 邱壹ｒ譖ｲ邱壹↓縺吶ｋ縺九←縺�°縲Ｇalse縺ｧ謚倥ｌ邱壹↓縺ｪ繧�
    bezierCurve: false,
    //Boolean - 轤ｹ繧呈緒逕ｻ縺吶ｋ縺�
    pointDot: false,
    //Number - 轤ｹ縺ｮ螟ｧ縺阪＆
    pointDotRadius: 3,
    //Number - 轤ｹ縺ｮ蜻ｨ繧翫�螟ｧ縺阪＆
    pointDotStrokeWidth: 1,
    //Number - 邱壹�螟ｪ縺�
    datasetStrokeWidth: 1,
    //Boolean - 繧｢繝九Γ繝ｼ繧ｷ繝ｧ繝ｳ縺ｮ譛臥┌
    animation: true,
    multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
};

var data = {
    labels: [],
    datasets: []
};
var setData = function(diff_pix_data, mes_date_data, alert_diff_pix_data,alert_diff_pix_data2,alert_diff_pix_data3) {
    data.labels = $.parseJSON(mes_date_data);
    var max_x_axis = Math.max(Math.max.apply(null, $.parseJSON(diff_pix_data)), Math.max.apply(null, $.parseJSON(alert_diff_pix_data)));
    max_x_axis = Math.ceil(max_x_axis / 10) + 1;
    option.scaleSteps = max_x_axis;
    var diff_pix = {
        fillColor : "rgba(65,113,156,0.1)",
        strokeColor : "#41719c",
        pointColor : "#41719c",
        pointStrokeColor : "#fff",
        data: $.parseJSON(diff_pix_data)
    };
    var diff_pix_threshhold = {
        //1縺､逶ｮ縺ｮ繧ｰ繝ｩ繝輔�謠冗判險ｭ螳�
        fillColor: "rgba(255,0,0,0)", //髱｢縺ｮ濶ｲ繝ｻ騾乗�蠎ｦ
        strokeColor: "rgba(255,0,0,1)", //邱壹�濶ｲ繝ｻ騾乗�蠎ｦ
        pointColor: "rgba(255,0,0,1)", //轤ｹ縺ｮ濶ｲ繝ｻ騾乗�蠎ｦ
        pointStrokeColor: "#fff", //轤ｹ縺ｮ蜻ｨ繧翫�濶ｲ
        data: $.parseJSON(alert_diff_pix_data)
    };
    var diff_pix_threshhold2 = {
        fillColor : "rgba(0,0,0,0)",
        strokeColor : "rgba(237,125,49,1)",
        pointColor : "rgba(237,125,49,1)",
        pointStrokeColor : "#fff",
        data: $.parseJSON(alert_diff_pix_data2)
    };
    var diff_pix_threshhold3 = {
        fillColor : "rgba(0,0,0,0)",
        strokeColor : "#92d050",
        pointColor : "#92d050",
        pointStrokeColor : "#fff",
        data: $.parseJSON(alert_diff_pix_data3)
    };
    
    data.datasets.push(diff_pix);
    data.datasets.push(diff_pix_threshhold);
    data.datasets.push(diff_pix_threshhold2);
    data.datasets.push(diff_pix_threshhold3);
};

var ctx = $("#chart").get(0).getContext("2d");
var setGraph = function() {
    var myNewChart = new Chart(ctx).Line(data, option);
    var xLabels = myNewChart.scale.xLabels;
    var displayLeft = false;
    var displayRight = false;
    //check display time left
//    for (var i = 0; i < 15; i++){
//        if(xLabels[i] != "undefined" && xLabels[i] != "" && displayLeft == false){
//            displayLeft = true;
//        }else{
//            xLabels[i] = "";
//        }
//    }
//    //check display time right
//    for (var j = 30; j > 15; j--){
//        if(xLabels[j] != "undefined" && xLabels[j] != "" && displayRight == false){
//            displayRight = true;
//        }else{
//            xLabels[j] = "";
//        }
//    }
    for (var i = 0; i <30; i++){
        if(i!=0 && i!=15 && i!=30){
            xLabels[i] = "";
        }
    }
};
