<? include './template/template_header.tpl'; ?>
<style>
.btn-primary {
  color: #222430;
  background-color: #a3ff12;
  border-radius: 0 0 0.56042vh 0.56042vh;
}
.btn-primary:hover {
  color: #222430;
  background-color: #b7ff45;
  border-radius: 0 0 0.56042vh 0.56042vh;
}
</style>
		<!-- Content
		================================================== -->
		<main class="site-content text-center" id="wrapper">
<div class="container container--large">			
       <div class="content site-wrapper">
         <div class="page-content">
						<div class="team-selection__slide-heading">
							<div class="team-selection__slide-logo">
								<img src="/assets_general/img/logo.png" srcset="/assets_general/img/logo.png 2x" alt="">
							</div>
						</div>
						<?php if (empty($get_shops)): ?>
		<h6>Вы еще не создали ни одного магазинаz</h6>
<?php else: ?>
           <div class="row">
<?php foreach ($get_shops as $key => $value): ?>
              <div class="col">
                <div class="card radius-10">
                   <div class="card-body">
                     <div class="d-flex align-items-center gap-2">
                       <div class="fs-5"><ion-icon name="radio-button-on-outline"></ion-icon></div>
                       <div><p class="mb-0"><?=$value['domain']?></p></div><br>
					    <div class="fs-5 ms-auto"><p class="mb-0" style="font-size:11px;font-weight: 800;color: #a3ff12;"><? echo $value['status'];?></p></div>
                     </div>
					 <div class="d-flex align-items-center gap-2">
                       <div class="fs-5"><ion-icon name="time-outline"></ion-icon></div>
                       <div><p class="mb-0">Активен до:</p></div><br>
					    <div class="fs-5 ms-auto"><p class="mb-0" style="font-size:11px;font-weight: 800;color: #a3ff12;"><?php if ($value['date'] < date("Y-m-d H:i:s")): else: endif; ?><?=date('d.m.Y H:i',strtotime($value['date']))?></p></div>
                     </div>
					 
                   </div>

				
				   <a href="/shops/settings/<?=$value['domain']?>/" class="btn btn-primary" />Управление магазином</a>
				
				
                  </div>
               </div>
<?php endforeach; ?>
<?php endif; ?>
          </div>
         </div>
		 </div>
		 			<div class="video-full-bg">
				<!-- Video Highlight -->
				<div class="video-full-bg__highlight"></div>
				<!-- Video Highlight / End -->
			
				<!-- Video Clip -->
				<video poster="/assets_general/img/bg-texture-05.jpg" class="video-full-bg__clip video-full-bg__clip--black-white" playsinline autoplay muted loop>
					<source src="/assets_general/video/capella5.webm" type="video/webm">
					<source src="/assets_general/video/capella5.mp4" type="video/mp4">
				</video>
				<!-- Video Clip / End -->
			
				<!-- Video Decoration -->
				<div class="video-full-bg__pattern"></div>
				<!-- Video Decoration / End -->
			
			</div>
			</div>
		</main>

		<!-- Overlay -->
		<div class="site-overlay"></div>
		<!-- Overlay / End -->

		
		<!-- Menu Panel / End -->
<? include './template/template_footer.tpl'; ?>