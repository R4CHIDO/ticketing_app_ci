
<?php

use App\Entities\Ticket;

$this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>

 

<div class="d-flex justify-content-center align-content" style="width: 100%;margin:40px 0 0 0;">
 

<?php if(session()->has("errors")): ?>
    <?php foreach(session("errors") as $error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>error!</strong> 
          <?php echo $error ; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endforeach ; ?>
  <?php endif ; ?>



<div style="width: 50%;"  >
    <div class="message_date">
      <p class="date text-info"><?php echo  $ticket->created_at->humanize() ?></p>
    </div>
    <div class="message_wrapper">
      <h4 class="heading"><?php echo $ticket->fullname ?></h4>
      <blockquote class="message"><?php echo $ticket->subject ?></blockquote>
      <br>
    <form action=<?php echo site_url('/tickets/updateTicket/' . $ticket->id_ticket) ?> method="post" accept-charset="utf-8">

        <div style="margin: 0 0 20px 0 ;" class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" name="comment" id="floatingTextarea2" style="color:gray;height: 100px"><?php echo $ticket->comment ?>
          </textarea>
          <label for="floatingTextarea2">Commentaire</label>
        </div>
        <div style="margin: 0 0 20px 0 ;" class="form-floating">
          <select class="form-select" style="color: gray;" name="status" id="floatingSelect" aria-label="Floating label select example">
            <option value="1">En cours</option>
            <option value="2">Terminées</option>
          </select>
          <label for="floatingSelect">Status</label>
        </div>
        <div class="mb-3 d-flex justify-content-center">
            <input type="submit" class="btn btn-success" value="Save">
            <button type="button"  class="btn btn-warning"><a style="color: white;" href="<?php echo site_url('tickets/TicketsByTechs/') ?>">Cancel</a> </button>
          </div>
    </form>
    </div>
  </div>
</div>


<?php $this->endsection(); ?>