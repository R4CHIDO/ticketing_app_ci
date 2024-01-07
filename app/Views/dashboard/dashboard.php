


<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<div class="dashboard-table" >     
  <div class="statistics-container">
    <div onclick=" displayFinished()" class="first">
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
        <i class='bx bx-time-five' ></i>      </div>
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
          <th>Sujet</th>
          <th>Designation</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tickets as $ticket):  ?>
          <tr>
            <td><?php echo $ticket->created_at ?></td>
            <td><?php echo substr($ticket->subject ,0 ,25).'...' ?></td>
            <td><?php echo $ticket->label_tech_cat ?></td>         
            <td><?php echo $ticket->label_status ?></td> 
          </tr>
        <?php endforeach;  ?>
      </tbody>
    </table>
  
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

//function to get the finished ticket
function displayFinished() {
  $.ajax({
      url: "<?php echo site_url('tickets/afficherTicket/'); ?>",
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>Date de creation</th>
                <th>Sujet</th>
                <th>Designation</th>
                <th>Technicien Id</th>
                <th>Reponse</th>
              </tr>
            `)
        $(data).each(function(){
          if(this.id_status == 2)
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.subject.substr(0,20)}</td>  
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


// function to get the tickets having status = inprocess
function displayInProcess() {
  $.ajax({
      url: "<?php echo site_url('tickets/afficherTicket/'); ?>",
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>Date de creation</th>
                <th>Sujet</th>
                <th>Designation</th>
              </tr>
            `)
        $(data).each(function(){
          if(this.id_status == 1)
            $('tbody').append(`
                <tr>
                  <td> ${this.created_at.date.substr(0,19)}</td>  
                  <td> ${this.subject.substr(0,80)}</td>  
                  <td> ${this.label_tech_cat}</td>  
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
      url: "<?php echo site_url('tickets/afficherTicket/'); ?>",
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
            <tr>
              <th>Date de creation</th>
              <th>Sujet</th>
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
                <td> ${this.subject.substr(0,20)}</td>  
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