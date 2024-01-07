
<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>


<!-- client -->



<div class="dashboard-table" >     
  <div class="statistics-container">
    <div onclick="deconnected()"  class="first">
      <div class="title">
        Déconnectées
        <h4><?php echo $offline ?><span> Log</span></h4>
      </div>
      <div class="icon">
      <i class='bx bx-wifi-off' ></i>
      </div>
    </div>
    <div onclick="connected()" class="second">
      <div class="title">
        En cours
        <h4><?php echo $online ?><span> Log</span></h4> 
      </div>
      <div class="icon">
      <i class='bx bx-wifi'></i>
      </div>
    </div>
    <div onclick="allLogs()" class="third">
      <div  class="title">
        Tous
        <h4><?php echo $all ?> <span> Log</span> </h4> 
      </div>
      <div class="icon">
        <i class='bx bx-list-ul' ></i>
      </div>
    </div>
    </div>


  <table style="margin:0 20px;" id="datatable" class="styled-table">
    <thead>
      <tr>
        <th>id log</th>
        <th>Nom complet</th>
        <th>Date debut </th>
        <th>Date fin </th>
        <th>Durée (min)</th>
        <th>Detail</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($logs as $log):  ?>
        <tr>
          <td><?php echo $log->id_log ?></td>
          <td><?php echo $log->fullname ?></td>
          <td><?php echo $log->date_debut ?></td>         
          <td><?php echo $log->date_fin ?></td> 
          <td><?php echo $log->dure ?></td> 
          <td>
            <a class="link-detail" href=<?php echo site_url('Admin/detail_logs/' . $log->id_log) ?> >
            <i class='bx bxs-file-find' ></i>
              Detail
            </a>
          </td> 
        </tr>
      <?php endforeach;  ?>
    </tbody>
  </table>

</div>
  <!-- add tech modal  -->
 
  <!-- add tech modal  -->
<!-- TO BE removed -->
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

    function connected() {
  $.ajax({
      url: '<?=site_url()?>Admin/Logs',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>id log</th>
                <th>Nom complet</th>
                <th>Date debut </th>
                <th>Detail</th>
              </tr>
            `)
        
            $('tbody').append(`
              <?php foreach($logs as $log):  ?>
                <?php if($log->date_fin === null):  ?>
                  <tr>
                    <td><?php echo $log->id_log ?></td>
                    <td><?php echo $log->fullname ?></td>
                    <td><?php echo $log->date_debut ?></td>         
                    <td>
                      <a class="link-detail" href=<?php echo site_url('Admin/detail_logs/' . $log->id_log) ?> >
                      <i class='bx bxs-file-find' ></i>
                        Detail
                      </a>
                    </td> 
                </tr>
                <?php endif;  ?>
              <?php endforeach;  ?>
            `)
      },
      error: function( error,d,msg )
      {
          alert(msg);
      }
  });
}

    function deconnected() {
  $.ajax({
      url: '<?=site_url()?>Admin/Logs',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>id log</th>
                <th>Nom complet</th>
                <th>Date debut </th>
                <th>Date fin </th>
                <th>Durée (min)</th>
                <th>Detail</th>
              </tr>
            `)
        
            $('tbody').append(`
              <?php foreach($logs as $log):  ?>
                <?php if($log->date_fin !== null):  ?>
                  <tr>
                    <td><?php echo $log->id_log ?></td>
                    <td><?php echo $log->fullname ?></td>
                    <td><?php echo $log->date_debut ?></td>         
                    <td><?php echo $log->date_fin ?></td> 
                    <td><?php echo $log->dure ?></td> 
                    <td>
                      <a class="link-detail" href=<?php echo site_url('Admin/detail_logs/' . $log->id_log) ?> >
                      <i class='bx bxs-file-find' ></i>
                        Detail
                      </a>
                    </td> 
                </tr>
                <?php endif;  ?>
              <?php endforeach;  ?>
            `)
      },
      error: function( error,d,msg )
      {
          alert(msg);
      }
  });
}


// function to get the tickets having status = inprocess

// function to get all the tickets
function allLogs() {
  $.ajax({
      url: '<?=site_url()?>Admin/Logs',
      dataType: 'json',
      type: 'get',
      success: function(data) {
        $("tbody").empty();
        $("thead").empty();
        $('thead').append(`
              <tr>
                <th>id log</th>
                <th>Nom complet</th>
                <th>Date debut </th>
                <th>Date fin </th>
                <th>Durée (min)</th>
                <th>Detail</th>
              </tr>
            `)
        
            $('tbody').append(`
              <?php foreach($logs as $log):  ?>
                  <tr>
                  <td><?php echo $log->id_log ?></td>
                    <td><?php echo $log->fullname ?></td>
                    <td><?php echo $log->date_debut ?></td>         
                    <td><?php echo $log->date_fin ?></td> 
                    <td><?php echo $log->dure ?></td> 
                    <td>
                      <a class="link-detail" href=<?php echo site_url('Admin/detail_logs/' . $log->id_log) ?> >
                      <i class='bx bxs-file-find' ></i>
                        Detail
                      </a>
                    </td> 
                </tr>
              <?php endforeach;  ?>
            `)
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