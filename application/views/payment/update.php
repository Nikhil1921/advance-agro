<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open($url.'/update') ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <?= form_label('Payment', 'payment') ?>
            <?= form_textarea([
            'name' => "payment",
            'class' => "form-control",
            'id' => "payment",
            'placeholder' => "Enter Payment",
            'value' => (!empty(set_value('payment'))) ? set_value('payment') : $data['payment']
            ]) ?>
            <?= form_error('payment') ?>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <?= form_button([ 'content' => 'Save',
          'type'  => 'submit',
          'class' => 'btn btn-outline-primary col-md-4']) ?>
        </div>
        <div class="col-md-6">
          <?= anchor($url, 'Cancel', 'class="btn btn-outline-danger col-md-4"'); ?>
        </div>
      </div>
    </div>
    <?= form_close() ?>
  </div>
</div>