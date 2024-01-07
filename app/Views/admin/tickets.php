
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div onclick="displayFinished()"  class="first">
      <div class="title">
        Terminées
        <h4><?php echo $finished ?><span> tickets</span></h4>
      </div>
      <div class="icon">
      <i class='bx bx-calendar-check' ></i>
      </div>
    </div>
    <div onclick="displayInProcess()" class="second">
      <div class="title">
        En cours
        <h4><?php echo $inprocess ?><span> tickets</span></h4> 
    </div>
      <div class="icon">
      <i class='bx bx-time-five' ></i></div>
      </div>
    <div onclick="displayAll()" class="third">
      <div  class="title">
        Tous
        <h4><?php echo $all ?> <span> tickets</span> </h4> 
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
        <th>Nom complet</th>
        <th>Title</th>
        <th>Categorie</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($tickets as $ticket):  ?>
        <tr>
          <td><?php echo $ticket->created_at ?></td>
          <td><?php echo $ticket->fullname ?></td>
          <td><?php echo $ticket->title ?></td>         
          <td><?php echo $ticket->label_status ?></td> 
          <td><?php echo $ticket->label_tech_cat ?></td> 
          <td>
            <div onclick="show(<?php echo $ticket->id_ticket ?>)"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div>
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
        <input type="text" class="input_text ticketTitle" readonly   placeholder="" name="title" id="name_input" required>
      </div>     
      <div class="name detailUser">
        <label for="name"></label>
        <input type="text" class="input_text catTicket" readonly   placeholder="" name="title" id="name_input" required>
      </div>     
      <div class="message">
        <label for="message"></label>
        <textarea class="input_textarea ticketSujet" readonly name="comment" placeholder="Commenter" id="message_input" cols="30" rows="4" required></textarea>
      </div> 
      <div class="message msg">
        <label for="message"></label>
        <textarea class="input_textarea ticketComment" readonly name="comment" placeholder="Commenter" id="message_input" cols="30" rows="4" required></textarea>
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
        url: '<?=site_url()?>Tickets/findT/'+id,
        dataType: 'json',
        type: 'post',
        success: function(data) {
          $('#name').html(data.fullname);
          $('.ticketTitle').val('Titre : '+data.title);
          $('.catTicket').val('Categorie  : ' +data.label_tech_cat);
          $('.ticketSujet').val('Sujet : '+data.subject);
          $('.ticketComment').val('Commentaire : '+data.comment);
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

    function displayFinished() {
  $.ajax({
      url: '<?=site_url()?>tickets/all',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>Date de creation</th>
                <th>Nom complet</th>
                <th>Title</th>
                <th>Categorie</th>
                <th>Action</th>
              </tr>
            `)
        $(data).each(function(){
          if(this.id_status == 2)
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.fullname}</td>  
                  <td> ${this.title}</td>  
                  <td> ${this.label_tech_cat}</td>  
                  <td>
            <div onclick="show(${this.id_ticket})"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div>
          </td> 
                </tr>
            `)
          })
      },
      error: function( error,d,msg )
      {
          alert(msg);
      }
  });
}


// function to get the tickets having status = inprocess
function displayInProcess() {
  $.ajax({
      url: '<?=site_url()?>tickets/all',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>Date de creation</th>
                <th>Nom complet</th>
                <th>Title</th>
                <th>Categorie</th>
                <th>Action</th>
              </tr>
            `)
        $(data).each(function(){
          if(this.id_status == 1)
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.fullname}</td>  
                  <td> ${this.title}</td>  
                  <td> ${this.label_tech_cat}</td>  
                  <td>
            <div onclick="show(${this.id_ticket})"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div>
          </td> 
                </tr>
            `)
          })
      },
      error: function( error,d,msg )
      {
          alert(msg);
      }
  });
}

// function to get all the tickets
function displayAll() {
  $.ajax({
      url: '<?=site_url()?>tickets/all',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>Date de creation</th>
                <th>Nom complet</th>
                <th>Title</th>
                <th>Categorie</th>
                <th>Action</th>
              </tr>
            `)
        $(data).each(function(){
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.fullname}</td>  
                  <td> ${this.title}</td>  
                  <td> ${this.label_tech_cat}</td>  
                  <td>
            <div onclick="show(${this.id_ticket})"  class="edit_btn"> <i class='bx bxs-show' ></i> Detail</div>
          </td> 
                </tr>
            `)
          })
      },
      error: function( error,d,msg )
      {
          alert(msg);
      }
  });
}

//function to get the finished ticket

</script>
<?php $this->endsection(); ?>