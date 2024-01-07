
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div onclick="displayFinished()" class="first">
      <div class="title">
        Terminée
        <h4><?php echo $finished ?> <span>tickets</span></h4>
      </div>
      <div class="icon">
        <i class='bx bx-calendar-check' ></i>
      </div>
    </div>
    <div onclick="displayInProcess()" class="second">
      <div class="title">
        En cours
        <h4><?php echo $inprocess ?> <span>tickets</span></h4> 
    </div>
      <div class="icon">
        <i class='bx bx-time-five' ></i></div>
      </div>
    <div class="third">
      <div onclick="displayAll()" class="title">
        Tous
        <h4><?php echo $all ?> <span>tickets</span> </h4> 
      </div>
      <div class="icon">
        <i class='bx bx-list-ul' ></i>
      </div>
    </div>

  </div>

  <table style="margin:0 20px;" id="datatable" class="styled-table">
    <thead>
      <tr>
        <th>Date de creation</th>
        <th>Titre</th>
        <th>Designation</th>
        <th>Status</th>
        <th>Edit</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tickets as $ticket):  ?>
        <tr>
          <td><?php echo $ticket->created_at ?></td>
          <td><?php echo $ticket->title ?></td>
          <td><?php echo $ticket->label_tech_cat ?></td>         
          <td><?php echo $ticket->label_status ?></td> 
          <td><div onclick="show(<?php echo $ticket->id_ticket ?> )"  class="edit_btn"> <i class='bx bxs-edit' ></i> Editer</div></td> 
        </tr>
      <?php endforeach;  ?>
    </tbody>
  </table>

</div>
  
<!-- TO BE removed -->
<div  class="modal-container" id="modal_container">
  <div class="modal">
    <h1 id="name"></h1>
    <div class="underline"></div>
    <form action="<?php echo site_url('Tickets/updateTicket') ?>" method="post" id="contact_form">
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text TKtitle" readonly   placeholder="Title" name="title" id="name_input" required>
      </div>
      <div class="message">
        <label for="message"></label>
        <textarea class="input_textarea TKsujet" readonly name="subject" placeholder="Sujet" id="message_input" cols="30" rows="4" required></textarea>
      </div>
      <div class="message">
        <label for="message"></label>
        <textarea class="input_textarea TKcomment" name="comment" placeholder="Commenter" id="message_input" cols="30" rows="4" required></textarea>
      </div>
      <div class="subject">
        <label for="subject"></label>
        <select class="input_select TKstatus" placeholder="Subject line" name="cat" id="subject_input" required>
          <?php  foreach($status as $st): ?>       
              <option value=<?php echo $st->id_status ?> > <?php  echo $st->label_status ?> </option>
            <?php endforeach ; ?>
        </select>
      </div>
      
      <div class="submit">
        
        <input type="button" onclick="updateT(id)" value="Valider" id="form_button" />
        <input onclick="hide()" type="button" value="cancel" id="form_button" id="close" />
        <input  type="button" value=""  id="btnid" />
      </div>
    </form><!-- // End form -->
  </div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    var open = document.getElementById('open');
    var modal_container = document.getElementById('modal_container');
    var close = document.querySelector('closse');
    function show(id){
      $.ajax({
        url: '<?=site_url()?>tickets/find/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {
          $('#name').html(data.fullname);
          $('.TKsujet').val(data.subject);
          $('.TKtitle').val(data.title);
          $('#btnid').val(data.id_ticket);
          $('.TKcomment').val(data.comment);
        },
        error: function( error )
        {
            alert(error);
        }
      });
      modal_container.classList.add('show');
}
var id =  document.getElementById('btnid').value;

    function updateT(id){
      var commentTK = document.querySelector('.TKcomment').value;
      var statusTK =  document.querySelector('.TKstatus ').value;
      var id =  document.getElementById('btnid').value;
      $.ajax({
        url: '<?=site_url()?>tickets/updateT/'+id,
        dataType: 'json',
        type: 'post',
        data:{"commentTK" : commentTK , "statusTK" : statusTK},
        // data:{comment:comm},
        success: function(data) {
          alert('cc'); 
        },
        error: function( error ,d,msg)
        {
        
        }
      });
      hide();
      location.reload();

      
}
      
    function hide(){
      modal_container.classList.remove('show');
    }







//function to get the finished ticket
function displayFinished() {
  $.ajax({
      url: '<?=site_url()?>tickets/afficherTicketTech/',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
              <th>Date de creation</th>
              <th>Titre</th>
              <th>Technicien Id</th>
              <th>Reponse</th>
              </tr>
            `)
        $(data).each(function(){
          if(this.id_status == 2)
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.title}</td>  
                  <td> ${this.tech_id}</td>  
                  <td> ${this.comment}</td>  
                </tr>
            `)
          })
      },
      error: function( error )
      {
          alert(error);
      }
  });
}


// function to get the tickets having status = inprocess
function displayInProcess() {
  $.ajax({
      url: '<?=site_url()?>tickets/afficherTicketTech/',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>Date de creation</th>
                <th>Title</th>
                <th>Detail</th>
                <th>Designation</th>
                <th>Edit</th>
              </tr>
            `)
        $(data).each(function(){
          if(this.id_status == 1)
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.title}</td>  
                  <td> Detail </td>  
                  <td> ${this.label_tech_cat}</td>  
                  <td><div onclick="show(${this.id_ticket})"  class="edit_btn"> <i class='bx bxs-edit' ></i> Editer</div></td> 

                </tr>
            `)
          })
      },
      error: function( error )
      {
          alert(error);
      }
  });
}

// function to get all the tickets
function displayAll() {
  $.ajax({
      url:'<?=site_url()?>tickets/afficherTicketTech/',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
            <tr>
              <th>Date de creation</th>
              <th>Titre</th>
              <th>Designation</th>
              <th>Technicien Id</th>
              <th>Reponse</th>
            </tr>
            `)
        $(data).each(function(){
          if(this.tech_id == null)
            this.tech_id = 'Aucun technicien';
          if(this.comment == null)
            this.comment = 'Aucun reponse';
          $('tbody').append(`
              <tr>
                <td> ${this.created_at.date.substr(0,19)}</td>  
                <td> ${this.title}</td>  
                <td> ${this.label_tech_cat}</td>  
                <td> ${this.tech_id}</td>  
                <td> ${this.comment}</td>  
              </tr>
            `)
          })
      },
      error: function( error )
      {
          alert(error);
      }
  });
}

</script>
<?php $this->endsection(); ?>