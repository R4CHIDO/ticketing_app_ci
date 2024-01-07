
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div  class="first">
      <div class="title">
        Client
        <h4><?php echo $clients ?><span> Clients</span></h4>
      </div>
      <div class="icon">
        <i class='bx bx-user' ></i>
      </div>
    </div>
    <div onclick="inwait()" class="second">
      <div class="title">
        En attente
        <h4><?php echo $waiting ?><span> clients</span></h4> 
      </div>
      <div class="icon">
      <i class='bx bx-laptop'></i>
    </div>
    </div>
    

  </div>

  <table style="margin:0 20px;" id="datatable" class="styled-table">
    <thead>
      <tr>
        <th>Nom complet</th>
        <th>Email</th>
        <th>Date de creation</th>
        <th>Categorie</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($users as $user):  ?>
        <?php if($user->id_cat == 1):  ?>
        <tr>
          <td><?php echo $user->fullname ?></td>
          <td><?php echo $user->email ?></td>         
          <td><?php echo $user->created_at ?></td>
          <td><?php echo $user->label_cat ?></td> 
          <td><div onclick="show(<?php echo $user->id_user ?>)"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div></td> 
        </tr>
        <?php endif;  ?>

      <?php endforeach;  ?>
    </tbody>
  </table>

</div>
  
<!-- TO BE removed -->
<div  class="modal-container" id="modal_container">
  <div class="modal">
    <h1 id="name">Detail user</h1>
    <div class="underline"></div>
    <form action="<?php echo site_url('Admin/add') ?>" method="post" id="contact_form">
      <div class="name detailUser">
        <label for="name"></label>
        <input type="text" class="input_text username" readonly   placeholder="" name="title" id="name_input" required>
      </div>     
      <div class="name detailUser">
        <label for="name"></label>
        <input type="text" class="input_text useremail" readonly   placeholder="" name="title" id="name_input" required>
      </div>     
      <div class="name detailUser">
        <label for="name"></label>
        <input type="text" class="input_text usercategorie" readonly   placeholder="" name="title" id="name_input" required>
      </div>     
      <div class="submit">


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
    function show(id){
      $.ajax({
        url: '<?=site_url()?>admin/findUser/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {
          $('.username').val(data.fullname);
          $('.useremail').val(data.email);
          $('.usercategorie').val('Totale ticket :' +data.count);
        },
        error: function( error , xhr , msg )
        {
            alert(msg);
        }
      });
      modal_container.classList.add('show');
    }

    function hide(){
      modal_container.classList.remove('show');
    }

    function inwait(){
      $.ajax({
        url: '<?=site_url()?>Admin/waiting/',
        dataType: 'json',
        type: 'post',
        success: function(data) {
          $("tbody").empty();
          $("thead").empty();
          $('thead').append(`
                <tr>
                  <th>Nom complet</th>
                  <th>Email</th>
                  <th>Date de creation</th>
                  <th>Action</th>
                </tr>
              `)        
          $(data).each(function(){
            $('tbody').append(`
                <tr>
                  <td> ${this.fullname}</td>  
                  <td> ${this.email}</td>  
                  <td> ${this.created_at.date.substr(0 ,19)}</td>  
                  <td style="font-size:18px;">
                    <div onclick="add(${this.id_user})"  class="edit_btn"><i class='bx bxs-message-square-add'></i> Ajouter</div>
                    <div onclick="remove(${this.id_user})"  class="edit_btn"><i class='bx bxs-trash' ></i> Supprimer</div>
                  </td> 
                </tr>
            `)
          })
        },
        error: function( error , xhr , msg )
        {
            alert(msg);
        }
      });
    }


    function add(id){
      $.ajax({
        url: '<?=site_url()?>Admin/add/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {
          console.log('hello');
        },
        error: function( error , xhr , msg )
        {
        }
      });
      location.reload();
    }

    function remove(id){
      $.ajax({
        url: '<?=site_url()?>Admin/remove/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {

        },
        error: function( error , xhr , msg )
        {
        }
      });
      location.reload();
    }


</script>
<?php $this->endsection(); ?>