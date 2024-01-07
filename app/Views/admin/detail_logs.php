
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div  class="first">
      <div class="title">
        Date de connexion
        <h4><?php echo substr($log->date_debut , 10, 20) ?><span> </span></h4>
      </div>
      <div class="icon">
      <i class='bx bx-timer' ></i>
      </div>
    </div>
    <div class="second">
      <div class="title">
        Date de deconnexion
        <h4><?php echo substr($log->date_debut , 10, 20) ?><span> </span></h4> 
    </div>
      <div class="icon">
      <i class='bx bx-timer' ></i>
    </div>
      </div>
    <div onclick="showFRM()" class="third">
      <div  class="title">
        Action
        <h4><?php echo $actions ?> <span> Actions</span> </h4> 
      </div>
      <div class="icon">
      <i class='bx bx-window-open' ></i>
      </div>
    </div>

  </div>

  <table style="margin:0 20px;" id="datatable" class="styled-table">
    <thead>
      <tr>
        <th>Id log</th>
        <th>Nom complet</th>
        <th>Action</th>
        <th>Date d'action</th>
        <th>Detail</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($detail_logs as $log):  ?>
        <tr>
          <td><?php echo $log->id_log ?></td>         
          <td><?php echo $log->fullname ?></td>
          <td><?php echo $log->action ?></td>
          <td><?php echo $log->created_at ?></td> 
          <td>
            <div onclick="show(<?php echo $log->id_detail_log ?>)"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div>
          </td> 
        </tr>
      <?php endforeach;  ?>
    </tbody>
  </table>

</div>
  <!-- add tech modal  -->
 
  <!-- add tech modal  -->
<!-- TO BE removed -->
<div  class="modal-container" id="modal_container">
  <div class="modal">
    <h1 id="name"></h1>
    <div class="underline"></div>
    <form action="<?php echo site_url('Tickets/updateTicket') ?>" method="post" id="contact_form">
      <div class="name detailUser">
        <label for="name"></label>
        <input type="text" class="input_text action" readonly   placeholder="" name="title" id="name_input" required>
      </div>      
      <div class="message">
        <label for="message"></label>
        <textarea class="input_textarea detail" readonly name="comment" placeholder="Commenter" id="message_input" cols="30" rows="4" required></textarea>
      </div> 
      <div class="submit">        
        <input onclick="hide()" type="button" value="cancel" id="form_button" id="close" />
      </div>
    </form><!-- // End form  -->
  </div>
</div>
<!-- //end modal -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    var open = document.getElementById('open');
    var modal_container = document.getElementById('modal_container');
    var close = document.querySelector('closse');
    function show(id){
      $.ajax({
        url: '<?=site_url()?>admin/findDetailLog/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {
          $('.action').val('Action : '+ data.action);
          $('.detail').val('detail : '+data.detail);
          $('#name').html(data.fullname);
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


//function to get the finished ticket

</script>
<?php $this->endsection(); ?>