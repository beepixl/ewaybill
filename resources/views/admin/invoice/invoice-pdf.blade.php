<?php
$inrSym = $invoice['customer']['currency_symbol']['symbol'];
?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ $setting->invPrefix }}-{{ $invoice['invNo'] }}-{{ $invoice['customer']['toTrdName'] }}-{{ $status }}
    </title>

    <style type="text/css">
    @page {
    size: 7in 9.25in;
    margin: 27mm 16mm 27mm 16mm;
}
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

        .signature {
            bottom: -60px;
            margin-left: 389px;
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
                <span class="mr-0 mainHeading">TAX INVOICE</span> <br>
                @if ($invoice['customer']['customer_type'] == 'local')
                <span class="fontGrey">GSTIN:{{ $setting->fromGstin }}</span> <br>
                @endif
                <span class="font-800">{{ config('app.name') }}</span> <br>
                <span class="fontGrey"> {{ $setting->fromAddr1 }}</span> <br>
                <span class="fontGrey"> {{ $setting->fromAddr2 }}</span> <br>
                <span class="fontGrey"> {{ $setting->fromPlace }}</span> <br>
                <span class="fontGrey"> {{ $setting->fromPincode }}</span> <br>
                <p class="mr-0">+919978052575</p>
                <p class="mr-0">www.rajeshwariinternational.in </p>
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
                            <strong>{{ optional($invoice['customer'])['toTrdName'] }}</strong>
                        </td>
                    </tr>
                    @if ($invoice['customer']['customer_type'] == 'local')
                    <tr>
                        <td class="fontGrey">
                            GSTIN: {{ optional($invoice['customer'])['toGstin'] }}
                        </td>
                    </tr>
                   @endif
                    <tr>
                        <td class="fontGrey">
                            {{ optional($invoice['customer'])['toAddr1'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fontGrey">
                            {{ optional($invoice['customer'])['toAddr2'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fontGrey">
                            {{ optional($invoice['customer'])['toPlace'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="fontGrey">
                            {{ optional($invoice['customer'])['toPincode'] }}
                        </td>
                    </tr>
                </table>
            </td>
            <td align="right">
                <table align="right">
                    <tr>
                        <td><strong>Invoice No</strong></td>
                        <td>:</td>
                        <td align="right">{{ $invoice['invNo'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Invoice Date</strong></td>
                        <td>:</td>
                        <td align="right">{{ date('M d,Y', strtotime($invoice['invDate'])) }}</td>
                    </tr>
                    @if ($invoice['customer']['customer_type'] == 'local')
                    <tr>
                        <td><strong>Vehicle No</strong></td>
                        <td>:</td>
                        <td align="right">{{ $invoice['vehicleNo'] }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Payment Due</strong></td>
                        <td>:</td>
                        <td align="right">{{ date('M d,Y', strtotime($invoice['invDate'])) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Amount Due(INR)</strong></td>
                        <td>:</td>
                        <td align="right">{{ $inrSym }}
                            {{ number_format($invoice['totInvValue'] - $paidAmt, 2) }}</td>
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
                        @isset($item['productNotes']) <span class="fontGrey"> ({!! nl2br($item['productNotes']) !!})
                            </span>
                @endif
                </td>
                <td align="left"> <span class="fontGrey">{{ $item['hsnCode'] }}</span> </td>
                <td align="center">{{ $item['quantity'] }} @isset($item['qtyUnit'])
                        ({{ $item['qtyUnit'] }})
                    @endisset
                </td>
                <td align="center">{{ $inrSym }} {{ $item['taxableAmount'] }}</td>
                <td align="right">{{ $inrSym }} {{ $item['taxableAmount'] * $item['quantity'] }}</td>
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
                    <td align="right">{{ $inrSym }} {{ number_format($mainTot, 2) }}</td>
                </tr>
                @if ($invoice['cgstValue'] > 0)
                    <tr>
                        <td colspan="3"></td>
                        <td align="right">CGST 9%</td>
                        <td align="right">{{ $inrSym }} {{ number_format($invoice['cgstValue'], 2) }}</td>
                    </tr>
                    @php
                        $mainTot += $invoice['cgstValue'];
                    @endphp
                @endif
                @if ($invoice['sgstValue'] > 0)
                    <tr>
                        <td colspan="3"></td>
                        <td align="right">SGST 9%</td>
                        <td align="right">{{ $inrSym }} {{ number_format($invoice['sgstValue'], 2) }}</td>
                    </tr>
                    @php
                        $mainTot += $invoice['sgstValue'];
                    @endphp
                @endif
                @if ($invoice['igstValue'] > 0)
                    <tr>
                        <td colspan="3"></td>
                        <td align="right">IGST 18%</td>
                        <td align="right">{{ $inrSym }} {{ number_format($invoice['igstValue'], 2) }}</td>
                    </tr>
                    @php
                        $mainTot += $invoice['igstValue'];
                    @endphp
                @endif

                <tr>
                    <td colspan="3"></td>
                    <td align="right" class="mainTotTr">Total </td>
                    <td align="right" class="gray mainTotTr">{{ $inrSym }} {{ number_format($mainTot, 2) }}</td>
                </tr>
                <tr>
                    <td align="left" colspan="5"> {{ strtoupper("Amount In Words: ".convert_number_to_words($mainTot)) }}</td>
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
                                <span class="fontGrey">INCOTERMS :- {{ $invoice['incoterms'] }}</span>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                        <tr></tr>
                       
                        <tr>
                            <td align="left">
                                <span class="fontGrey"><b>Bank Details:</b></span>
                            </td>
                            <td align="right">
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="fontGrey"><b>A/C Name :
                                        {{ optional($invoice['bank'])['account_name'] }}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="fontGrey"><b>A/C No :
                                        {{ optional($invoice['bank'])['account_no'] }}</b></span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="fontGrey"><b>Bank Name :
                                        {{ optional($invoice['bank'])['bank_name'] }}</b></span>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="fontGrey"><b>IFSC Code :
                                        {{ optional($invoice['bank'])['ifsc_code'] }}</b></span>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <span class="fontGrey"><b>Branch Name :
                                        {{ optional($invoice['bank'])['branch_name'] }}</b></span>
                            </td>
                            <td align="right">
                            </td>
                        </tr>

                        @if ($invoice['customer']['customer_type'] == 'global' && !empty($invoice['bank']['swift_code']))
                            <tr>
                                <td align="left">
                                    <span class="fontGrey"><b>Swift Code :
                                            {{ optional($invoice['bank'])['swift_code'] }}</b></span>
                                </td>
                                <td align="right">
                                </td>
                            </tr>
                        @endif

                    </table>
                </td>

                <td width="100px">
                    <table style="padding-top: 150px;">
                        <tr>
                            <td style="text-align: right;align-content:flex-end">

                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <div class="signature">
            {!! $sign !!}
        </div>

        <footer>
            This is a computer generated invoice.
        </footer>

    </body>

    <script>
       window.print();
    </script>
    </html>
