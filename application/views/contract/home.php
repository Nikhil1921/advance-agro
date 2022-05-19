<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <div class="row">
        <div class="col-sm-2">
          <h5 class="card-title m-0"><?= ucwords($title) ?> List</h5>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control float-right" id="date_filter">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="far fa-calendar-alt"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <?php $buyer = [0 => 'Select Buyer']; $seller = [0 => 'Select Seller']; foreach ($companies as $company):
          $buyer[$company['id']] = ucwords($company['company_name']);
          $seller[$company['id']] = ucwords($company['company_name']);
          endforeach ?>
          <?= form_dropdown('buyer_id', $buyer, 0,
          ['id' => 'buyer_id',
          'class' => 'form-control select2']) ?>
        </div>
        <div class="col-sm-2">
          <?= form_dropdown('seller_id', $seller, 0,
          ['id' => 'seller_id',
          'class' => 'form-control select2']) ?>
        </div>
        <div class="col-sm-2">
          <?php $prods = [0 => 'Select Product']; foreach ($products as $prod):
          $prods[$prod['id']] = ucwords($prod['name']);
          endforeach ?>
          <?= form_dropdown('prod_id', $prods, 0,
          ['id' => 'prod_id',
          'class' => 'form-control select2']) ?>
        </div>
        <div class="col-sm-1">
          <?= anchor($url.'/add', 'Add', 'class="btn btn-block btn-outline-success btn-sm"'); ?>
        </div>
      </div>
    </div>
    <div class="card-header d-flex p-0">
      <ul class="nav nav-pills ml-auto p-2">
        <li class="nav-item">
          <?= anchor('', 'Pending', 'class="nav-link active contract-status"'); ?>
        </li>
        <li class="nav-item">
          <?= anchor('', 'Completed', 'class="nav-link contract-status"'); ?>
        </li>
      </ul>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-striped table-hover datatable">
        <thead>
          <tr>
            <th class="target">Sr. No.</th>
            <th>Contract Date</th>
            <th>No.</th>
            <th>Buyer</th>
            <th class="target">Invoice</th>
            <th>Seller</th>
            <th class="target">Invoice</th>
            <th>Product</th>
            <th>Price</th>
            <th>Quantity</th>
            <th class="target">Brokerage</th>
            <th class="target">Loading Condition</th>
            <th class="target">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
<input type="hidden" id="status" value="Pending">
<div class="modal fade" id="uploadCertificate" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Upload Purity Certificate</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <?= form_open_multipart($url.'/upload') ?>
        <input type="hidden" name="contract_id" value="" id="contract_id">
        <div class="col-md-12">
          <div class="form-group">
            <?= form_label('Purity Certificate', 'certificate', ['class'=>'control-label']) ?>
            <div class="input-group">
              <div class="custom-file">
                <?= form_input([
                'type' => 'file',
                'name' => "certificate",
                'class' => "custom-file-input",
                'id' => "certificate"]) ?>
                <?= form_label('Purity Certificate', 'certificate', ['class'=>'custom-file-label']) ?>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <?= form_button([ 'content' => 'Save',
          'type'    => 'submit',
          'class'   => 'btn btn-primary']) ?>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>