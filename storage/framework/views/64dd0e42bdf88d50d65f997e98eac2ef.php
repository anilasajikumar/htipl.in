<?php $__env->startSection('style'); ?>
<style type="text/css">
.slick-slide {
    margin: 0px 20px;
}

.slick-slide img {
    width: 100%;
}

.slick-slider
{
    position: relative;
    display: block;
    box-sizing: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
            user-select: none;
    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
        touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
}

.slick-list
{
    position: relative;
    display: block;
    overflow: hidden;
    margin: 0;
    padding: 0;
}
.slick-list:focus
{
    outline: none;
}
.slick-list.dragging
{
    cursor: pointer;
    cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list
{
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track
{
    position: relative;
    top: 0;
    left: 0;
    display: block;
}
.slick-track:before,
.slick-track:after
{
    display: table;
    content: '';
}
.slick-track:after
{
    clear: both;
}
.slick-loading .slick-track
{
    visibility: hidden;
}

.slick-slide
{
    display: none;
    float: left;
    height: 100%;
    min-height: 1px;
}
[dir='rtl'] .slick-slide
{
    float: right;
}
.slick-slide img
{
    display: block;
}
.slick-slide.slick-loading img
{
    display: none;
}
.slick-slide.dragging img
{
    pointer-events: none;
}
.slick-initialized .slick-slide
{
    display: block;
}
.slick-loading .slick-slide
{
    visibility: hidden;
}
.slick-vertical .slick-slide
{
    display: block;
    height: auto;
    border: 1px solid transparent;
}
.slick-arrow.slick-hidden {
    display: none;
}


</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!--<header style="background-image:url('<?php echo e(asset('web_dashboard/images/Where-To-Study-4.jpg')); ?>');">-->
<!--  <div class="container h-100">-->
<!--    <div class="d-flex h-100 text-center align-items-center">-->
<!--      <div class="vdoverlay w-100 text-white">-->
<!--        <h1 class="display-3">Welcome To HTI Pvt Ltd</h1>-->
<!--        -->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</header>-->

<?php if($hero): ?>
<header style="background-image:url('<?php echo e(asset($hero->background_image)); ?>');">
<?php else: ?>
<header>
<?php endif; ?>

<div class="container h-100">
    <div class="d-flex h-100 text-center align-items-center">
        <div class="vdoverlay w-100 text-white">

            <h1 class="display-3">
                <?php echo e($hero->title ?? 'Welcome To HTI Pvt Ltd'); ?>

            </h1>

            <?php if(!empty($hero->subtitle)): ?>
                <p class="lead mb-0"><?php echo $hero->subtitle; ?></p>
            <?php endif; ?>

        </div>
    </div>
</div>
</header>

 <!-- About Icrq --> 
        
<section class="About_area">
  <div class="container">     
  <div class="row Why_card">
    <div class="col-md-12 col-xl-6 col-lg-6" data-aos="fade-up">  

       <div class="iii">
      <div class="embed-responsive">
  
  <img class="img-fluid" src="<?php echo e(asset('web_dashboard/images/home_img.jpg')); ?>">
</div>
      </div>

    </div>

    <div class="col-md-12 col-xl-6 col-lg-6" data-aos="fade-up">  
      <div class="About_area_text">
      <h2 class="About_tittle mb-3">ABOUT HTI Pvt Ltd</h2>
      <p class="card-text">HTI Pvt Ltd is a leading Safety Training and consultancy organization which providing Quality Safety Training in Ernakulam. HTIPL is supported by a highly qualified, experienced team with exceptional Safety educational backgrounds and expertise from Oil field, Construction, Engineering, Marine and Consultation.</p>
      
      <button class="btn Second_btn" type="submit" onclick="window.location='<?php echo e(url('about')); ?>';">Learn More</button>
      </div>
    </div>


  </div>
</div>
</section> 
<!-- End About Icrq --> 

<!-- QUALIFICATIONS --> 
        
 <section class="mt-5 p-3">
  <div class="container">
  <h2 class="text-center">Courses</h2>
  <div class="row mt-5">
  <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="col-xl-3 col-lg-3 col-md-6" data-aos="fade-up">
  <div class="single_courses">
  <div class="thumb">
  <a href="<?php echo e(route('qualifications.details', $category->slug )); ?>">
  <img src="<?php echo e(asset('/storage/'.$category->cover_image)); ?>" class="img-fluid" alt="Responsive image">
  </a>
  </div>
  <div class="courses_info text-center pt-4 pb-4">
  <h5><a href="<?php echo e(route('qualifications.details', $category->slug )); ?>"><?php echo e($category->category_name); ?></a></h5>
  </div>
  </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


  </div>
</div>
</section><br><br><br><br>

<div class="container" style="overflow-x:auto;">
<h2 style="text-align:center !important;">Course Calender</h2>
<table class="table table-bordered mt-4 mb-5">
  <thead style="background-color: #fd7e14;">
    <tr class="text-white text-center">
      <th scope="col">COURSE NAME</th>
      <th scope="col">COURSE STARTING DATE</th>
      <th scope="col">LOCATION</th>
      <th scope="col">EXAM DATE</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $course_calender; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr class="text-center">
      <td class="table-secondary"><?php echo e($data->course_name); ?></td>
      <td class="table-secondary"><?php echo e(\Carbon\Carbon::parse($data->starting_date)->format('j F Y')); ?></td>
      <td class="table-secondary"><?php echo e($data->location); ?></td>
      <td class="table-secondary">
        <?php echo e(\Carbon\Carbon::parse($data->exam_date)->format('j F Y')); ?> &nbsp; <br>
        <a style="text-decoration: none;" class="btn-sm btn-success mt-2" href="<?php echo e(route('apply_now.mail')); ?>">
          <small>Apply Now</small>
        </a>
      </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <tr class="text-center">
      <td class="table-secondary" colspan="4">
        <a style="text-decoration: none;" href="<?php echo e(route('course-calendar')); ?>">View More</a>
      </td>
    </tr>
   
  </tbody>
</table>

</div>

<!-- End QUALIFICATIONS --> 

<section class="mt-5 p-3">
  <div class="container">
  <h2 class="text-center">Corporate Service</h2>
  <div class="row mt-5">
  <?php $__currentLoopData = $corporate_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <div class="col-xl-3 col-lg-3 col-md-6" data-aos="fade-up">
  <div class="single_courses">
  <div class="thumb">
  <a href="<?php echo e(route('corporate-training.details', $category->slug )); ?>">
  <img src="<?php echo e(asset('/storage/'.$category->cover_image)); ?>" class="img-fluid" alt="Responsive image">
  </a>
  </div>
  <div class="courses_info text-center pt-4 pb-4">
  <h5><a href="<?php echo e(route('corporate-training.details', $category->slug )); ?>"><?php echo e($category->category_name); ?></a></h5>
  </div>
  </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


  </div>
</div>
</section><br><br>

<section class="mt-5 p-3">
<div class="container" style="overflow-x:auto;">
    <h2 style="text-align:center !important;">Placement Opportunities</h2>

    <table class="table table-bordered mt-4 mb-5">
        <thead style="background-color: #fd7e14;">
            <tr class="text-white text-center">
                <th scope="col">POST NAME</th>
                <th scope="col">EXPERIENCE</th>
                <th scope="col">COMPANY AND LOCATION</th>
                <th scope="col">LAST DATE TO APPLY</th>
                <th scope="col">SALARY / APPLY</th>
            </tr>
        </thead>

        <tbody>
        <?php $__currentLoopData = $placements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="text-center">
                <td class="table-secondary"><?php echo e($place->post_name); ?></td>
                <td class="table-secondary"><?php echo e($place->experience); ?></td>
                <td class="table-secondary"><?php echo e($place->company); ?></td>
                <td class="table-secondary"><?php echo e($place->last_date_to_apply); ?></td>

                <td class="table-secondary">
                    <?php echo e($place->salary); ?> <br>

                    <a style="text-decoration: none;" 
                       class="btn-sm btn-success mt-2"
                       href="<?php echo e(route('placement.apply', $place->id)); ?>">
                        <small>Apply Now</small>
                    </a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <tr class="text-center">
                <td class="table-secondary" colspan="5">
                    <a style="text-decoration: none;" href="<?php echo e(route('placements.list')); ?>">
                        View More
                    </a>
                </td>
            </tr>

        </tbody>
    </table>
</div>
</section>
<!-- News events --> 
        
 <section class="News_events_area">
  <div class="container">  
    <div class="News_events_tittle">
      <h2 class="mb-5">NEWS AND EVENTS</h2>
  <div class="row News_events_card">
     <?php $__currentLoopData = $news_events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news_event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-6 col-lg-4" data-aos="fade-up">
            <div class="blog-entry">
              <a href="<?php echo e(route('news-events.details',$news_event->slug)); ?>" data-aos="fade-up" class="block-20 d-flex align-items-end" style="background-image: url('<?php echo e(asset('/storage/'.$news_event->image)); ?>'); text-decoration: none;">
                <div class="meta-date text-center p-2">
                  <span class="day"><?php echo e($news_event->type); ?></span>
                </div>
              </a>
              <div class="text border border-top-0 p-4" data-aos="fade-up">
                <h3 class="heading"><a href="<?php echo e(route('news-events.details',$news_event->slug)); ?>"><?php echo e($news_event->title); ?></a></h3>
                <div class="d-flex align-items-center mt-4">
                  <p class="mb-0">
                    <a class="mr-2"><?php echo e(Carbon\Carbon::parse($news_event->date)->format('d M Y')); ?></a>
                  </p>
                </div>
                <p><?php echo Str::limit($news_event->description, 100); ?></p>
                <div class="d-flex align-items-center mt-4">
                  <p class="mb-0"><a style="text-decoration: none;" href="<?php echo e(route('news-events.details',$news_event->slug)); ?>">Read More...</a></p>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
  </div>
</div>
</div>
</section>






 <section class="icrq_center_area">
  <div class="gray-bg"></div>
  <div class="container"> 
   <div class="row">
    <div class="col-md-6" data-aos="fade-up">  
    <h2 class="icrq_center-title">STUDENT ENQUIRY</h2>  
<!--     <p class="icrq_center-text mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p> -->
    </div>
    <div class="col-md-6" data-aos="fade-up">  
    <button class="btn Second_btn" type="submit" onclick="window.location='<?php echo e(route('apply_now.mail')); ?>';">APPLY NOW</button>
    </div>
   </div>
 </div>
</section>


<!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container">
          <div class="row">
               <div class="col-sm-5">
                   <div class="section-title" data-aos="fade-up">
                    <div class="section-title-2">
                      <h2><span>Our</span><br>Students Speaks</h2>
                     <button class="btn Second_btn mt-4" type="submit" onclick="window.location='<?php echo e(url('video-testimonials')); ?>';">Video Testimonials</button>
                    </div>
                   </div>
                 </div>
       <div class="col-sm-7">
        <div class="testimonials-slider swiper-container" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            <?php $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="swiper-slide">
              <div class="testimonial-wrap">
                <div class="testimonial-item">
                  <p>
                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                    <?php echo $testimonial->description; ?>

                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                  </p>
                  <h3><?php echo e($testimonial->title); ?></h3>
                  <h4><?php echo e($testimonial->designation); ?></h4>
                </div>
              </div>
            </div><!-- End testimonial item -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Testimonials Section -->


<div class="container mt-5 mb-3">
  <h2 class="text-center">Our Partners</h2>
   <section class="customer-logos slider mt-2">
    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="slide"><img alt="<?php echo e($client->name); ?>" src="<?php echo e(asset('/storage/'.$client->logo)); ?>" style="height:180px; width:auto; object-fit:contain;"></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </section>
</div>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
$(document).ready(function(){
    $('.customer-logos').slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        dots: false,
        pauseOnHover: false,
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 4
            }
        }, {
            breakpoint: 520,
            settings: {
                slidesToShow: 3
            }
        }]
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.web.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/welcome.blade.php ENDPATH**/ ?>