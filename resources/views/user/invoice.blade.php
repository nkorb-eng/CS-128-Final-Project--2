<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Prototype</title>
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
    </style>
</head>
<body>
    <header>
        <h1>Invoice</h1>
        <address>
            <p>HOTEL BLUE BIRD,</p>
            <p>(+91) 9313346569</p>
        </address>
    </header>
    <article>
        <h1>Recipient</h1>
        <address>
            <p>Guest User<br></p>
        </address>
        <table class="meta">
            <tr>
                <th><span>Invoice #</span></th>
                <td><span>INV-9982</span></td>
            </tr>
            <tr>
                <th><span>Date</span></th>
                <td><span>2026-07-20</span></td>
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
                    <td><span>Deluxe Room</span></td>
                    <td><span>5</span></td>
                    <td><span>₹600</span></td>
                    <td><span>1</span></td>
                    <td><span>₹3000</span></td>
                </tr>
                <tr>
                    <td><span>Breakfast Meal Included</span></td>
                    <td><span>5</span></td>
                    <td><span>₹100</span></td>
                    <td><span>1</span></td>
                    <td><span>₹500</span></td>
                </tr>
            </tbody>
        </table>

        <table class="balance">
            <tr>
                <th><span>Total</span></th>
                <td><span>₹3500</span></td>
            </tr>
            <tr>
                <th><span>Amount Paid</span></th>
                <td><span>₹3500</span></td>
            </tr>
            <tr>
                <th><span>Balance Due</span></th>
                <td><span>₹0.00</span></td>
            </tr>
        </table>
    </article>
</body>
</html>