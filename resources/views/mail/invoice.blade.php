<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Tax Invoice</title>
    <meta charset="utf-8" />
    <title> Binge Club Tax Invoice</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.png" />
    <style>
        * {
            box-sizing: border-box;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
            padding: 10px;
            word-break: break-all;
            font-family: Roboto;
        }


        .h4-14 h4 {
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 5px;
            font-family: Roboto;
        }

        pre,
        p {
            padding: 0;
            margin: 0;
            font-family: Roboto;
        }

        table {
            font-family: roboto;
            width: 100%;
            border-collapse: collapse;
            padding: 1px;
        }

        .hm-p p {
            text-align: left;
            padding: 1px;
            padding: 5px 4px;
        }

        td,
        th {
            text-align: left;
            padding: 4px 6px;
        }

        .table-b td,
        .table-b th {
            border: 1px solid #ddd;
        }

        .hm-p td,
        .hm-p th {
            padding: 3px 0px;
        }


        .main-pd-wrapper {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            border: 1px solid #e5e5e5;
            width: 70%;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        .invoice-items {
            font-size: 14px;
            border-top: 1px dashed #ddd;
        }

        .invoice-items td {
            padding: 14px 0;
        }

        .SN-text {
            width: 100px !important;
        }

        @media only screen and (max-width: 600px) {
            .main-pd-wrapper {
                width: 100% !important;
            }

            .SN-text {
                width: 30px !important;
            }

        }
    </style>
</head>

<body>
    @php
        $now = Carbon\Carbon::now();
    @endphp
    <section class="main-pd-wrapper" style="margin: auto">

        <table width="" border="0" cellpadding="0" cellspacing="0" align="left">
            <tbody>
                <tr style="width:20%;">
                    <td style="text-align: center; width:20%;">
                        <img src="{{ $message->embed('frontend/assets/image/home/logo.svg') }}" alt="logo"
                            style="width: 20%; height:20%;">
                    </td>
                </tr>

            </tbody>
            <tbody>
                <tr>
                    <td align="center"
                        style="padding:13px 25px 10px 25px;font-size:18px;font-family:Roboto;text-align:center;vertical-align:top;background-color:#ffffff;color:#828282">
                        <span style="font-size:26px;font-weight:500;color:#4caf50">
                            Your booking is confirmed!
                        </span>
                    </td>
                </tr>
                <tr>
                    <td align="center"
                        style="padding:5px 25px 25px 25px;font-size:16px;font-family:Arial,sans-serif;text-align:center;vertical-align:top;background-color:#ffffff;color:#828282">
                        Booking ID <span style="color:#000;font-weight:bold">{{ $booking?->id }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table align="center" cellpadding="0" cellspacing="0"
                            style="width:100%;margin:0 auto;padding:10px;background-color:#f5f5f5;border-top-left-radius:5px;border-top-right-radius:5px">
                            <tbody>
                                <tr>
                                    <td valign="top" align="center" style="width:100%;background-color:#f5f5f5">
                                        <table cellspacing="0" cellpadding="0" align="center"
                                            style="width:100%;background-color:#f5f5f5;margin:0px auto">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" align="center"
                                                        style="width:80px;background-color:#f5f5f5;padding:10px 5px 5px 5px">

                                                        @php
                                                            $image = $booking
                                                                ->getScreen()
                                                                ->first()
                                                                ?->getScreenImages()
                                                                ->first();
                                                        @endphp

                                                        <img src="{{ $message->embed('storage/' . $image?->screen_icon) }}"
                                                            width="120" height="200"
                                                            style="display:block;background-color:#f5f5f5;color:#010101;border-radius:5px;object-fit:cover"
                                                            border="0" class="CToWUd" data-bit="iit">


                                                    </td>
                                                    <td valign="top" align="center"
                                                        style="width:370px;background-color:#f5f5f5;padding:10px">
                                                        <table cellspacing="0" cellpadding="0" align="center"
                                                            style="width:100%;background-color:#f5f5f5;margin:0px auto">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="bottom" align="left"
                                                                        style="padding: 4px 0px 0px 0px;font-size:17px; font-weight: 600 ;text-align:left;vertical-align:top;background-color:#f5f5f5;color:#3c3c3c">
                                                                        Screen Type -
                                                                        {{ $booking?->screen_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="bottom" align="left"
                                                                        style="padding: 8px 0px 0px 0px;font-size:16px;text-align:left;vertical-align:top;background-color:#f5f5f5;color:#3c3c3c">
                                                                        {{-- {{ $booking->time_slot }} | --}}
                                                                        {{ Carbon\Carbon::parse($booking?->book_date)->format('D, d M, Y') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="bottom" align="left"
                                                                        style="padding: 8px 0px 0px 0px;font-size:16px;text-align:left;vertical-align:top;background-color:#f5f5f5;color:#3c3c3c">
                                                                        @foreach ($booking->slots as $key => $slot)
                                                                            {{ $slot->slot_name }},
                                                                        @endforeach
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-left: 0;">
                                                                        <span
                                                                            style="display:block;font-size:13px;color:#828282;font-weight:400;padding-top:5px"><span>Address:
                                                                                {{ $booking->location_name }}</span><br>{{ $booking->getLocation ? $booking->getLocation->landmark : '' }}
                                                                            <br>{{ $booking->getLocation ? $booking->getLocation->address : '' }}
                                                                            <br>{{ $booking->getLocation ? $booking->getLocation->pincde : '' }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="padding-left: 0;">
                                                                        <span
                                                                            style="display:block;font-size:13px;color:#828282;font-weight:400;padding-top:5px">
                                                                            Phone :
                                                                            <span>{{ $booking->getLocation->admin_phone }}</span><br>
                                                                            Email :
                                                                            <span>{{ $booking->getLocation->admin_email }}</span>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table align="left" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td align="left"
                        style="padding:15px 10px 15px 10px;font-size:15px;
            text-align:left;vertical-align:top;background-color:#ffffff;
            font-weight:600;color:#828282;letter-spacing:1px">
                        Your Information
                    </td>
                </tr>
            </tbody>
        </table>


        <table width="" border="0" cellpadding="0" cellspacing="0" align="left"
            style="margin-top: 0px; border: 1px solid #ddd; margin-bottom: 0px;">
            <tbody>

                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>

                <tr style="font-size: 14px;">
                    <td style="padding: 5px 20px !important; font-weight: 600;">
                        Name:
                    </td>
                    <td style="padding: 5px 20px !important; color: #575757;">
                        {{ $booking?->name }}
                    </td>
                </tr>

                <tr style="font-size: 14px;">
                    <td style="padding: 5px 20px !important; font-weight: 600;">
                        Email:
                    </td>
                    <td style="padding: 5px 20px !important; color: #575757;">
                        {{ $booking?->email }}
                    </td>
                </tr>
                <tr style="font-size: 14px;">
                    <td style="padding: 5px 20px !important; font-weight: 600;">
                        Phone:
                    </td>
                    <td style="padding: 5px 20px !important; color: #575757;">
                        {{ $booking?->phone }}
                    </td>
                </tr>
                <tr style="font-size: 14px;">
                    <td style="padding: 5px 20px !important; font-weight: 600;">
                        No of people:
                    </td>
                    <td style="padding: 5px 20px !important; color: #575757;">
                        {{ $booking?->number_of_people }}
                    </td>
                </tr>

                </tr>

                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                </tr>

            </tbody>
        </table>


        <table align="left" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td align="left"
                        style="padding:20px 10px 20px 10px;font-size:14px;
              text-align:left;vertical-align:top;background-color:#ffffff;
              font-weight:600;color:#828282;letter-spacing:1px">
                        ORDER SUMMARY
                    </td>
                </tr>
            </tbody>
        </table>

        <table width="" border="0" cellpadding="0" cellspacing="0" align="left"
            style="border:1px solid #f1f1f1;">
            <tbody>
                <tr>
                    <td style="">
                        <table
                            style="width:100%;
                border-top-left-radius:5px;border-top-right-radius:5px;
                margin:0 auto">
                            <tbody>
                                <tr>
                                    <td>
                                        @php
                                            $sl_no = 1;
                                        @endphp

                                        <table style="width:100%;text-align:left;vertical-align:top;">
                                            <tbody>

                                                <tr style="background-color: #F1F1F1;">
                                                    <td style="font-weight: 500; padding: 10px; font-size: 16px;">
                                                        S.No.
                                                    </td>
                                                    <td style="font-weight: 500; padding: 10px; font-size: 16px;">
                                                        Type
                                                    </td>
                                                    <td style="font-weight: 500; padding: 10px; font-size: 16px;">
                                                        Description
                                                    </td>
                                                    <td
                                                        style="font-weight: 500; padding: 10px; font-size: 16px; text-align:end;">
                                                        price
                                                    </td>
                                                </tr>

                                                <tr
                                                    style="font-size: 14px; padding: 12px 0px; border-bottom: 1px dashed #afafaf;">
                                                    <td class="SN-text" style="font-size: 14px; padding: 12px 10px;">
                                                        {{ $sl_no++ }}
                                                    </td>
                                                    <td class="SN-text" style="font-size: 14px; padding: 12px 10px;">
                                                        Slot Amount
                                                    </td>
                                                    <td align="left" style="font-size: 14px; padding: 12px 10px;">

                                                    </td>
                                                    <td style="font-size: 14px; padding: 12px 10px; text-align:end;">
                                                        ₹{{ $booking->time_slot_amount }}
                                                    </td>
                                                </tr>
                                                @if ($booking->number_of_people - optional($booking->getScreen)->capacity > 0)
                                                    <tr
                                                        style="font-size: 14px; padding: 12px 0px; border-bottom: 1px dashed #afafaf;">
                                                        <td class="SN-text"
                                                            style="font-size: 14px; padding: 12px 10px;">
                                                            {{ $sl_no++ }}
                                                        </td>
                                                        <td class="SN-text"
                                                            style="font-size: 14px; padding: 12px 10px; white-space:nowrap;">
                                                            Additional people
                                                        </td>
                                                        <td align="left"
                                                            style="font-size: 14px; padding: 12px 10px;">
                                                            {{ $booking->number_of_people - optional($booking->getScreen)->capacity }}
                                                        </td>
                                                        <td
                                                            style="font-size: 14px; padding: 12px 10px; text-align:end;">
                                                            ₹{{ $booking->additional_amount }}
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if (count($booking->items) > 0)
                                                    @foreach ($booking->items as $key => $item)
                                                        <tr
                                                            style="font-size: 14px; padding: 12px 0px; border-bottom: 1px dashed #afafaf;">
                                                            <td class="SN-text"
                                                                style="font-size: 14px; padding: 12px 10px;">
                                                                {{ $sl_no++ }}
                                                            </td>
                                                            <td class="SN-text"
                                                                style="font-size: 14px; padding: 12px 10px;">
                                                                {{ $item->type }}
                                                            </td>
                                                            <td align="left"
                                                                style="font-size: 14px; padding: 12px 10px;">
                                                                {{ $item->title }}
                                                            </td>
                                                            <td
                                                                style="font-size: 14px; padding: 12px 10px; text-align:end;">
                                                                @if ($item->price == 0)
                                                                    -
                                                                @else
                                                                    ₹ {{ $item->price }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table width="" border="0" cellpadding="0" cellspacing="0" align="left"
            style="border-bottom:1px solid #afafaf; background-color: #F1F1F1; margin-top: 30px;">
            <tbody>
                <tr>
                    <td style="padding: 5px 15px 15px 15px;">
                        <table width="" border="0" cellpadding="0" cellspacing="0" align="left"
                            style=" margin-top: 20px;">
                            <tbody>
                                @if ($booking->balance != 0)
                                    <tr style="font-size: 14px;">
                                        <td>
                                            Total Amount
                                        </td>
                                        <td>&nbsp;</td>
                                        <td style="text-align: right;">
                                            ₹ {{ $booking?->grand_total_amount }}
                                        </td>
                                    </tr>
                                    <tr style="font-size: 14px;">
                                        <td>
                                            Amount Paid
                                        </td>
                                        <td>&nbsp;</td>
                                        <td style="text-align: right;">
                                            ₹ {{ $booking?->advance }}
                                        </td>
                                    </tr>
                                    <tr style="font-size: 14px;">
                                        <td>
                                            Balance
                                        </td>
                                        <td>&nbsp;</td>
                                        <td style="text-align: right;">
                                            ₹ {{ $booking?->balance }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        </td>
        </tr>

        </tbody>
        </table>
        @if ($booking->balance == 0)
            <table style="width:100%; margin:0 auto">
                <tbody>
                    <tr>

                        <td align="left"
                            style="font-size:16px;text-align:left;vertical-align:top;
            font-weight:bold;background-color:#f1f1f1;color:#000000;padding:20px 5px 20px 20px">
                            AMOUNT PAID</td>
                        </td>
                        <td align="left"
                            style="font-size:16px;text-align:right;vertical-align:top;
            font-weight:bold;background-color:#f1f1f1;color:#000000; padding:20px 20px 20px 5px">
                            Rs.{{ $booking?->grand_total_amount }}</td>
                    </tr>

                </tbody>
            </table>
        @endif
        <table>
            <tbody>
                <tr>
                    <td valign="top"
                        style="width:100% !important;background-color:#ffffff;
                  padding: 0 !important;">
                        <img src="https://webomindapps.tech/webo/images/zigzag.png" height="15"
                            style="width: 100%; display: block; background-color:#ffffff;color:#010101"
                            border="0">
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
