//jQueryの場合
//普通のjavascriptの場合
//var ctx = document.getElementById("chart1").getContext("2d");

var data1 = {
  //X軸のラベル
  labels : ["2015/06/08 19:08:14","","","","","","","","","","2015/06/08 19:18:14","","","","","","","","","","2015/06/08 19:28:14","","","","","","","","","","2015/06/08 19:38:14","","","","","","","","","","2015/06/08 19:48:14","","","","","","","","","","2015/06/08 19:58:14","","","","","","","","","","2015/06/08 20:08:14"],
  datasets : [
    {
      //1つ目のグラフの描画設定
      fillColor : "rgba(220,220,220,0.5)",//面の色・透明度
      strokeColor : "rgba(255,0,0,1)",//線の色・透明度
      pointColor : "rgba(220,220,220,1)", //点の色・透明度
      pointStrokeColor : "#fff",//点の周りの色
      data : [10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10]//labelごとのデータ
    },
    {
      //2つ目のグラフの描画設定
      fillColor : "rgba(151,187,205,0.5)",
      strokeColor : "rgba(151,187,205,1)",
      pointColor : "rgba(151,187,205,1)",
      pointStrokeColor : "#fff",
      data : [1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,5,14,20,34,31,14,11,1]
    }
  ]
}

var data2 = {
  //X軸のラベル
  labels : ["2015/06/08 09:37:14","","","","","","","","","","2015/06/08 10:37:14","","","","","","","","","","2015/06/08 11:37:14","","","","","","","","","","2015/06/08 12:37:14","","","","","","","","","","2015/06/08 13:37:14","","","","","","","","","","2015/06/08 14:37:14","","","","","","","","","","2015/06/08 15:37:14"],
  datasets : [
    {
      //1つ目のグラフの描画設定
      fillColor : "rgba(220,220,220,0.5)",//面の色・透明度
      strokeColor : "rgba(255,0,0,1)",//線の色・透明度
      pointColor : "rgba(220,220,220,1)", //点の色・透明度
      pointStrokeColor : "#fff",//点の周りの色
      data : [10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10]//labelごとのデータ
    },
    {
      //2つ目のグラフの描画設定
      fillColor : "rgba(151,187,205,0.5)",
      strokeColor : "rgba(151,187,205,1)",
      pointColor : "rgba(151,187,205,1)",
      pointStrokeColor : "#fff",
      data : [1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,5,20,34,31,14,1,1.3,1.1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1]
    }
  ]
}

var data3 = {
  //X軸のラベル
  labels : ["2015/06/08 11:16:49","","","","","","","","","","2015/06/08 13:16:49","","","","","","","","","","2015/06/08 15:16:49","","","","","","","","","","2015/06/08 17:16:49","","","","","","","","","","2015/06/08 19:16:49","","","","","","","","","","2015/06/08 21:16:49","","","","","","","","","","2015/06/08 23:16:49"],
  datasets : [
    {
      //1つ目のグラフの描画設定
      fillColor : "rgba(220,220,220,0.5)",//面の色・透明度
      strokeColor : "rgba(255,0,0,1)",//線の色・透明度
      pointColor : "rgba(220,220,220,1)", //点の色・透明度
      pointStrokeColor : "#fff",//点の周りの色
      data : [10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10]//labelごとのデータ
    },
    {
      //2つ目のグラフの描画設定
      fillColor : "rgba(151,187,205,0.5)",
      strokeColor : "rgba(151,187,205,1)",
      pointColor : "rgba(151,187,205,1)",
      pointStrokeColor : "#fff",
      data : [1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,12,22,32,36,30,22,12,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1,1.3,1,1.3,1,1.3,1,1.3,1.2]
    }
  ]
}

var data4 = {
  //X軸のラベル
  labels : ["2015/06/07 12:45:31","","","","","","","","","","2015/06/07 16:45:31","","","","","","","","","","2015/06/07 20:45:31","","","","","","","","","","2015/06/08 00:45:31","","","","","","","","","","2015/06/08 04:45:31","","","","","","","","","","2015/06/08 08:45:31","","","","","","","","","","2015/06/08 12:45:31"],
  datasets : [
    {
      //1つ目のグラフの描画設定
      fillColor : "rgba(220,220,220,0.5)",//面の色・透明度
      strokeColor : "rgba(255,0,0,1)",//線の色・透明度
      pointColor : "rgba(220,220,220,1)", //点の色・透明度
      pointStrokeColor : "#fff",//点の周りの色
      data : [10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10]//labelごとのデータ
    },
    {
      //2つ目のグラフの描画設定
      fillColor : "rgba(151,187,205,0.5)",
      strokeColor : "rgba(151,187,205,1)",
      pointColor : "rgba(151,187,205,1)",
      pointStrokeColor : "#fff",
      data : [1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,6,9,18,21,34,19,14,7,1,1.3,1,1.3,1,1.3,1,1.3,1,1.3,1,1,1.3,1,1.3,1,1.3,1,1.3,1.1]
    }
  ]
}


var option = {
  //Boolean - 縦軸の目盛りの上書き許可
  scaleOverride : true,
  //** ↑がtrueの場合有効 **
  //Number - 目盛りの間隔
  scaleSteps : 4,
  //Number - 目盛り区切りの間隔
  scaleStepWidth : 10,
  //Number - 目盛りの最小値
  scaleStartValue : 0,
  //終了
  scaleLineWidth : 1,
  //ラベル表示(Y軸)
  scaleShowLabels : true,
  //ラベル表示のフォーマット
  scaleLabel : "<%=value%>%",
  //String - 目盛りの線の色 
  scaleLineColor : "rgba(0,0,0,.1)",
  //Number - 目盛りの線の幅  
  scaleLineWidth : 8,
  //Boolean - 目盛りを表示するかどうか  
  scaleShowLabels : true,
  //String - 目盛りのフォント
  scaleFontFamily : "'Helvetica Neue'",
  //scaleFontFamily : "'Arial'",
  //Number - 目盛りのフォントサイズ 
  // scaleFontSize : 6,
  scaleFontSize : 15,
  //String - 目盛りのフォントスタイル bold→太字  
  scaleFontStyle : "normal",
  //String - 目盛りのフォント 
  scaleFontColor : "#666",  
  ///Boolean - チャートの背景にグリッドを描画するか
  scaleShowGridLines : true,
  //String - チャート背景のグリッド色
  scaleGridLineColor : "rgba(0,0,0,.05)",
  //Number - チャート背景のグリッドの太さ
  scaleGridLineWidth : 1,  
  //Boolean - 線を曲線にするかどうか。falseで折れ線になる
  bezierCurve : false,
  //Boolean - 点を描画するか
  pointDot : false,
  //Number - 点の大きさ
  pointDotRadius : 3,
  //Number - 点の周りの大きさ
  pointDotStrokeWidth : 1,
  //Number - 線の太さ
  datasetStrokeWidth : 1,
  //Boolean - アニメーションの有無
  animation : true
  //Number - アニメーションの早さ(大きいほど遅い)
  //animationSteps : 60,
  //Function - アニメーション終了時の処理
  //onAnimationComplete : null
}
//グラフを描画する
var ctx1 = $("#chart1").get(0).getContext("2d");
var ctx2 = $("#chart2").get(0).getContext("2d");
var ctx3 = $("#chart3").get(0).getContext("2d");
var ctx4 = $("#chart4").get(0).getContext("2d");
var myNewChart = new Chart(ctx1).Line(data1,option);
var myNewChart = new Chart(ctx2).Line(data2,option);
var myNewChart = new Chart(ctx3).Line(data3,option);
var myNewChart = new Chart(ctx4).Line(data4,option);

function SetGraph() {
      selindex = document.selbox.Select1.selectedIndex;
      switch (selindex) {
        case 0:
          document.all.item('chart1').style.display='block';
          document.all.item('chart2').style.display='none';
          document.all.item('chart3').style.display='none';
          document.all.item('chart4').style.display='none';
          document.all.item('tl1').style.display='block';
          document.all.item('tl2').style.display='none';
          document.all.item('tl3').style.display='none';
          document.all.item('tl4').style.display='none';
/*          document.all.item('alt1').style.display='block';
          document.all.item('alt2').style.display='none';
          document.all.item('alt3').style.display='none';
          document.all.item('alt4').style.display='none';*/
          var myNewChart = new Chart(ctx1).Line(data1,option);
          console.log(myNewChart);
          break;
        case 1:
          var ctx2 = $("#chart2").get(0).getContext("2d");
          document.all.item('chart1').style.display='none';
          document.all.item('chart2').style.display='block';
          document.all.item('chart3').style.display='none';
          document.all.item('chart4').style.display='none';
          document.all.item('tl1').style.display='none';
          document.all.item('tl2').style.display='block';
          document.all.item('tl3').style.display='none';
          document.all.item('tl4').style.display='none';
/*          document.all.item('alt1').style.display='none';
          document.all.item('alt2').style.display='block';
          document.all.item('alt3').style.display='none';
          document.all.item('alt4').style.display='none';*/
          var myNewChart = new Chart(ctx2).Line(data2,option);
          console.log(myNewChart);
          break;
        case 2:
          var ctx3 = $("#chart3").get(0).getContext("2d");
          document.all.item('chart1').style.display='none';
          document.all.item('chart2').style.display='none';
          document.all.item('chart3').style.display='block';
          document.all.item('chart4').style.display='none';
          document.all.item('tl1').style.display='none';
          document.all.item('tl2').style.display='none';
          document.all.item('tl3').style.display='block';
          document.all.item('tl4').style.display='none';
/*          document.all.item('alt1').style.display='none';
          document.all.item('alt2').style.display='none';
          document.all.item('alt3').style.display='block';
          document.all.item('alt4').style.display='none';*/
          var myNewChart = new Chart(ctx3).Line(data3,option);
          console.log(myNewChart);
          break;
        case 3:
          var ctx4 = $("#chart4").get(0).getContext("2d");
          document.all.item('chart1').style.display='none';
          document.all.item('chart2').style.display='none';
          document.all.item('chart3').style.display='none';
          document.all.item('chart4').style.display='block';
          document.all.item('tl1').style.display='none';
          document.all.item('tl2').style.display='none';
          document.all.item('tl3').style.display='none';
          document.all.item('tl4').style.display='block';
/*          document.all.item('alt1').style.display='none';
          document.all.item('alt2').style.display='none';
          document.all.item('alt3').style.display='none';
          document.all.item('alt4').style.display='block';*/
          var myNewChart = new Chart(ctx4).Line(data4,option);
          console.log(myNewChart);
          break;
      }
      /*console.log(selindex);*/
    }




//optionは無くても描画可能
//var myNewChart = new Chart(ctx).Line(data);