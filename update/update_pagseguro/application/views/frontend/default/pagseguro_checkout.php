<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pagseguro | <?php echo get_settings('system_name');?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo base_url('assets/payment/css/stripe.css');?>" rel="stylesheet">
    <link name="favicon" type="image/x-icon" href="<?php echo base_url();?>uploads/system/favicon.png" rel="shortcut icon" />
</head>
<link rel="favicon" href="<?php echo base_url().'assets/frontend/default/img/icons/favicon.ico' ?>">
<link rel="apple-touch-icon" href="<?php echo base_url().'assets/frontend/default/img/icons/icon.png'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/jquery.webui-popover.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/select2.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/slick.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/slick-theme.css'; ?>">
<!-- font awesome 5 -->
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/fontawesome-all.min.css'; ?>">

<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/bootstrap.min.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/bootstrap-tagsinput.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/main.css'; ?>">
<link rel="stylesheet" href="<?php echo base_url().'assets/frontend/default/css/responsive.css'; ?>">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url().'assets/global/toastr/toastr.css' ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" />
<script src="<?php echo base_url('assets/backend/js/jquery-3.3.1.min.js'); ?>"></script>
<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
<!--Stripe API-->
<script src="https://js.stripe.com/v3/"></script>

<body>

    <style>
        body {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .payment-header-text {
            font-size: 23px;

        }

        .close-btn-light {
            padding-left: 10px;
            padding-right: 10px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            font-size: 25px;
            background-color: #F1EAE9;
            color: #a45e72;
            border-radius: 5px;
        }

        .close-btn-light:hover {
            padding-left: 10px;
            padding-right: 10px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            font-size: 25px;
            background-color: #a45e72;
            color: #FFFFFF;
            border-radius: 5px;
        }

        .payment-header {
            font-size: 18px;
        }

        .item {
            width: 100%;
            height: 50px;
            display: block;
        }

        .count-item {
            padding-left: 13px;
            padding-right: 13px;
            padding-top: 5px;
            padding-bottom: 5px;

            margin-bottom: 100%;
            margin-right: 18px;
            margin-top: 8px;

            color: #00B491;
            background-color: #DEF6F3;
            border-radius: 5px;
            float: left;
        }

        .item-title {
            font-weight: bold;
            font-size: 13.5px;
            display: block;
            margin-top: 6px;
        }

        .item-price {
            float: right;
            color: #00B491;
        }

        .by-owner {
            font-size: 11px;
            color: #76767E;
            display: block;
            margin-top: -3px;
        }

        .total {
            border-radius: 8px 0px 0px 8px;
            background-color: #DBF3F0;
            padding: 10px;
            padding-left: 30px;
            padding-right: 30px;
            font-size: 18px;
        }

        .total-price {
            border-radius: 0px 8px 8px 0px;
            background-color: #CCD4DD;
            padding: 10px;
            padding-left: 25px;
            padding-right: 25px;
            font-size: 18px;
        }

        .indicated-price {
            padding-bottom: 20px;
            margin-bottom: 0px;
        }

        .payment-button {
            background-color: #1DBDA0;
            border-radius: 8px;
            padding: 10px;
            padding-left: 30px;
            padding-right: 30px;
            color: #fff;
            border: none;
            font-size: 18px;
        }

        .payment-gateway {
            border: 2px solid #D3DCDD;
            border-radius: 5px;
            padding-top: 15px;
            padding-bottom: 15px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .payment-gateway:hover {
            border: 2px solid #00D04F;
            border-radius: 5px;
            padding-top: 15px;
            padding-bottom: 15px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .payment-gateway-icon {
            width: 80%;
            float: right;
        }

        .tick-icon {
            margin: 0px;
            padding: 0px;
            width: 15%;
            float: left;
            display: none;
        }

        .paypal-form,
        .stripe-form {
            display: none;
        }

        @media only screen and (max-width: 600px) {

            .paypal,
            .stripe {
                margin-left: 5px;
                width: 70%;
            }
        }

    </style>

    <?php
$paypal = json_decode(get_settings('paypal'));
$stripe = json_decode(get_settings('stripe_keys'));
$total_price_of_checking_out = $this->session->userdata('total_price_of_checking_out');
?>


    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-8">
                        <span class="payment-header-text float-left"><b><?php echo get_phrase('make_payment'); ?></b></span>
                        <a href="<?php echo site_url('home/shopping_cart'); ?>" class="close-btn-light float-right"><i class="fa fa-times"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="col-md-1"></div>

                <div class="col-md-8">
                    <div class="w-100">
                        <p class="pb-2 payment-header"><?php echo get_phrase('items'); ?> <?php echo get_phrase('selected'); ?></p>
                        <?php $counter = 0 ?>
                        <?php foreach ($this->session->userdata('cart_items') as $cart_item) :
						$counter++;
						$course_details = $this->crud_model->get_course_by_id($cart_item)->row_array();
						$instructor_details = $this->user_model->get_all_user($course_details['user_id'])->row_array(); ?>

                        <p class="item float-left">
                            <span class="count-item"><?php echo $counter; ?></span>
                            <span class="item-title"><?php echo $course_details['title']; ?>
                                <span class="item-price">
                                    <?php if ($course_details['discount_flag'] == 1) :
										echo currency($course_details['discounted_price']);
										else :
											echo currency($course_details['price']);
										endif; ?>
                                </span>
                            </span>
                            <span class="by-owner">
                                <?php echo get_phrase('by'); ?>
                                <?php echo $instructor_details['first_name'] . ' ' . $instructor_details['last_name']; ?>
                            </span>
                        </p>
                        <?php endforeach; ?>
                    </div>
                    <div class="w-100 float-left mt-4 indicated-price">
                        <div class="float-right total-price"><?php echo currency($total_price_of_checking_out); ?></div>
                        <div class="float-right total"><?php echo get_phrase('total_amount'); ?></div>
                    </div>


                    <div class="w-100 float-left">


                        <button type="button" class="payment-button float-right" onclick="GerarPagSeguro()" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processando <i>PagSeguro...</i>">Efetuar Pagamento</button>
                        
                    </div>

<?php //echo $dados; ?>


                </div>
            </div>
        </div>
        <div class="col-md-8" id="resultado"></div>
    </div>
    

    
</body>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js'></script>
<script>
    function GerarPagSeguro() {

        $.post("<?php echo site_url('home/envia_pagseguro'); ?>", {
            dados: "ok"
        }, function(data) {

            PagSeguroLightbox(data);
        })
    }

     function GerarPagSeguro2() {   
  $.post("<?php echo site_url('home/envia_pagseguro'); ?>", {
            dados: "ok"
        }, function(data) {

  $("#resultado").html(data);
        });
    }
</script>

<script>
    $('.payment-button').on('click', function() {
        var $this = $(this);
        $this.button('loading');
        setTimeout(function() {
            $this.button('reset');
        }, 8000);
    });

</script>

</html>
