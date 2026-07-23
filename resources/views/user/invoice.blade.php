<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $payment->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <style>
        body { background: #eef2f8; padding: 30px; }
        .receipt { max-width: 480px; margin: 0 auto; background:#fff; border:1px solid var(--bb-border); border-radius: var(--bb-radius); box-shadow: var(--bb-shadow); padding: 32px; }
        .receipt h1 { text-align:center; font-family: var(--bb-serif); margin-bottom: 4px; }
        .receipt .sub { text-align:center; color: var(--bb-muted); font-size:.8rem; margin-bottom: 22px; }
        .r-row { display:flex; justify-content:space-between; padding: 7px 0; font-size:.92rem; }
        .r-row.dashed { border-top: 1px dashed var(--bb-border-2); margin-top: 6px; padding-top: 12px; }
        .r-row.grand { font-family: var(--bb-serif); font-size:1.15rem; color: var(--bb-navy); border-top: 2px solid var(--bb-navy); margin-top: 8px; padding-top: 12px; }
        .r-label { color: var(--bb-muted); }
        .r-status { text-align:center; margin-top: 20px; }
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
                    <td><span>600</span></td>
                    <td><span>1</span></td>
                    <td><span>3000</span></td>
                </tr>
                <tr>
                    <td><span>Breakfast Meal Included</span></td>
                    <td><span>5</span></td>
                    <td><span>100</span></td>
                    <td><span>1</span></td>
                    <td><span>500</span></td>
                </tr>
            </tbody>
        </table>

        <table class="balance">
            <tr>
                <th><span>Total</span></th>
                <td><span>3500</span></td>
            </tr>
            <tr>
                <th><span>Amount Paid</span></th>
                <td><span>3500</span></td>
            </tr>
            <tr>
                <th><span>Balance Due</span></th>
                <td><span>0.00</span></td>
            </tr>
        </table>
    </article>
</body>
</html>
