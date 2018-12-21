<footer class="main-footer">
  <strong>Copyright &copy; 2018
    <a href="http://www.ucconnect.co.th/">UC Connect Co.,Ltd.</a>.</strong> All rights reserved.
</footer>

</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="<?php echo $this->config->item('assets'); ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Global Variable -->
<script src="<?php echo $this->config->item('assets'); ?>dist/js/global.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $this->config->item('assets'); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo $this->config->item('assets'); ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $this->config->item('assets'); ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $this->config->item('assets'); ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $this->config->item('assets'); ?>dist/js/demo.js"></script>
<!-- Alertify -->
<script src="<?php echo $this->config->item('assets'); ?>vendor/alertify/alertify.min.js"></script>
<!-- sematic -->
<script src="<?php echo $this->config->item('assets'); ?>bower_components/semantic/semantic.min.js"></script>
<?php
foreach ($linksJavascript as $value) {
    echo '<script src="' . $value . '"></script>' . PHP_EOL;
}
?>

  <script>
    $(document).ready(function () {
      $('.sidebar-menu').tree()
    });
    window.onload = () => {
      close_loading();
    }
  </script>

  </body>

  </html>