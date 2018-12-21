<?php $this->load->view('template/header');?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $baseConfig['pageTitle']; ?>
        <small><?php echo $baseConfig['subTitle']; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() . $baseConfig['pageTitle']; ?>"><i class="fa fa-address-book-o"></i> <?php echo $baseConfig['pageTitle']; ?></a></li>
        <li><a href="#"><?php echo $baseConfig['subTitle']; ?></a></li>
        <!-- <li class="active">Blank page</li> -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <!-- Loading -->
    <div id="loading-div" class="loading-page">
      <img class="loading-icon" src="<?php echo $this->config->item('assets') ?>dist/img/spinner.gif" id="loading-spin-nott" >
    </div>
   <?php $this->load->view($contentPath);?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php $this->load->view('template/footer');
