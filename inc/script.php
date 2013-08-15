<script src="/js/lib/jquery/jquery-1.10.1.min.js"></script>

<script src="/js/lib/bootstrap.min.js"></script>
<script src="/js/lib/bootstrap-maxlength.js"></script>
<script src="/js/lib/parsley.min.js"></script>
<script src="/js/lib/bootbox.min.js"></script>
<script src="/js/lib/spin.min.js"></script>

<script src="/js/script.js"></script>

<!-- Google Analytics for site tracking -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-41892858-3', 'snomedtools.com');
  ga('send', 'pageview');

</script>


<!--<div class="well hidden"> 
--><div>
<p>-------------------------------
    <big><strong>DEBUG</strong></big></p>
<?php 
foreach ($_SESSION as $key=>$value){
  print "\$_ SESSION [\"$key\"] == $value<br>";
}

print"<br /><br />POST:";
print_r($_POST);
?>
</div>