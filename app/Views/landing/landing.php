<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>
<div class="d-flex justify-content-center flex-column align-items-center" style="width: 100%;height:700px;background-image:url(https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQgPJ0chmdGLWyfTBTaiU41WCplkPn89HauKQ&usqp=CAU);background-size:cover;">
 <h1>Write us a ticket,</h1>
 <h1>our team will handle it</h1><br>
  <div style="width: 80px;" class="btn btn-dark"><a style="text-decoration:none;color:#ddd;width:100%;" href="<?php echo site_url('login/signinForm') ?>">start</a></div>  
</div>
<?php $this->endsection(); ?>

