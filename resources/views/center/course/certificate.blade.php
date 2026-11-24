<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/favicon.png" type="image/x-icon">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

<!-- tittle -->
<title>ICRQ</title>
<center>
<style>
body{font-family: 'Poppins', sans-serif;}
.signature, .title { 
float:left;
  border-top: 1px solid #000;
  width: 200px; 
  text-align: center;
}
.clearfix {
  overflow: auto;
}
</style>
<div style="width:800px; height:1000px; padding:20px; text-align:center; border: 3px solid #00d0ff">
<div style="width:750px; height:940px; padding:20px; text-align:center;">

<table style="margin-top:20px;float:left">
<tr>
<td><span><img src="{{asset('web_dashboard/images/ehse.png')}}"></span></td>
</tr>
</table>

<table style="margin-top:20px;float:right">
<tr>
<td><span><img src="{{asset('web_dashboard/images/logo.svg')}}"></span></td>
</tr>
</table>
<br><br><br><br><br><br>
       <span style="font-size:35px; font-weight:bold; color: #00d0ff;">CERTIFICATE OF ACHIEVEMENT</span><br/>
       <br><br>
       <span style="font-size:20px"><b>THIS IS TO CERTIFY THAT:</b></span><br/><br/><br/>  
       <span style="font-size:25px"><b>{{ $certificate->student_name }}</b></span><br/>
       <br><br>
       <div style="position:absolute;">
        <img src="{{asset('web_dashboard/images/bg.png')}}" style="margin-left: 200px;">
        </div>
       <span style="font-size:20px"><br/><b>HAS SUCCESSFULLY COMPLEATED THE FOLLOWING:</b></span>
       <br/>
       <span style="font-size:20px"><br/><p>{{ $certificate->course_name }}</p></span>
 
       
       <div class="clearfix">
       <table style="margin-top:20px; float:left; line-height: 50px;">
                 <tr class="content text-left"><span style="text-align: left!important;"></span>
                    <td>Date of Awarded</td>
                    <td style="padding-left: 15px;">: {{Carbon\Carbon::parse($certificate->date_of_awarded)->format('d-m-Y')}}</td>
                 </tr>
          
                 <tr class="content text-left"><span style="text-align: left!important;"></span>
                    <td>Certificate No</td>
                    <td style="padding-left: 15px;">:  {{ $certificate->certificate_id }}</td>
                 </tr>

                 <tr class="content text-left"> <span style="text-align: left!important;"></span>
                  <td>Training Partner</td>
                  <td style="padding-left: 15px;">: {{ $certificate->center_name }}</td>
                 </tr>
          
             </table>
           </div>
           <br/>
       
<table style="margin-top:40px;float:left">
<tr>
<td style="text-align: left;">
  <img src="{{asset('web_dashboard/images/cpd.png')}}">
  <p style="font-size: 10px; margin-top: 15px;"></p>
</td>

</tr>
</table>
<br/><br/>
<table style="margin-top:40px;float:right">
<tr>
<td><span><b>Signed on behalf of ICRQ</b></td>
</tr>
<tr>
<td style="width:200px;float:right;border:0;border-bottom:1px solid #ccc;"></td>
</tr>
<tr>
<td style="text-align:center"><span><b>Signature</b></td>
</tr>
</table>
</div>
</div>
</center>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script>
AOS.init();
</script>
</html>