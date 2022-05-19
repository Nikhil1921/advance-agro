<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Company Name') ?>
            <?= form_input([
            'class' => "form-control",
            'value' => $data['company_name'],
            'readonly' => 'readonly'
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Contact Person') ?>
            <?= form_input([
            'class' => "form-control",
            'value' => $data['contact_person'],
            'readonly' => 'readonly'
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Contact No.') ?>
            <?= form_input([
            'readonly' => 'readonly',
            'class' => "form-control",
            'value' => $data['contact_no']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Contact Email', 'contact_email') ?>
            <?= form_input([
            'readonly' => 'readonly',
            'class' => "form-control",
            'value' => $data['contact_email']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Address') ?>
            <?= form_textarea([
            'readonly' => 'readonly',
            'class' => "form-control",
            'rows' => 3,
            'value' => $data['address']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('City') ?>
            <?= form_input([
            'readonly' => 'readonly',
            'class' => "form-control",
            'value' => $data['city']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('GST No.') ?>
            <?= form_input([
            'readonly' => 'readonly',
            'class' => "form-control",
            'value' => $data['gst_no']
            ]) ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('PAN No.') ?>
            <?= form_input([
            'readonly' => 'readonly',
            'class' => "form-control",
            'value' => $data['pan_no']
            ]) ?>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer">
      <div class="row">
        <div class="col-md-6">
          <?= anchor($url, 'Go Back', 'class="btn btn-outline-danger col-md-4"'); ?>
        </div>
      </div>
    </div>
  </div>
</div>