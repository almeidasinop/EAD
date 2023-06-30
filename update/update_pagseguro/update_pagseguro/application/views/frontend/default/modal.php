<?php
		$paypal_info = json_decode(get_settings('paypal'), true);
		$stripe_info = json_decode(get_settings('stripe_keys'), true);
        $pagseguro_info = json_decode(get_settings('pagseguro'), true);
		if ($paypal_info[0]['active'] == 0) {
				$paypal_status = 'disabled';
		}else {
				$paypal_status = '';
		}
		if ($stripe_info[0]['active'] == 0) {
				$stripe_status = 'disabled';
		}else {
				$stripe_status = '';
		}
		if ($pagseguro_info[0]['active'] == 0) {
				$pagseguro_status = 'disabled';
		}else {
				$pagseguro_status = '';
		}
 ?>
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
				<div class="modal-content payment-in-modal">
						<div class="modal-header">
								<h5 class="modal-title"><?php echo get_phrase('checkout'); ?>!</h5>
								<button type="button" class="close" data-dismiss="modal">
										<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
                            <div align="center"><?php echo get_phrase('payment_mode'); ?><br></div>
								<div class="row">
                                    
                                    <?php if ($paypal_status != "disabled") { ?>
										<div class="container">
												<form action="<?php echo site_url('home/paypal_checkout'); ?>" method="post">
														<input type="hidden" class = "total_price_of_checking_out" name="total_price_of_checking_out" value="">
														<button type="submit" class="btn btn-link"><img class="img-thumbnail" title="Pagar com Paypal" src="<?php echo base_url('assets/payment/paypal.png'); ?>"></button>
												</form>
										</div>
                                    <?php } ?>
                                    
                                    <?php if ($stripe_status != "disabled") { ?>
										<div class="container">
												<form action="<?php echo site_url('home/stripe_checkout'); ?>" method="post">
														<input type="hidden" class = "total_price_of_checking_out" name="total_price_of_checking_out" value="">
														<button type="submit" class="btn btn-link"><img class="img-thumbnail" title="Pagar com Stripe" src="<?php echo base_url('assets/payment/stripe.png'); ?>"></button>
												</form>
										</div>
                                      <?php } ?>
                                    
                                    <?php if ($pagseguro_status != "disabled") { ?>
										<div class="container">
												<form action="<?php echo site_url('home/pagseguro_checkout'); ?>" method="post">
														<input type="hidden" class = "total_price_of_checking_out" name="total_price_of_checking_out" value="">
														<button type="submit" class="btn btn-link"><img class="img-thumbnail" title="Pagar com PagSeguro" src="<?php echo base_url('assets/payment/pagseguro.png'); ?>"></button>
												</form>
										</div>
                                      <?php } ?>
								</div>
						</div>
				</div>
		</div>
</div><!-- Modal -->
