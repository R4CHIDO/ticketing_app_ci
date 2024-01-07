<?php $this->extend("layouts/layout"); ?>


<?php $this->section("content"); ?>

<head> 
  <link rel="stylesheet" href="<?php echo site_url('css/create.css') ?>">
</head>
<body>
  <div id="container">
    <h1>&bull; Ajouter un ticket &bull;</h1>
    <div class="underline"></div>
    <!-- <div class="icon_wrapper">
    <i class='bx bx-message-add iconn' ></i>
    </div> -->
    <form action="<?php echo site_url('Tickets/createTicket') ?>" method="post" id="contact_form">
      <div class="name">
        <label for="name"></label>
        <input type="text" class="input_text"   placeholder="Title" name="title" id="name_input" required>
      </div>
      <div class="subject">
        <label for="subject"></label>
        <select class="input_select" placeholder="Subject line" name="cat" id="subject_input" required>
           <?php foreach($cats as $cat): ?>       
              <option value=<?php echo $cat->id_tech_cat ?> > <?php echo $cat->label_tech_cat ?> </option>
            <?php endforeach ; ?>
        </select>
      </div>
      <div class="message">
        <label for="message"></label>
        <textarea class="input_textarea" name="subject" placeholder="Sujet" id="message_input" cols="30" rows="5" required></textarea>
      </div>
      <div class="submit">
        <input type="submit" value="Créer" id="form_button" />
      </div>
    </form><!-- // End form -->
  </div><!-- // End #container -->
</body>
</html>

  <?php $this->endsection(); ?>

