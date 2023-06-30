<section class="menu-area">
  <div class="container-xl">
    <div class="row">
      <div class="col">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

          <ul class="mobile-header-buttons">
            <li><a class="mobile-nav-trigger" href="#mobile-primary-nav">Menu<span></span></a></li>
            <!--<li><a class="mobile-search-trigger" href="#mobile-search">Search<span></span></a></li>-->
          </ul>

          <a href="<?php echo site_url(''); ?>" class="navbar-brand" href="#"><img src="<?php echo base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="65"></a>

          <?php include 'menu.php'; ?>

			<form class="inline-form" method="get" style="width: 100%;">
			</form>
			
			
			<!--<div class="instructor-box menu-icon-box">
                <div class="icon">
                    <a href="https://metodochannels.com.br/home" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0; min-width: 100px;">Sobre o Método</a>
                </div>
            </div>-->

          <?php if ($this->session->userdata('admin_login')): ?>
            <div class="instructor-box menu-icon-box">
              <div class="icon">
                <a href="<?php echo site_url('admin'); ?>" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0;"><?php echo site_phrase('administrator'); ?></a>
              </div>
            </div>
          <?php endif; ?>

          <div class="cart-box menu-icon-box" id = "cart_items">
            <?php include 'cart_items.php'; ?>
          </div>
			<!--botoes de login-->
          <span class="signin-box-move-desktop-helper"></span>
		  
          <div class="sign-in-box btn-group">
		  
			<a href="https://metodochannels.com.br/home" style="border: 1px solid transparent; margin: 10px 10px; font-size: 14px; width: 100%; border-radius: 0; min-width: 100px;">Home</a>

            <a href="<?php echo site_url('home/login'); ?>" class="btn btn-sign-in"><?php echo site_phrase('Área do aluno'); ?></a>

            <a href="<?php echo site_url('home/sign_up'); ?>" class="btn btn-sign-up"><?php echo site_phrase('Cadastre-se'); ?></a>

          </div> <!--  sign-in-box end -->
        </nav>
      </div>
    </div>
  </div>
</section>
