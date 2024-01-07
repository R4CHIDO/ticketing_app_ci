<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>

<h1>welcome user with id =  <?php echo session('user_id') . ' and id cat = ' . session('id_cat') ; ?> </h1>
<h1><?php echo session('id_tech_cat') ?> </h1>
<?php $this->endsection(); ?>

