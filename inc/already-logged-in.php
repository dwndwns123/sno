<div class="row">
  <div class="span12">
    <div class="well">
      <p class="lead">You are already logged in as <?= ($_SESSION['title'] !== 'Other' ? $_SESSION['title'].' ' : ''); ?><?= $_SESSION['first_name'].' '.$_SESSION['last_name'] ?>.</p>
      <a class="btn btn-primary" href="/">Home</a>
    </div>
  </div>
</div>