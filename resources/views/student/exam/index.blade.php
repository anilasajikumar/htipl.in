@extends('layouts.student.layout')
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>EXAM</h1>
</div>
    <div class="quizContainer container-fluid well well-lg">
        <div id="quiz1" class="text-center">
			<h3>{{ @$exam_details->exam_name }}</h3>
            <center><a href="#" class="pop" data-dismiss="modal" aria-label="close"><img class="img-responsive" id="queimage" height="160" width="160"></a></center>
        <div class="countdown"></div>
        <br>
		</div>
        <hr>
        <div class="question"></div>
        <hr>
        <ul class="choiceList"></ul>
        <div class="quizMessage"></div>
        <div class="result"></div>
		<button class="btn btn-dark float-left preButton">Previous</button> 
        <button class="btn btn-dark float-right nextButton">Next</button>
        <button class="btn btn-dark float-right nextButton finishButton hidden">Finish</button>
    </div>
</section>
</div>
<div class="modal" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" style="width: 100%;" >
      </div>
    </div>
  </div>
</div>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<style type="text/css">
 h1 {
    font-family:'Nunito';
    text-align: center;
}
ul {
    list-style: none;
}
li {
    font-family:'Nunito';
}
input[type=radio] {
    border: 0px;
    width: 20px;
    height: 2em;
}
p {
    font-family:'Gabriola', serif;
}
/* Quiz Classes */
 .quizContainer {
    background-color: white;
    border-radius: 6px;
    width: 75%;
    margin: auto;
    padding-top: 5px;
    /*-moz-box-shadow: 10px 10px 5px #888;
    -webkit-box-shadow: 10px 10px 5px #888;
    box-shadow: 10px 10px 5px #888;*/
    position: relative;
}
.quizcontainer #quiz1
{
text-shadow:1px 1px 2px orange;
font-family:"Georgia", Arial, sans-serif;
}

.question {
    font-family:'Century', serif;
    font-size: 1.5em;
    font-weight:bold;
    width: 100%;
    height: auto;
    margin: auto;
    border-radius: 6px;
    background-color: #dce4ec;
    text-align: center;
}
.quizMessage {
    background-color: #fbfbfb;
    border-radius: 6px;
    width: 20%;
    margin: auto;
    text-align: center;
    padding: 5px;
    font-size:20px;
    font-weight:bold;
    font-family:'Gabriola', serif;
    color: red;
    position:absolute;
    top:80%;
    left:40%;
}
.choiceList {
    font-family: 'Arial', serif;
    color: #2861a0;
    font-size:15px;
    font-weight:bold;
}
.result {
    width: 40%;
    height: auto;
    border-radius: 6px;
    background-color: linen;
    margin: auto;
    color:green;
    text-align: center;
    font-size:25px;
    font-family:'Verdana', serif;
    font-weight:bold;
    position:absolute;
    top:80%;
    left:30%;
}
.countdown {
    font-size: 20px;font-weight: bold;color: red;float: right;display: block;position: absolute;right: 24px;
}
.hidden
{
    display: none;
    visibility: hidden;
}
/* End of Quiz Classes */
</style>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script type="text/javascript">
var data = {!! $data !!};
var questions= new Array();
jQuery(data).each(function(i,item){
    questions.push(item);
});

var currentQuestion = 0;
var viewingAns = 0;
var correctAnswers = 0;
var quizOver = false;
var iSelectedAnswer = {};
    var c=180;
    var t;
$(document).ready(function () 
{
var totalTime = {{ $exam_details->total_time }};
var examEndTime= {{ strtotime($exam_details->total_time."minutes") }} ; 
var currentTime = {{ strtotime('now') }};; 
var diffTime = examEndTime - currentTime;
var duration = moment.duration(diffTime*1000, 'milliseconds');
var interval = 1000;
var examEnded = false;

var stopExam = function (){
    clearTimeout(examTimer);
    $('.quizContainer').html('<h2>Exam Over</h2>');
    var timeTook = $('.countdown').text();
  $.ajax({
    url: "exam/answers",
    type: 'Post',
    data: {
            "data": iSelectedAnswer,
            "time": timeTook,
            "_token": "{{ csrf_token() }}", 
        },
    success: function (response)
        {
            swal("Done!", response.message, "success");
            window.location.href = "{{ route('student-result') }}"; 
        },
        error: function(xhr) {
         console.log(xhr.responseText);
       }
  });
    // Call to save details
}

var examTimer = setInterval(function(){
  duration = moment.duration(duration - interval, 'milliseconds');
  // console.log(duration._milliseconds);
  var durationText = (duration.hours() < 10 ? '0'+duration.hours()  : duration.hours())  + ":" + (duration.minutes() < 10 ? '0' + duration.minutes(): duration.minutes()  )+ ":" + (duration.seconds() < 10? '0'+duration.seconds(): duration.seconds());
    $('.countdown').text(durationText)
    if(duration._milliseconds <= 0){
        stopExam();
    }
    
}, interval);




    // Display the first question
    displayCurrentQuestion();
    $(this).find(".quizMessage").hide();
    $(this).find(".preButton").attr('disabled', 'disabled');

    
    $(this).find(".preButton").on("click", function () 
    {       
        
        if (!quizOver) 
        {
            if(currentQuestion == 0) { return false; }
    
            if(currentQuestion == 1) {
              $(".preButton").attr('disabled', 'disabled');
            }

                var val = $("input[type='radio']:checked").val();
                if (val == questions[currentQuestion].correctAnswer) 
                {
                    correctAnswers++;
                }
                iSelectedAnswer[questions[currentQuestion].id] = val;

            
                currentQuestion--; // Since we have already displayed the first question on DOM ready
                if (currentQuestion < questions.length) 
                {
                    displayCurrentQuestion();
                    
                }                   
        } else {
            if(viewingAns == 3) { return false; }
            currentQuestion = 0; viewingAns = 3;
            viewResults();      
        }
    });

    
    // On clicking next, display the next question
    $(this).find(".nextButton").on("click", function () 
    {
        if (!quizOver) 
        {
            
            var val = $("input[type='radio']:checked").val();

            // var arr = {};
            // arr[questions[currentQuestion].id] =  val;
            // console.log(arr);


            // if (val == undefined) 
            // {
            //     $(document).find(".quizMessage").text("Please select an answer");
            //     $(document).find(".quizMessage").show();
            // } 
            // else 
            // {
                // TODO: Remove any message -> not sure if this is efficient to call this each time....
                // $(document).find(".quizMessage").hide();
                if (val == questions[currentQuestion].correctAnswer) 
                {
                    correctAnswers++;
                }
                iSelectedAnswer[questions[currentQuestion].id] = val;
                
                currentQuestion++; // Since we have already displayed the first question on DOM ready
                if(currentQuestion >= 1) {
                      $('.preButton').prop("disabled", false);
                }
                if (currentQuestion < questions.length) 
                {
                    displayCurrentQuestion();

                if (currentQuestion+1 == questions.length) 
                {
                    $(".nextButton").addClass('hidden');
                    $(".finishButton").removeClass('hidden');
                } 
                } 
                else 
                {
  var timeTook = $('.countdown').text();
  $.ajax({
    url: "exam/answers",
    type: 'Post',
    data: {
            "data": iSelectedAnswer,
            "time": timeTook,
            "_token": "{{ csrf_token() }}", 
        },
    success: function (response)
        {
             swal("Done!", response.message, "success");
            window.location.href = "{{ route('student-result') }}"; 
        },
        error: function(xhr) {
         console.log(xhr.responseText);
       }
  });
                    // displayScore();
                    // $('#iTimeShow').html('Quiz Time Completed!');
                    // $('#timer').html("You scored: " + correctAnswers + " out of: " + questions.length);
                    // c=185;
                    // $(document).find(".preButton").text("View Answer");
                    // $(document).find(".nextButton").text("Play Again?");
                    // quizOver = true;
                    // return false;
                    
                }
            // }
                    
        }   
        else 
        { // quiz is over and clicked the next button (which now displays 'Play Again?'
            quizOver = false; $('#iTimeShow').html('Time Remaining:'); iSelectedAnswer = {};
            // console.log(iSelectedAnswer);
            $(document).find(".nextButton").text("Next Question");
            $(document).find(".preButton").text("Previous Question");
             $(".preButton").attr('disabled', 'disabled');
            resetQuiz();
            viewingAns = 1;
            displayCurrentQuestion();
            hideScore();
        }
    });
});


    
// This displays the current question AND the choices
function displayCurrentQuestion() 
{

    var n = questions.length;
    for ( i = 0 ; i < n; i++) {
    var question = questions[currentQuestion].question;
    var questionClass = $(document).find(".quizContainer > .question");
    var choiceList = $(document).find(".quizContainer > .choiceList");
    // var queimage = $(document).find(".quizcontainer > .queimage");
    var numChoices = 4;
    // Set the questionClass text to the current question
    $(questionClass).text(question);
    // view image
    var image = questions[currentQuestion].image;
    var assetBaseUrl = "{{ asset('storage') }}";
    var src = assetBaseUrl+'/'+image;
    if(questions[currentQuestion].image == null){
    $('#queimage').addClass('hidden');
    }
    if(questions[currentQuestion].image != null){
    $('#queimage').removeClass('hidden');
    $('#queimage').attr("src", src);
    }
    // console.log(src);
    // Remove all current <li> elements (if any)
    $(choiceList).find("li").remove();
    var choice;
    
    
        choiceA = questions[currentQuestion].option_a;
        choiceB = questions[currentQuestion].option_b;
        choiceC = questions[currentQuestion].option_c;
        choiceD = questions[currentQuestion].option_d;
       
            // $('<li><input type="radio" class="radio-inline" value="A" name="dynradio" />' +  ' ' + choiceA  + '</li><li><input type="radio" class="radio-inline" value="B" name="dynradio" />' +  ' ' + choiceB  + '</li><li><input type="radio" class="radio-inline" value="C" name="dynradio" />' +  ' ' + choiceC  + '</li><li><input type="radio" class="radio-inline" value="D" name="dynradio" />' +  ' ' + choiceD  + '</li>').appendTo(choiceList);

            if(iSelectedAnswer[questions[currentQuestion].id] == 'A') {
            $('<li><input type="radio" class="radio-inline" checked="checked" value="A" name="dynradio" />' +  ' ' + choiceA  + '</li><li><input type="radio" class="radio-inline" value="B" name="dynradio" />' +  ' ' + choiceB  + '</li><li><input type="radio" class="radio-inline" value="C" name="dynradio" />' +  ' ' + choiceC  + '</li><li><input type="radio" class="radio-inline" value="D" name="dynradio" />' +  ' ' + choiceD  + '</li>').appendTo(choiceList);
        } else if(iSelectedAnswer[questions[currentQuestion].id] == 'B') {
            $('<li><input type="radio" class="radio-inline" value="A" name="dynradio" />' +  ' ' + choiceA  + '</li><li><input type="radio" class="radio-inline" checked="checked" value="B" name="dynradio" />' +  ' ' + choiceB  + '</li><li><input type="radio" class="radio-inline" value="C" name="dynradio" />' +  ' ' + choiceC  + '</li><li><input type="radio" class="radio-inline" value="D" name="dynradio" />' +  ' ' + choiceD  + '</li>').appendTo(choiceList);
        }
        else if(iSelectedAnswer[questions[currentQuestion].id] == 'C') {
            $('<li><input type="radio" class="radio-inline" value="A" name="dynradio" />' +  ' ' + choiceA  + '</li><li><input type="radio" class="radio-inline" value="B" name="dynradio" />' +  ' ' + choiceB  + '</li><li><input type="radio" class="radio-inline" checked="checked" value="C" name="dynradio" />' +  ' ' + choiceC  + '</li><li><input type="radio" class="radio-inline" value="D" name="dynradio" />' +  ' ' + choiceD  + '</li>').appendTo(choiceList);
        }
        else if(iSelectedAnswer[questions[currentQuestion].id] == 'D') {
            $('<li><input type="radio" class="radio-inline" value="A" name="dynradio" />' +  ' ' + choiceA  + '</li><li><input type="radio" class="radio-inline" value="B" name="dynradio" />' +  ' ' + choiceB  + '</li><li><input type="radio" class="radio-inline" value="C" name="dynradio" />' +  ' ' + choiceC  + '</li><li><input type="radio" class="radio-inline" checked="checked" value="D" name="dynradio" />' +  ' ' + choiceD  + '</li>').appendTo(choiceList);
        }
        else
        {
            $('<li><input type="radio" class="radio-inline" value="A" name="dynradio" />' +  ' ' + choiceA  + '</li><li><input type="radio" class="radio-inline" value="B" name="dynradio" />' +  ' ' + choiceB  + '</li><li><input type="radio" class="radio-inline" value="C" name="dynradio" />' +  ' ' + choiceC  + '</li><li><input type="radio" class="radio-inline" value="D" name="dynradio" />' +  ' ' + choiceD  + '</li>').appendTo(choiceList);
        }
    
}
}

function hideScore() 
{
    $(document).find(".result").hide();
}

$(function() {
        $('.pop').on('click', function() {
            $('.imagepreview').attr('src', $(this).find('img').attr('src'));
            $('#imagemodal').modal('show');   
        });     
});

</script>
@endsection