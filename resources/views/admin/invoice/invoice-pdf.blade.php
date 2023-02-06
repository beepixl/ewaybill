<?php
$inrSym = '<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>';
?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $setting->invPrefix }}-{{ $invoice['invNo'] }}-{{ $invoice['customer']['toTrdName'] }}-{{ $status }}
    </title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
            padding: 4px;
        }

        .gray {
            background-color: lightgray
        }

        .mr-0 {
            margin: 0;
        }

        .font-800 {
            font-weight: 800;
        }

        .borderBottom {
            border-bottom: 1px solid black;
        }

        /* .addressTable {
            padding: 0px 15px;
        } */
        .tableHead>tr>th {
            padding: 10px;
            background: skyblue;
        }

        /* tbody>tr>td {
           padding: 5px;
        } */
        .toAddress>tr>td {
            padding: 0;
        }

        .mainHeading {
            font-size: 28px;
        }

        .fontGrey {
            color: grey;
        }

        .breakLine {
            word-wrap: break-word;
        }

        .mainBody::after {
            content: '';
            display: block;
            height: 15px;

        }

        .mainBody td {
            padding: 4px;
        }

        /*
        .mainTotTr{
            borde
        } */
    </style>

</head>

<body>
    <table width="100%">
        <tr>
            <td valign="top" class="borderBottom"><img
                    src="https://rajeshwariinternational.in/wp-content/uploads/2021/06/cropped-logo-removebg-preview.png"
                    width="250" />
            </td>
            <td align="right" class="borderBottom">
                <span class="mr-0 mainHeading">TAX INVOICE</span> <br>
                <span class="fontGrey">GSTIN:{{ $setting->fromGstin }}</span>
                <pre class="mr-0">
                <span class="font-800">{{ config('app.name') }}</span>
                 <span class="fontGrey"> {{ wordwrap($setting->fromAddr1, 18, "\n", true) }}</span>
                </pre>
                <p class="mr-0">+919978052575</p>
                <p class="mr-0">www.rajeshwariinternational.in</p>
            </td>
        </tr>
    </table>
    <table width="100%" class="addressTable">
        <tr>
            <td align="left" class="toAddress">
                <table>
                    <tr>
                        <td> <span> BILL TO</span></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{ $invoice['toTrdName'] }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="fontGrey">
                            GSTIN: {{ $invoice['toGstin'] }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ $invoice['toAddr1'] }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ $invoice['toAddr2'] }}
                        </td>
                    </tr>
                </table>
            </td>
            <td align="right">
                <table align="right">
                    <tr>
                        <td><strong>Invoice Number</strong></td>
                        <td>:</td>
                        <td>{{ $setting->invPrefix }}-{{ $invoice['invNo'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Invoice Date</strong></td>
                        <td>:</td>
                        <td>{{ date('M d,Y', strtotime($invoice['invDate'])) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment Due</strong></td>
                        <td>:</td>
                        <td>{{ date('M d,Y', strtotime($invoice['invDate'])) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Amount Due(INR)</strong></td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br />

    <table width="100%">
        <thead class="tableHead">
            <tr>
                <th>Item</th>
                <th>HSN</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody class="borderBottom mainBody">
            @php
                $mainTot = 0;
            @endphp
            @foreach ($invoice['bill_products'] as $item)
                <tr>
                    <td align="left"> <b>{{ $item['productName'] }}</b> </td>
                    <td align="left"> <span class="fontGrey">{{ $item['hsnCode'] }}</span> </td>
                    <td align="center">{{ $item['quantity'] }}</td>
                    <td align="center">{!! $inrSym !!} {{ $item['taxableAmount'] }}</td>
                    <td align="center">{!! $inrSym !!} {{ $item['taxableAmount'] * $item['quantity'] }}</td>
                    @php
                        $mainTot += $item['taxableAmount'] * $item['quantity'];
                    @endphp
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Subtotal </td>
                <td align="center">{!! $inrSym !!} {{ number_format($mainTot, 2) }}</td>
            </tr>
            @if ($invoice['cgstValue'] > 0)
                <tr>
                    <td colspan="3"></td>
                    <td align="right">CGST 9%</td>
                    <td align="center">{!! $inrSym !!} {{ number_format($invoice['cgstValue'], 2) }}</td>
                </tr>
                @php
                    $mainTot += $invoice['cgstValue'];
                @endphp
            @endif
            @if ($invoice['sgstValue'] > 0)
                <tr>
                    <td colspan="3"></td>
                    <td align="right">SGST 9%</td>
                    <td align="center">{!! $inrSym !!} {{ number_format($invoice['sgstValue'], 2) }}</td>
                </tr>
                @php
                    $mainTot += $invoice['sgstValue'];
                @endphp
            @endif
            @if ($invoice['igstValue'] > 0)
                <tr>
                    <td colspan="3"></td>
                    <td align="right">IGST 18%</td>
                    <td align="center">{!! $inrSym !!} {{ number_format($invoice['igstValue'], 2) }}</td>
                </tr>
                @php
                    $mainTot += $invoice['igstValue'];
                @endphp
            @endif

            <tr>
                <td colspan="3"></td>
                <td align="right" class="mainTotTr">Total </td>
                <td align="center" class="gray mainTotTr">{!! $inrSym !!} {{ number_format($mainTot, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <table width="100%" style="padding-top: 70px;">
        <tr>
            <td valign="top"><strong>Notes/Terms</strong></td>
        </tr>
        <tr>
            <td align="left">
                <span class="fontGrey">INCOTERMS :- Factory Delivered Rajkot</span>
            </td>
        </tr>
        <tr>
            <td align="left">
                <span class="fontGrey">Please Make Payments To :- </span>
            </td>
            <td align="right">For. {{ config('app.name') }}</td>
        </tr>
        <tr>
            <td align="left">
                <span class="fontGrey">A/C Name - {{ config('app.name') }}</span>
            </td>

        </tr>
        <tr>
            <td align="left">
                <span class="fontGrey">A/c - 50200073812590</span>
            </td>
        </tr>
        <tr>
            <td align="left">
                <span class="fontGrey">IFSC Code - HDFC0009335</span>
            </td>
        </tr>
        <tr>
            <td align="left">
                <span class="fontGrey">Bank :- HDFC Bank (Navsari Desctrict)</span>
            </td>
            <td align="right">Proprietor</td>
        </tr>
    </table>

</body>

</html>
