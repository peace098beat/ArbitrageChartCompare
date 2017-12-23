<!DOCTYPE HTML>
<html>
<head>
<script>

var chart;
dataPoints1=[];
dataPoints2=[];
coin1="bitfinex";
coin2="gdax";
tick="60"; // 60 180


function chartReload(){
	
	s1 = document.getElementById("series1");
	s2 = document.getElementById("series2");

	coin1 = s1.value;
	coin2 = s2.value;
	dataPoints1=[];
	dataPoints2=[];
	init();
};



window.onload = init;

function init(){

chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: true,
	title:{
		text: "Arbitrage"
	},
	axisX: {
		// valueFormatString: "DD MMM ",
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		}
	},
	axisY: {
		includeZero:false, 
		prefix: "$",
		title: "Price (USD/BTC)",
		crosshair: {
			enabled: true
		}
	},
	toolTip: {
		shared: true
	},
	legend: {
		cursor: "pointer",
		itemclick: toogleDataSeries
	},
	data: [
		{
			type: "candlestick",
			showInLegend: true,
			name: coin1,
			yValueFormatString: "$###0.00",
			xValueFormatString: "MMMM YY",
			dataPoints: dataPoints1
		},{
			type: "candlestick",
			showInLegend: true,
			name: coin2,
			yValueFormatString: "$###0.00",
			xValueFormatString: "MMMM YY",
			dataPoints: dataPoints2
		}
	]
});

chart.render();

function toogleDataSeries(e) {
	if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	} else {
		e.dataSeries.visible = true;
	}
	e.chart.render();
}

json=[];

$.get("data/"+coin1+".json", getDataPointsFromCSV1);
function getDataPointsFromCSV1(json) {

    
    y = json["result"][tick]; //60 180 300
    n = y.length;
    
	for (var i = 0; i < y.length; i++) {
		if (y[i].length > 0) {
			points = y[i];
			var unixTimestamp=points[0];
			var date = new Date( unixTimestamp * 1000 );
			
			if(points[1]==0) continue;

			dataPoints1.push({	x:date, 
								y: [
									parseFloat(points[1]),
									parseFloat(points[2]),
									parseFloat(points[3]),
									parseFloat(points[4])
									]
								});
		}
	}
    chart.render();
}

$.get("data/"+coin2+".json", getDataPointsFromCSV2);
function getDataPointsFromCSV2(json) {

    
    y = json["result"][tick]; //60 180 300
    n = y.length;
    
	for (var i = 0; i < y.length; i++) {
		if (y[i].length > 0) {
			points = y[i];
			var unixTimestamp=points[0];
			var date = new Date( unixTimestamp * 1000 );
			
			if(points[1]==0) continue;

			dataPoints2.push({	x:date, 
								y: [
									parseFloat(points[1]),
									parseFloat(points[2]),
									parseFloat(points[3]),
									parseFloat(points[4])
									]
								});
		}
	}
    chart.render();
}

}
</script>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="アービトラージ">
  <title>アービトラージ</title>
  <meta name="keywords" content="アービトラージ" />

</head>
<body>
<select name="series1" id="series1">
	<option value="bitfinex">bitfinex</option>
	<option value="gdax">gdax</option>
	<option value="bitstamp">bitstamp</option>
	<option value="kraken">kraken</option>
	<option value="btce">btce</option>
	<option value="cryptsy">cryptsy</option>
	<option value="cexio">cexio</option>
	<option value="gemini">gemini</option>
	<option value="quoine">quoine</option>
	<option value="bitflyer">bitflyer</option>
	<option value="okcoin">okcoin</option>
	<option value="mexbt">mexbt</option>
	<option value="mtgox">mtgox</option>
	<option value="bitsquare">bitsquare</option>
	<option value="quadriga">quadriga</option>

</select>
<select name="series2" id="series2">
	<option value="bitfinex">bitfinex</option>
	<option value="gdax">gdax</option>
	<option value="bitstamp">bitstamp</option>
	<option value="kraken">kraken</option>
	<option value="btce">btce</option>
	<option value="cryptsy">cryptsy</option>
	<option value="cexio">cexio</option>
	<option value="gemini">gemini</option>
	<option value="quoine">quoine</option>
	<option value="bitflyer">bitflyer</option>
	<option value="okcoin">okcoin</option>
	<option value="mexbt">mexbt</option>
	<option value="mtgox">mtgox</option>
	<option value="bitsquare">bitsquare</option>
	<option value="quadriga">quadriga</option>

</select>

<input type="button" value="reload" onclick="chartReload();"/>

<div id="chartContainer" style="height: 370px; width: 100%;"></div>

<p>このサイトはアービトラージのために、複数の取引所間のUSD/BTC価格を比較できるサイトです</p>
<p>チャートは現在時刻から3時間前までのデータを表示しています。</p>
<p>差額のチャートを追加予定です.</p>

<h2>データの元</h2>
<p> Cryptwatch : <a href="https://cryptowatch.jp/bitflyer/btcjpy" target="_brank">https://cryptowatch.jp/bitflyer/btcjpy</a></p>
<p> API : <a href="https://cryptowatch.jp/docs/api#ohlc" target="_brank">https://cryptowatch.jp/docs/api#ohlc</a></p>

<p>データはPHPでバッチ処理をさせてjson形式で保存して利用しています</p>
<script src="https://gist.github.com/peace098beat/4ffd13918d4515b51f13da40406d3b36.js"></script>



<Form><Input type="button" value="(触らないで)Update DB.." onClick="window.open('download_csv_php.php')"></Form>

<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>



</body>
</html>