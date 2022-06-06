<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Advance Agri Brokers | <?= ucwords($title) ?></title>
    <?= link_tag('assets/images/favicon.png','icon','image/x-icon') ?>
    <?= link_tag('assets/plugins/fontawesome-free/css/all.min.css','stylesheet','text/css') ?>
    
    <?php if (isset($dataTables)): ?>
    <?= link_tag('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css','stylesheet','text/css') ?>
    
    <?php endif ?>
    
    <?php if (isset($select)): ?>
    <?= link_tag('assets/plugins/select2/css/select2.min.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css','stylesheet','text/css') ?>
    <?php endif ?>

    <?php if (isset($checkbox)): ?>
    <?= link_tag('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css','stylesheet','text/css') ?>
    <?php endif ?>

    <?php if (isset($dateFilter)): ?>
    <?= link_tag('assets/plugins/daterangepicker/daterangepicker.css','stylesheet','text/css') ?>
    <?= link_tag('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>
    <?php endif ?>

    <?= link_tag('assets/dist/css/adminlte.min.css','stylesheet','text/css') ?>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  </head>
  <body class="hold-transition layout-top-nav">
    <div class="wrapper">
      <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container-fluid">
          <?= anchor('', img(['src' => 'assets/images/logo.png', 'alt' => '', 'class' => 'brand-image img-circle elevation-3']), 'class="navbar-brand"') ?>
          <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
              <li class="nav-item">
                <?= anchor('', 'Dashboard', 'class="nav-link '.(($name == 'dashboard') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('contract', 'Contract', 'class="nav-link '.(($name == 'contract') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('address', 'Delivery Address', 'class="nav-link '.(($name == 'address') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('company', 'Company', 'class="nav-link '.(($name == 'company') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('product', 'Product', 'class="nav-link '.(($name == 'product') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('packing', 'Packing', 'class="nav-link '.(($name == 'packing') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('payment', 'Payment', 'class="nav-link '.(($name == 'payment') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('invoice', 'Invoice', 'class="nav-link '.(($name == 'invoice') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('credit-notes', 'Credit notes', 'class="nav-link '.(($name == 'credit-notes') ? 'active' : '').'"') ?>
              </li>
              <li class="nav-item">
                <?= anchor('debit-notes', 'Debit notes', 'class="nav-link '.(($name == 'debit-notes') ? 'active' : '').'"') ?>
              </li>
            </ul>
          </div>
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
              <li class="nav-item dropdown">
                <?= anchor('#', '<i class="far fa-user"></i>', 'class="nav-link" data-toggle="dropdown" aria-expanded="false"') ?>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                  <span class="dropdown-header"><?= anchor('profile', 'Account Details', 'class="dropdown-item"') ?></span>
                  <div class="dropdown-divider"></div>
                  <?= anchor('profile', '<i class="fa fa-user mr-2"></i>'.ucwords($this->session->name), 'class="dropdown-item"') ?>
                  <div class="dropdown-divider"></div>
                  <?= anchor('profile', '<i class="fa fa-envelope mr-2"></i>'.$this->session->email, 'class="dropdown-item"') ?>
                  <div class="dropdown-divider"></div>
                  <?= anchor('profile', '<i class="fa fa-phone mr-2"></i>'.$this->session->mobile, 'class="dropdown-item"') ?>
                  <div class="dropdown-divider"></div>
                  <?= anchor('logout', 'Log Out', 'class="dropdown-item dropdown-footer"') ?>
                </div>
              </li>
            </ul>
        </div>
      </nav>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?= ucwords($title) ?></h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item">
                    <?= anchor('', 'Home', '') ?>
                  </li>
                  <li class="breadcrumb-item <?= (!empty($operation)) ? '' : 'active' ?> ">
                    <?= (!empty($operation)) ? anchor($url, ucwords($title), '') : ucwords($title) ?>
                  </li>
                  <?php if (!empty($operation)): ?>
                  <li class="breadcrumb-item active">
                    <?= ucwords($operation) ?>
                  </li>
                  <?php endif ?>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
          <div class="container-fluid">
            <?php if ($this->session->success): ?>
            <div class="alert alert-success alert-messages">
              <?= $this->session->success ?>
            </div>
            <?php endif ?>
            <?php if ($this->session->error): ?>
            <div class="alert alert-danger alert-messages">
              <?= $this->session->error ?>
            </div>
            <?php endif ?>
            <?= $contents ?>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
    <script src="<?= assets('plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= assets('plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    
    <?php if (isset($dataTables)): ?>
    <script src="<?= assets('plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= assets('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= assets('plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= assets('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
    <script src="<?= assets('plugins/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/datatables/dataTables.buttons.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/datatables/pdfmake.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/datatables/vfs_fonts.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/datatables/buttons.html5.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/datatables/buttons.print.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/datatables/buttons.colVis.min.js') ?>"></script>
    <script type="text/javascript" src="<?= assets('plugins/jszip/jszip.min.js') ?>"></script>
    <?php endif ?>

    <?php if (isset($select)): ?>
    <script src="<?= assets('plugins/select2/js/select2.full.min.js') ?>"></script>
    <script type="text/javascript"> $('.select2').select2() </script>
    <?php endif ?>

    <?php if (isset($inputmask)): ?>
    <script src="<?= assets('plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= assets('plugins/inputmask/min/jquery.inputmask.bundle.min.js') ?>"></script>
    <script type="text/javascript"> $('[data-mask]').inputmask() </script>
    <?php endif ?>

    <?php if (isset($chart)): ?>
      <script src="<?= assets('plugins/flot/jquery.flot.js') ?>"></script>
      <script type="text/javascript" charset="utf-8" async defer>
        var bar_data = {
            data : [[1,"<?= $chart_data->January ?>"], [2,"<?= $chart_data->February ?>"], [3,"<?= $chart_data->March ?>"], [4,"<?= $chart_data->April ?>"], [5,"<?= $chart_data->May ?>"], [6,"<?= $chart_data->June ?>"], [7,"<?= $chart_data->July ?>"], [8,"<?= $chart_data->August ?>"], [9,"<?= $chart_data->September ?>"], [10,"<?= $chart_data->October ?>"], [11,"<?= $chart_data->November ?>"], [12,"<?= $chart_data->December ?>"]],
            bars: { show: true }
          }

        $.plot('#bar-chart', [bar_data], {
          grid  : {
            borderWidth: 1,
            borderColor: '#f3f3f3',
            tickColor  : '#f3f3f3',
            hoverable: true
          },
          series: {
             bars: {
              show: true, barWidth: 0.5, align: 'center',
            },
          },
          colors: ['#069a4a'],
          xaxis : {
            ticks: [[1,'January'], [2,'February'], [3,'March'], [4,'April'], [5,'May'], [6,'June'], [7,'July'], [8,'August'], [9,'September'], [10,'October'], [11,'November'], [12,'December']]
          }
        });
      </script>
    <?php endif ?>

    <script src="<?= assets('dist/js/adminlte.min.js') ?>"></script>
    <?php if (isset($dateFilter)): ?>
    <script src="<?= assets('plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= assets('plugins/daterangepicker/daterangepicker.js') ?>"></script>
    <script src="<?= assets('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
    <?php endif ?>
    <?php $this->load->view('script') ?>
  </body>
</html>