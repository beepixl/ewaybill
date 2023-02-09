<?php
$inrSym = '<span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>';
?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $setting->invPrefix }}-{{ $invoice['invDate'] }}-{{ $invoice['customer']['toTrdName'] }} </title>

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
        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            color: #000;
            text-align: center;
            line-height: 35px;
        }
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
                <span class="mr-0 mainHeading">PROFOMA INVOICE</span> <br>
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
   
            <td align="right">
                <table align="right">
                    <tr>
                        <td><strong>Invoice Date</strong></td>
                        <td>:</td>
                        <td>{{ date('M d,Y', strtotime($invoice['invDate'])) }}</td>
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
                <th align="right">Total</tha>
            </tr>
        </thead>
        <tbody class="borderBottom mainBody">
            @php
                $mainTot = 0;
            @endphp
            @foreach ($invoice['bill_products'] as $item)
                <tr>
                    <td align="left"> <b>{{ $item['productName'] }}</b> <br>
                        @isset($item['productNotes']) <span class="fontGrey"> ({{ $item['productNotes'] }})
                            </span>
                @endif
                </td>
                <td align="left"> <span class="fontGrey">{{ $item['hsnCode'] }}</span> </td>
                <td align="center">{{ $item['quantity'] }} @isset($item['qtyUnit'])
                        ({{ $item['qtyUnit'] }})
                    @endisset
                </td>
                <td align="center">{!! $inrSym !!} {{ $item['taxableAmount'] }}</td>
                <td align="right">{!! $inrSym !!} {{ $item['taxableAmount'] * $item['quantity'] }}</td>
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
                    <td align="right">{!! $inrSym !!} {{ number_format($mainTot, 2) }}</td>
                </tr>
        
                <tr>
                    <td colspan="3"></td>
                    <td align="right" class="mainTotTr">Total </td>
                    <td align="right" class="gray mainTotTr">{!! $inrSym !!} {{ number_format($mainTot, 2) }}</td>
                </tr>
            </tfoot>
        </table>
        <table width="100%">
            <tr>
                <td width="100%">
                    <table width="50%" style="padding-top: 70px;">
                        <tr>
                            <td valign="top"><strong>Notes/Terms</strong></td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="fontGrey">Please Make Payments To :- </span>
                            </td>
                            <td align="right">
                            </td>
                        </tr>
                    
                    </table>
                </td>
                <td width="100px">
                    <table style="padding-top: 150px;">
                        <tr>
                            <td style="text-align: right;align-content:flex-end">
                                {!! $sign !!}
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <footer>
            This is computer
            generated invoice no
            signature required.
        </footer>

    </body>

    </html>
