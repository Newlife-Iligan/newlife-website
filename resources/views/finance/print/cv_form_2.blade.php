<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NewLife Finance Form</title>
    <style>
        .container{
            text-align: center;
            font-family: Arial, serif;
            width: fit-content;
            margin: auto;
            max-width: 700px;
        }
        .mt-20{ margin-top: 20px }
        .mt-40{ margin-top: 40px }
        .f-14{ font-size: 14px; }
        .text-right{ text-align: right; }
        .text-left{ text-align: left; }
        .text-center{ text-align: center; }
        .text-value{
            text-align: left;
            background: rgb(232, 230, 230);
            padding-right: 5px;
            padding-left: 5px;
        }
        .bg-value{ background: rgb(232, 230, 230); }
        .px-5{
            padding-left: 5px;
            padding-right: 5px;
        }
        .text-indent { text-indent: 30px; }
        .bb-1{ border-bottom: 1px solid black; }
        hr{ border-top: 1px solid rgba(200, 200, 200, 0.3); }
        .ar_form{
            margin-top: 30px;
            display: flex;
            justify-content: space-around;
        }
        .m-0{
            margin-bottom: 0;
            margin-top: 0;
        }
        .px-10{
            padding-left: 25px;
            padding-right: 25px;
        }
        .payment-row{
            display: flex;
            align-items: center;
        }
        .payment-col-desc{
            min-width: 500px;
        }
        .payment-col-sep{
            min-width: 30px;
            text-align: center;
        }
        .payment-col-amt{
            max-width: 200px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="cv-form-container">
        @if($data->form_type == 'ar_only' || $data->form_type == 'cv_ar')
            <h3 class="m-0">NEW LIFE CHRISTIAN CENTER (INM), INC.</h3>
            <h4 class="m-0">Iligan City, 9200</h4>
            <p style="text-align: right;">AR No: <span class="bb-1 bg-value p-4" style="font-size: small; padding: 3px;">{{$data->ar_number}}</span></p>
            <strong>ACKNOWLEDGEMENT RECEIPT</strong>
            <div class="text-left text-indent">
                <p><b>I HEREBY ACKNOWLEDGE</b> receipt the amount of <span class="bb-1 bg-value px-5" style="font-size: medium;">{{$data->ar_amount_in_words}} (₱{{number_format($data->ar_amount_in_figures,2)}})</span>
                    only in cash, as payment for <span class="bb-1 bg-value px-5" style="font-size: medium;">{{$data->cv_particular}}</span>.
                </p>
                <p class="m-0" style="text-indent: 0;">
                    This is issued in lieu of the official receipt which I do not possess.
                </p>
                <p class="m-0" style="text-indent: 0;">
                    DONE this <span class="bb-1 bg-value px-5" style="font-size: medium;">{{date_format(\Carbon\Carbon::make($data->ar_date),'F m, Y')}}</span>
                    at Iligan City, Philippines.
                </p>
            </div>
            <div id="ar_form" class="ar_form">
                <div>
                    <div class="text-center bb-1 bg-value px-10">{{\App\Models\Members::find($data->ar_received_by)->fullName}}</div>
                    <div class="text-center f-14">Received By</div>
                </div>
                <div>
                    <div class="text-center bb-1 bg-value px-10">{{\App\Models\Members::find($data->ar_disbursed_by)->fullName}}</div>
                    <div class="text-center f-14">Disbursed By</div>
                </div>
            </div>
        @endif

        @if($data->form_type == 'cv_ar')
            <hr>
        @endif
        @if($data->form_type == 'cv_only' || $data->form_type == 'cv_ar')
            <h3 class="m-0">NEW LIFE CHRISTIAN CENTER (INM), INC.</h3>
            <h4 class="m-0">Iligan City, 9200</h4>
            <p style="text-align: right;">Cash Voucher No: <span class="bg-value p-4" style="font-size: small; padding: 3px;">{{$data?->cv_number ?? "_________" }}</span></p>
            <p style="text-align: right;">Date: <span class="bg-value p-4" style="font-size: small; padding: 3px;">{{$data->cv_date}}</span></p>
            <div>
                <div class="text-left">
                    <p class="m-0">Name: <span class="bg-value px-10">{{\App\Models\Members::find($data->cv_received_by)->fullName}}</span></p>
                    <p class="m-0">Address: <span class=" bg-value px-10">{{$data->cv_address}}</span></p>
                </div>
                <div class="text-left mt-40">
                    <small>In payment of:</small>
                    <div>
                        <div class="payment-row">
                            <div class="text-value payment-col-desc">{{$data->cv_particular}}</div>
                            <div class="payment-col-sep"> --- </div>
                            <div class="text-value payment-col-amt">₱{{number_format($data->cv_amount,2)}}</div>
                        </div>
                        <div class="payment-row">
                            <div class="text-value payment-col-desc">&nbsp;</div>
                            <div class="payment-col-sep"> --- </div>
                            <div class="text-value payment-col-amt">&nbsp;</div>
                        </div>
                        <div style="height: 20px;"></div>
                        <div class="payment-row">
                            <div class="text-right f-14 payment-col-desc">TOTAL:</div>
                            <div class="payment-col-sep"> --- </div>
                            <div class="text-value payment-col-amt">₱{{number_format($data->cv_amount,2)}}</div>
                        </div>
                        <div style="height: 20px;"></div>
                        <div class="payment-row">
                            <div class="text-right f-14 payment-col-desc">Actual Amt:</div>
                            <div class="payment-col-sep"> --- </div>
                            <div class="text-value payment-col-amt">₱</div>
                        </div>
                        <div class="payment-row">
                            <div class="text-right f-14 payment-col-desc">Return Amt:</div>
                            <div class="payment-col-sep"> --- </div>
                            <div class="text-value payment-col-amt">₱</div>
                        </div>
                        <div class="payment-row">
                            <div class="text-right f-14 payment-col-desc">Return Mode:</div>
                            <div class="payment-col-sep"> --- </div>
                            <div class="text-value payment-col-amt">&nbsp;</div>
                        </div>
                    </div>

                    <p><small>Department:</small> <span class="bg-value px-10">{{\App\Models\Ministry::find($data->department)->name}}</span></p>
                </div>
            </div>
            <div id="cv_form" style="margin-top: 30px;">
                <div class="ar_form" style="margin-top: 0;">
                    <div>
                        <div class="text-center bb-1 bg-value px-10">{{\App\Models\Members::find($data->cv_received_by)->fullName}}</div>
                        <div class="text-center f-14">Received By</div>
                    </div>
                    <div>
                        <div class="text-center bb-1 bg-value px-10">{{\App\Models\Members::find($data->cv_disbursed_by)->fullName}}</div>
                        <div class="text-center f-14">Disbursed By</div>
                    </div>
                </div>
                <div style="height: 30px;"></div>
                <div style="display: flex; justify-content: center;">
                    <div>
                        <div class="text-center bb-1 bg-value px-10">{{\App\Models\Members::find($data->cv_approved_by)->fullName}}</div>
                        <div class="text-center f-14">Approved By</div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
</body>
</html>
