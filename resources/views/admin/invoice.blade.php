<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Invoice</title>
	<style>
		* { border: 0; box-sizing: content-box; color: inherit; font-family: inherit; font-size: inherit; font-style: inherit; font-weight: inherit; line-height: inherit; list-style: none; margin: 0; padding: 0; text-decoration: none; vertical-align: top; }
		h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }
		table { font-size: 75%; table-layout: fixed; width: 100%; border-collapse: separate; border-spacing: 2px; }
		th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; border-radius: 0.25em; border-style: solid; }
		th { background: #EEE; border-color: #BBB; }
		td { border-color: #DDD; }
		html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; background: #999; cursor: default; }
		body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }
		header { margin: 0 0 3em; }
		header:after { clear: both; content: ""; display: table; }
		header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
		header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
		header address p { margin: 0 0 0.25em; }
		header span, header img { display: block; float: right; }
		header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
		header img { max-height: 100%; max-width: 100%; }
		article, article address, table.meta, table.inventory { margin: 0 0 3em; }
		article:after { clear: both; content: ""; display: table; }
		article h1 { clip: rect(0 0 0 0); position: absolute; }
		article address { float: left; font-size: 125%; font-weight: bold; }
		table.meta, table.balance { float: right; width: 36%; }
		table.meta:after, table.balance:after { clear: both; content: ""; display: table; }
		table.meta th { width: 40%; }
		table.meta td { width: 60%; }
		table.inventory { clear: both; width: 100%; }
		table.inventory th { font-weight: bold; text-align: center; }
		table.inventory td:nth-child(1) { width: 26%; }
		table.inventory td:nth-child(2) { width: 38%; }
		table.inventory td:nth-child(3) { text-align: right; width: 12%; }
		table.inventory td:nth-child(4) { text-align: right; width: 12%; }
		table.inventory td:nth-child(5) { text-align: right; width: 12%; }
		table.balance th, table.balance td { width: 50%; }
		table.balance td { text-align: right; }
		aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; border-color: #999; border-bottom-style: solid; }
		@media print {
			* { -webkit-print-color-adjust: exact; }
			html { background: none; padding: 0; }
			body { box-shadow: none; margin: 0; }
			span:empty { display: none; }
		}
		@page { margin: 0; }
	</style>
</head>

<body>
	<header>
		<h1>Invoice</h1>
		<address>
			<p>HOTEL BLUE BIRD,</p>
			<p>(+91) 9313346569</p>
		</address>
		<span><img alt="" src="{{ asset('image/logo.jpg') }}"></span>
	</header>
	<article>
		<h1>Recipient</h1>
		<address>
			<p>{{ $payment->Name }} <br></p>
		</address>
		<table class="meta">
			<tr>
				<th><span>Invoice #</span></th>
				<td><span>{{ $payment->id }}</span></td>
			</tr>
			<tr>
				<th><span>Date</span></th>
				<td><span>{{ $payment->cout }} </span></td>
			</tr>
		</table>
		<table class="inventory">
			<thead>
				<tr>
					<th><span>Item</span></th>
					<th><span>No of Days</span></th>
					<th><span>Rate</span></th>
					<th><span>Quantity</span></th>
					<th><span>Price</span></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><span>{{ $payment->RoomType }}</span></td>
					<td><span>{{ $payment->noofdays }} </span></td>
					<td><span data-prefix>₹</span><span>{{ $roomRate }}</span></td>
					<td><span>{{ $payment->NoofRoom }} </span></td>
					<td><span data-prefix>₹</span><span>{{ $payment->roomtotal }}</span></td>
				</tr>
				<tr>
					<td><span>{{ $payment->Bed }} Bed </span></td>
					<td><span>{{ $payment->noofdays }}</span></td>
					<td><span data-prefix>₹</span><span>{{ $bedRate }}</span></td>
					<td><span>{{ $payment->NoofRoom }} </span></td>
					<td><span data-prefix>₹</span><span>{{ $payment->bedtotal }}</span></td>
				</tr>
				<tr>
					<td><span>{{ $payment->meal }} </span></td>
					<td><span>{{ $payment->noofdays }}</span></td>
					<td><span data-prefix>₹</span><span>{{ $mealRate }}</span></td>
					<td><span>{{ $payment->NoofRoom }} </span></td>
					<td><span data-prefix>₹</span><span>{{ $payment->mealtotal }}</span></td>
				</tr>
			</tbody>
		</table>

		<table class="balance">
			<tr>
				<th><span>Total</span></th>
				<td><span data-prefix>₹</span><span>{{ $payment->finaltotal }}</span></td>
			</tr>
			<tr>
				<th><span>Amount Paid</span></th>
				<td><span data-prefix>₹</span><span>0.00</span></td>
			</tr>
			<tr>
				<th><span>Balance Due</span></th>
				<td><span data-prefix>₹</span><span>{{ $payment->finaltotal }}</span></td>
			</tr>
		</table>
	</article>
	<aside>
		<h1><span>Contact us</span></h1>
		<div>
			<p align="center">Email :- pankhaniyatushar9@gmail.com || Web :- www.bluebird.com || Phone :- +91 9313346569 </p>
		</div>
	</aside>
</body>

</html>
