<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NewLife Finance Form</title>
    <link rel="stylesheet" href="{{asset('css/finance-css.css')}}">
</head>
<body>
    <div class="container">
        <div class="cv-form-container">
            @if($data->form_type == 'ar_only' || $data->form_type == 'cv_ar')
                <h3>NEW LIFE CHRISTIAN CENTER (INM), INC.</h3>
                <h4>Iligan City, 9200</h4>
                <div id="ar_form">
                    <table>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="f-14 text-right">AR No:</td>
                            <td class="text-value">{{$data->ar_number}}</td>
                        </tr>
                        <tr><td height="20px"></td></tr>
                        <tr>
                            <td class="text-center" colspan="6"><strong>ACKNOWLEDGEMENT RECEIPT</strong></td>
                        </tr>
                        <tr><td height="20px"></td></tr>
                        <tr>
                            <td class="text-right" colspan="4">I HEREBY ACKNOWLEDGE receipt the amount of </td>
                            <td class="text-center bb-1 bg-value" colspan="2">₱{{number_format($data->ar_amount_in_figures,2)}}</td>
                        </tr>
                        <tr>
                            <td class="text-left" colspan="2">only in cash, as payment for</td>
                            <td class="bg-value bb-1 text-center" colspan="4">{{$data->cv_particular}}</td>
                        </tr>
                        <tr><td height="20px"></td></tr>
                        <tr>
                            <td class="text-left" colspan="6">This is issued in lieu of the official receipt which I do not possess.</td>
                        </tr>
                        <tr>
                            <td class="text-left">DONE this</td>
                            <td class="bg-value text-center bb-1" colspan="2">{{date_format(\Carbon\Carbon::make($data->ar_date),'F m, Y')}}</td>
                            <td class="text-left" colspan="2">at Iligan City, Philippines.</td>
                        </tr>
                        <tr>
                            <td height="30px"></td>
                        </tr>
                        <tr>
                            <td class="text-center bb-1 bg-value" colspan="2">{{\App\Models\Members::find($data->ar_received_by)->fullName}}</td>
                            <td colspan="2"></td>
                            <td class="text-center bb-1 bg-value" colspan="2">{{\App\Models\Members::find($data->ar_disbursed_by)->fullName}}</td>
                        </tr>
                        <tr>
                            <td class="text-center f-14" colspan="2">Received By</td>
                            <td colspan="2"></td>
                            <td class="text-center f-14" colspan="2">Disbursed By</td>
                        </tr>
                    </table>
                </div>
            @endif

            @if($data->form_type == 'cv_ar')
                <hr>
            @endif
            @if($data->form_type == 'cv_only' || $data->form_type == 'cv_ar')
                <h3>NEW LIFE CHRISTIAN CENTER (INM), INC.</h3>
                <h4>Iligan City, 9200</h4>
                <div id="cv_form">
                    <table>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right f-14" colspan="2">Cash Voucher No:</td>
                            <td class="text-value">{{$data->cv_number}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right f-14">Date:</td>
                            <td class="text-value">{{$data->cv_date}}</td>
                        </tr>
                        <tr>
                            <td height="30px"></td>
                        </tr>
                        <tr>
                            <td class="text-left f-14">Name:</td>
                            <td class="text-value" colspan="3">{{\App\Models\Members::find($data->cv_received_by)->fullName}}</td>
                        </tr>
                        <tr>
                            <td class="text-left f-14">Address:</td>
                            <td class="text-value" colspan="3">{{$data->cv_address}}</td>
                        </tr>

                        <tr>
                            <td height="30px"></td>
                        </tr>

                        <tr>
                            <td class="text-left f-14">In payment of:</td>
                        </tr>
                        <tr>
                            <td class="text-value" colspan="4">{{$data->cv_particular}}</td>
                            <td> --- </td>
                            <td class="text-value">₱{{number_format($data->cv_amount,2)}}</td>
                        </tr>
                        <tr>
                            <td class="text-value" colspan="4"></td>
                            <td> --- </td>
                            <td class="text-value"></td>
                        </tr>
                        <tr>
                            <td height="20px"></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right f-14">TOTAL:</td>
                            <td> --- </td>
                            <td class="text-value">₱{{number_format($data->cv_amount,2)}}</td>
                        </tr>
                        <tr>
                            <td height="20px"></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right f-14">Actual Amt:</td>
                            <td> --- </td>
                            <td class="text-value">₱{{number_format($data->cv_amount_actual,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-right f-14">Return Amt:</td>
                            <td> --- </td>
                            <td class="text-value">₱{{number_format($data->cv_amount_returned,2)}}</td>
                        </tr>
                        <tr>
                            <td height="20px"></td>
                        </tr>
                        <tr>
                            <td class="text-left f-14">Department:</td>
                            <td class="text-value" colspan="2">{{\App\Models\Ministry::find($data->department)->name}}</td>
                        </tr>
                        <tr>
                            <td height="30px"></td>
                        </tr>
                        <tr>
                            <td class="text-center bb-1 bg-value" colspan="2">{{\App\Models\Members::find($data->cv_received_by)->fullName}}</td>
                            <td colspan="2"></td>
                            <td class="text-center bb-1 bg-value" colspan="2">{{\App\Models\Members::find($data->cv_disbursed_by)->fullName}}</td>
                        </tr>
                        <tr>
                            <td class="text-center f-14" colspan="2">Received By</td>
                            <td colspan="2"></td>
                            <td class="text-center f-14" colspan="2">Disbursed By</td>
                        </tr>
                        <tr>
                            <td height="30px"></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-center bb-1 bg-value" colspan="2">{{\App\Models\Members::find($data->cv_approved_by)->fullName}}</td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td class="text-center f-14" colspan="2">Approved By</td>
                        </tr>
                    </table>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
