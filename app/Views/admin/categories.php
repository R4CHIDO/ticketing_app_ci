
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div  class="first">
      <div class="title">
        Totale
        <h4><?php echo $count ?><span> Categories</span></h4>
      </div>
      <div class="icon">
        <i class='bx bx-user' ></i>
      </div>
    </div>
    <div onclick="showCatForm()" class="second">
      <div class="title">
        nouveau
        <h4><?php //echo $techs ?><span>Ajouter une categorie</span></h4> 
      </div>
      <div class="icon">
        <i class='bx bx-message-square-add'></i>
      </div>
    </div>
    <!-- <div class="third">
      <div  class="title">
        Tous
        <h4><?php //echo $all ?> <span> Utilisateurs</span> </h4> 
      </div>
      <div class="icon">
        <i class='bx bx-group' ></i>
      </div>
    </div> -->

  </div>

  <table style="margin:0 20px;" id="datatable" class="styled-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom categorie</th>
        <th>Nobre techniciens</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($categories as $cat):  ?>
        <tr>
          <td><?php echo $cat->id_tech_cat ?></td>
          <td><?php echo $cat->label_tech_cat ?></td>         
          <td><?php echo $cat->techs ?></td>
          
        </tr>
      <?php endforeach;  ?>
    </tbody>
  </table>

</div>
  
<!-- TO BE removed -->
<div  class="modal-container cat" id="modal_container">
  <div class="modal">
    <h1 id="name">Ajouter une categorie</h1>
    <div class="underline"></div>
    <form action="<?php echo site_url('Admin/addCat') ?>" method="post" id="contact_form">
      <div class="name nomcat">
        <label for="name"></label>
        <input type="text" class="input_text labelCat"   placeholder="" name="label" id="name_input" required>
      </div>          
      <div class="submit">        
        <input type="submit" value="Ajouter" id="form_button"  />
        <input onclick="hide()" type="button" value="cancel" id="form_button" id="close" />
      </div>
    </form><!-- // End form  -->
  </div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    var open = document.getElementById('open');
    var modal_container = document.getElementById('modal_container');
    var close = document.querySelector('closse');
    var label = document.querySelector('.labelCat');
    function showCatForm(){
      modal_container.classList.add('show');
    }

    function hide(){
      modal_container.classList.remove('show');
    }

//function to get the finished ticket

</script>
<?php $this->endsection(); ?>