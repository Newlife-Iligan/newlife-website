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
        td { width: 120px; }
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
        .mw-400{ min-width: 500px; }
        .mw-100{
            min-width: 30px;
            text-align: center;
        }
        .mw-150{ max-width: 200px; }

        table, td {
            border: 1px solid #000000;
            text-align: left;
        }

        th {
            border: 1px solid #000000;
            background: #e6e6e6;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{asset('images/nl-iligan.png')}}" width="100">
        <div class="text-center" style="min-width: 700px;">
            <h3>PURCHASE APPROVAL REQUEST</h3>
            <div class="text-left">
                <div>
                    <span>{{\Carbon\Carbon::make($data->date)->format('M d, Y')}}</span>
                    <p style="margin-bottom: 0;"><strong>PS. MIGUEL JOVEN T. PERFECTO</strong></p>
                    <p style="margin-top: 0;">Lead Pastor, NL Iligan</p>
                </div>

                <div>
                    <p style="text-indent: 50px; margin-bottom: 0;">Thru: <strong>AIREEN BABE L. MONTE</strong></p>
                    <p style="text-indent: 93px; margin-top: 0;">Admin, NLIligan</p>
                    <p></p>
                    <p style="text-indent: 93px; margin-bottom: 0;"><strong>JOY MAE C. GABION</strong></p>
                    <p style="text-indent: 93px; margin-top: 0;">Finance, NLIligan</p>
                </div>
            </div>

            <div class="text-left">
                <p>Dear Ps. Miguel,</p>
                <p>Greetings!</p>
                <p>I would like to request your approval to purchase the following items:</p>
                <table>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                    <tbody>

                        @foreach($data->items as $item)
                            <tr>
                                <td>{{$item["item_name"]}}</td>
                                <td style="text-align: center;">{{$item["quantity"]}}</td>
                                <td style="text-align: right;">₱{{$item["unit_price"]}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p>The following items are necessary for the <strong>{{$data->type}} {{$data->reason}}</strong>. </p>
                <p>If you have questions pertaining to the listed items, please let me know. The items need to be purchased on <strong>{{\Carbon\Carbon::make($data->date_required)->format('M d, Y')}}</strong>. </p>
                <p>Hoping for your approval of this request. Thank you very much. </p>
                <p></p>
                <p>Sincerely,</p>
                <p></p>
                <p style="margin-bottom: 5px;"><i><strong>{{\App\Models\Members::find($data->head_id)->fullName}}</strong></i></p>
                <p style="margin-bottom: 5px; margin-top: 0"><i>{{\App\Models\Ministry::find($data->department_id)->name}} | {{$data->department_position}}</i></p>
                <p style="margin-top: 0;"><strong>New Life Iligan</strong></p>
                <div class="mt-40" style="margin-bottom: 35px;">
                    <span> Endorsed by:</span><span style="margin-left: 200px">Recommending Approval:</span>
                </div>
                <p style="margin-bottom: 0px;"><span><strong>AIREEN BABE L. MONTE</strong></span> <span style="margin-left: 100px"><strong>JOY MAE C. GABION</strong></span></p>
                <p style="margin-top: 0px;"><span>Admin, NL Iligan</span><span style="margin-left: 180px">Finance, NL Iligan</span></p>
                <p>Noted by:</p>
                <p style="margin-top: 35px; margin-bottom: 0"><strong>PS. MIGUEL JOVEN T. PERFECTO</strong></p>
                <p style="margin-top: 0px;">Lead Pastor, NL Iligan</p>
            </div>
        </div>
    </div>
</body>
</html>
