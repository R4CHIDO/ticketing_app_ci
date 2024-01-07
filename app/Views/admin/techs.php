
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div  class="first">
      <div class="title">
        Existants
        <h4><?php echo $techs ?><span> techniciens</span></h4>
      </div>
      <div class="icon">
      <i class='bx bx-laptop'></i>
      </div>
    </div>
    <div onclick="newTechForm()" class="second">
      <div class="title">
        Ajouter
        <h4><span>Créér un technicien</span></h4> 
    </div>
      <div class="icon">
      <i class='bx bx-edit'></i>
    </div>
      </div>
  </div>

  <table style="margin:0 20px;" id="datatable" class="styled-table">
    <thead>
      <tr>
        <th>Nom complet</th>
        <th>Email</th>
        <th>Categorie</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($users as $user):  ?>
        <?php if($user->id_cat == 3):  ?>
        <tr>
          <td><?php echo $user->fullname ?></td>
          <td><?php echo $user->email ?></td>         
          <td><?php echo $user->label_tech_cat ?></td> 
          <td>
            <div onclick="show(<?php echo $user->id_user ?>)"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div>
          </td> 
        </tr>
        <?php endif;  ?>

      <?php endforeach;  ?>
    </tbody>
  </table>

</div>
  <!-- add tech modal  -->
 
  <!-- add tech modal  -->
<!-- TO BE removed -->
<div  class="modal-container second_modal" id="modal_container">
  <div class="modal newTech">
    <h1 id="name">username</h1>
    <div class="underline"></div>
    <form action="<?php echo site_url('') ?>" method="post" id="contact_form">
    
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text useremail"   placeholder="Adress Email" name="" id="name_input" required>
      </div>
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text usercategorie"   placeholder="Mot de passe" name="" id="name_input" required>
      </div>
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text techcategorie"   placeholder="Mot de passe" name="" id="name_input" required>
      </div>
    
      <div class="submit">
        <input type="button" onclick="hide()" value="cancel" id="form_button" />
      </div>
    </form><!-- // End form -->
  </div>
</div>
<!-- //end modal -->
<!-- TO BE removed -->
<div  class="modal-container first_modal" id="modal_container">
  <div class="modal newTech">
    <h1 id="name">Ajouter un technicien</h1>
    <div class="underline"></div>
    <form action="<?php echo site_url('Admin/addTech') ?>" method="post" id="contact_form">
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text"   placeholder="Nom complet" name="fullname" id="name_input" required>
      </div>
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text"   placeholder="Adress Email" name="email" id="name_input" required>
      </div>
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text"   placeholder="Mot de passe" name="password" id="name_input" required>
      </div>    
      <div class="subject">
        <label for="subject"></label>
        <select class="input_select" placeholder="Subject line" name="id_tech_cat" id="subject_input" required>
            <?php foreach($cats as $cat): ?>       
              <option value=<?php echo $cat->id_tech_cat ?> > <?php echo $cat->label_tech_cat ?> </option>
            <?php endforeach ; ?>
        </select>
      </div>
      <div class="submit">
        <input type="submit" value="Créer" id="form_button" />
        <input type="button" onclick="hideFrmTech()" value="cancel" id="form_button" />
      </div>
    </form><!-- // End form -->
  </div>
</div>
<!-- //end modal -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    var open = document.getElementById('open');
    var modal_container = document.getElementById('modal_container');
    var close = document.querySelector('closse');
    var second_modal = document.querySelector('.second_modal');
    var first_modal = document.querySelector('.first_modal');
    function show(id){
      $.ajax({
        url: '<?=site_url()?>admin/findTech/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {
          $('.username').val('Nom Complet : '+ data.fullname);
          $('.useremail').val('Email : '+data.email);
          $('.techcategorie').val('Categorie : '+data.label_tech_cat);
          $('.usercategorie').val('Totale des ticketes  : ' +data.count);
        },
        error: function( error , xhr , msg )
        {
            alert(msg);
        }
      });
      modal_container.classList.add('show');
    }
    function newTechForm(){
      first_modal.classList.add('show');
    }

    function hideFrmTech(){
      first_modal.classList.remove('show');
    }
    function hide(){
      second_modal.classList.remove('show');
    }


//function to get the finished ticket

</script>
<?php $this->endsection(); ?>