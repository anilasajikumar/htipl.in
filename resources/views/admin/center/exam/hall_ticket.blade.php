<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
/*        box-shadow: 0 0 10px rgba(0, 0, 0, .15);*/
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
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }


    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        border-bottom: 2px solid #000;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 10px;
    }
    
/*    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }*/
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(1) {
        border-top: 2px solid #000;
        font-weight: bold;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #000;
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
                                <img src="{{asset('web_dashboard/images/logo.svg')}}" style="width:100%; max-width:300px;">
                            </td>
                            
                            <td>
                            	{{ $data->study_center_name }} <br>
                                 {{ $data->study_center_address }}
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
                                <b style="font-size: 20px; font-weight: 900;">HALLTICKET</b><br>
                                {{ $data->name }}<br>
                                {{ $data->address }}
                            </td>
                            
                            <td>
                                {{ $data->study_center_mobile }}<br>
                               {{ $data->study_center_email }} <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <!-- <tr class="heading">
                <td>
                    Date of Awarded
                </td>
                
                <td>
                    01/01/2020
                </td>
            </tr> -->
            
            <tr class="details">
                <td>
                    Date of Examination
                </td>
                
                <td>
                    {{ Carbon\Carbon::parse($data->date)->format('d-m-Y') }}
                </td>
            </tr>

            <tr class="details">
                <td>
                    Register No
                </td>
                
                <td>
                    {{ $data->register_number }}
                </td>
            </tr>

            <tr class="details">
                <td>
                    Exam
                </td>
                
                <td>
                    {{$data->exam_name}}
                </td>
            </tr>

            <tr class="details">
                <td>
                    Exam Center
                </td>
                
                <td style="width: 50%;">
                    {{ $data->center_address }}
                </td>
            </tr>
            
            <tr class="heading">
                <td>
                    UNIT
                </td>
                
                <td style="text-align: left;">
                    UNIT NAME
                </td>
            </tr>
            @foreach($exam_units as $units)
            <tr class="item">
                <td>
                    {{ $units->unit_code }}
                </td>
                
                <td style="text-align: left;">
                    {{ $units->unit_name }}
                </td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td></td>
                <td></td>
            </tr>
        </table>

        <p style="border: 2px solid #000; padding: 5px;">You should be present in the Examination Hall at least halfan-hour before the exam and you will not be allowed to leave the Examination Hall until
the exam is over. Candidates arriving after commencement of the examination will not
be permitted to enter the Examination Hall.</p>
    </div>
</body>
</html>
