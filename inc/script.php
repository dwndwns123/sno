<script src="/js/lib/jquery/jquery-1.9.1.min.js"></script>

<script src="/js/lib/bootstrap.min.js"></script>
<script src="/js/lib/bootstrap-maxlength.js"></script>
<script src="/js/lib/parsley.min.js"></script>
<script src="/js/lib/bootbox.min.js"></script>
<script src="/js/lib/spin.min.js"></script>

<script src="/js/script.js"></script>




<div class="well hidden">
<p><big><strong>DEBUG</strong></big></p>
<?php
foreach ($_SESSION as $key=>$value){
  print "\$_ SESSION [\"$key\"] == $value<br>";
}

print"<br /><br />POST:";
print_r($_POST);

?>
</div>