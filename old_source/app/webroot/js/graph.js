//jQueryの場合
//普通のjavascriptの場合
//var ctx = document.getElementById("chart1").getContext("2d");

var option = {
    //Boolean - 縦軸の目盛りの上書き許可
    scaleOverride: true,
    //** ↑がtrueの場合有効 **
    //Number - 目盛りの間隔
    scaleSteps: 4,
    //Number - 目盛り区切りの間隔
    scaleStepWidth: 10,
    //Number - 目盛りの最小値
    scaleStartValue: 0,
    //終了
    scaleLineWidth: 1,
    //ラベル表示(Y軸)
    scaleShowLabels: true,
    //ラベル表示のフォーマット
    scaleLabel: "<%=value%>%",
    //String - 目盛りの線の色 
    scaleLineColor: "rgba(0,0,0,.1)",
    //Number - 目盛りの線の幅  
    scaleLineWidth : 8,
            //Boolean - 目盛りを表示するかどうか  
            scaleShowLabels : true,
            //String - 目盛りのフォント
            scaleFontFamily: "'Helvetica Neue'",
    //scaleFontFamily : "'Arial'",
    //Number - 目盛りのフォントサイズ 
    // scaleFontSize : 6,
    scaleFontSize: 15,
    //String - 目盛りのフォントスタイル bold→太字  
    scaleFontStyle: "normal",
    //String - 目盛りのフォント 
    scaleFontColor: "#666",
    ///Boolean - チャートの背景にグリッドを描画するか
    scaleShowGridLines: true,
    //String - チャート背景のグリッド色
    scaleGridLineColor: "rgba(0,0,0,.05)",
    //Number - チャート背景のグリッドの太さ
    scaleGridLineWidth: 1,
    //Boolean - 線を曲線にするかどうか。falseで折れ線になる
    bezierCurve: false,
    //Boolean - 点を描画するか
    pointDot: false,
    //Number - 点の大きさ
    pointDotRadius: 3,
    //Number - 点の周りの大きさ
    pointDotStrokeWidth: 1,
    //Number - 線の太さ
    datasetStrokeWidth: 1,
    //Boolean - アニメーションの有無
    animation: true,
    multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
            //Number - アニメーションの早さ(大きいほど遅い)
            //animationSteps : 60,
            //Function - アニメーション終了時の処理
            //onAnimationComplete : null
}
var ctx = $("#chart").get(0).getContext("2d");

var data = {
    labels: [],
    datasets: []
}

var setData = function (diff_pix_data, mes_date_data, alert_diff_pix_data) {
    data.labels = $.parseJSON(mes_date_data);
    var max_x_axis = Math.max(Math.max.apply(null, $.parseJSON(diff_pix_data)), Math.max.apply(null, $.parseJSON(alert_diff_pix_data)));
    max_x_axis = Math.ceil(max_x_axis / 10) + 1;
    option.scaleSteps = max_x_axis;
    var diff_pix = {
        //1つ目のグラフの描画設定
        label: "画素差異数",
        fillColor: "rgba(125, 206, 160,0.5)", //面の色・透明度
        strokeColor: "rgba(82, 190, 128,1)", //線の色・透明度
        pointColor: "rgba(125, 206, 160,1)", //点の色・透明度
        pointStrokeColor: "#fff", //点の周りの色
        data: $.parseJSON(diff_pix_data)
    };
    var diff_pix_threshhold = {
        //1つ目のグラフの描画設定
        fillColor: "rgba(255,0,0,0)", //面の色・透明度
        strokeColor: "rgba(255,0,0,1)", //線の色・透明度
        pointColor: "rgba(255,0,0,1)", //点の色・透明度
        pointStrokeColor: "#fff", //点の周りの色
        data: $.parseJSON(alert_diff_pix_data)
    }
    data.datasets.push(diff_pix);
    data.datasets.push(diff_pix_threshhold);
    console.log(data);
}

Chart.types.Line.extend({
    name: "LineWith2Line",
    draw: function () {
        Chart.types.Line.prototype.draw.apply(this, arguments);

        var point1 = this.datasets[0].points[this.options.line1AtIndex];
        var point2 = this.datasets[0].points[this.options.line2AtIndex];
        var scale = this.scale;

        // draw line 1
        this.chart.ctx.beginPath();
        this.chart.ctx.moveTo(point1.x, scale.startPoint + 24);
        this.chart.ctx.strokeStyle = 'rgba(255,0,0,0.5)';
        this.chart.ctx.lineTo(point1.x, scale.endPoint);
        this.chart.ctx.stroke();
        
        // draw line 2
        this.chart.ctx.beginPath();
        this.chart.ctx.moveTo(point2.x, scale.startPoint + 24);
        this.chart.ctx.strokeStyle = 'rgba(255,0,0,0.5)';
        this.chart.ctx.lineTo(point2.x, scale.endPoint);
        this.chart.ctx.stroke();

        this.chart.ctx.fillStyle = 'black';
        // write line 1 label
        this.chart.ctx.textAlign = 'center';
        this.chart.ctx.fillText(this.options.line1Label, point1.x, scale.startPoint + 12);
        
        // write line 1 label
        this.chart.ctx.textAlign = 'center';
        this.chart.ctx.fillText(this.options.line2Label, point2.x, scale.startPoint + 12);
    }
});

var setGraph = function () {
    var myNewChart = new Chart(ctx).Line(data, option);
}

var setGraph2Line = function (alert_start, alert_end) {
    alert_start = $.parseJSON(alert_start);
    alert_end = $.parseJSON(alert_end);
    option.line1AtIndex = alert_start.index;
    option.line2AtIndex = alert_end.index;
//    option.line1Label = alert_start.label;
    option.line1Label = "始";
//    option.line2Label = alert_end.label;
    option.line2Label = "終";
    var myNewChart = new Chart(ctx).LineWith2Line(data, option);
}

//optionは無くても描画可能
//var myNewChart = new Chart(ctx).Line(data);