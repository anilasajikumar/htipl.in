<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>ICRQ</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #000;
/*        box-shadow: 0 0 10px rgba(0, 0, 0, .15)*/;
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
/*    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }*/
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 30px;
    }
    
    .invoice-box table tr.heading td {
/*        border-bottom: 1px solid #000;*/
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #000;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
/*        border-top: 2px solid #000;*/
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    .refno{
    text-decoration: none;
    list-style: none;
    padding: 0px;
    }
    .refno li{
    border-bottom: 1px solid #000;  
    line-height: 38px;
    }
    table{
        border-collapse: collapse;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{public_path('admin_dashboard/assets/img/logo.png')}}" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td style="text-align: right;">
                                {{-- {{Auth::guard('center')->user()->study_center_name}}<br>
                               {!! Auth::guard('center')->user()->study_center_address !!}<br>
                              {{Auth::guard('center')->user()->study_center_email}} <br>
                                {{Auth::guard('center')->user()->study_center_mobile}} --}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                               <h1 style="font-weight: 900;"> PROFORMA INVOICE</h1>
                                <p style="border: 1px solid #000; padding: 5px; width: 400px; padding: 15px; border-radius: 15px;">{{Auth::guard('center')->user()->study_center_name}}<br>
                               {!! Auth::guard('center')->user()->study_center_address !!}<br>
                              {{Auth::guard('center')->user()->study_center_email}} <br>
                                {{Auth::guard('center')->user()->study_center_mobile}}</p>
                            </td>
                            
                            <td style="text-align: left;">
        
                                <ul class="refno">
                                <!-- <li>Invoice No.1413</li> -->
                                <li>Date. {{date("d-m-Y H:i:s", strtotime($data->created_at))}}</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            

            <table border="1" style="line-height: 35px;">
            <tr class="heading" style="border:1px solid #000;">
                <td style="font-weight: 900;">
                    Exam
                </td>
                
                <td style="font-weight: 900;">
                    Fee
                </td>
                <td style="font-weight: 900;">
                    Students
                </td>
                <td style="font-weight: 900;">
                    TOTAL Amount
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    {{$data->exam_name}}
                </td>
                
                <td>
                    {{$data->exam_fee}}
                </td>

                <td>
                    {{$data->student_exams_count}}
                </td>

                <td>
                   <b style="font-weight: 900;"> ₹{{$data->exam_fee * $data->student_exams_count}}</b>
                </td>
            </tr>

            
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                
                <td>
                   <b style="font-weight: 900;"> ₹{{$data->exam_fee * $data->student_exams_count}}</b>
                </td>
            </tr>
            </table>
        </table>
    </div>
</body>
</html>
