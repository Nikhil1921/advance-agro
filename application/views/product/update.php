<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open($url.'/update') ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Product Name', 'name') ?>
            <?= form_input([
            'name' => "name",
            'class' => "form-control",
            'id' => "name",
            'placeholder' => "Enter Product Name",
            'value' => (!empty(set_value('name'))) ? set_value('name') : $data['name']
            ]) ?>
            <?= form_error('name') ?>
          </div>
        </div>
        <div class="col-md-6 mt-4">
          <?= form_button([ 'content' => 'Add Specification',
          'type'  => 'button',
          'onclick' => 'addSpec()',
          'class' => 'btn btn-outline-primary mt-2']) ?>
        </div>
        <div class="col-md-12">
          <div class="row" id="addSpec">
            <?php foreach (json_decode($data['specification']) as $k => $v): ?>
              <div class="col-md-5 specifications specification_<?= $k + 1 ?>">
              <div class="form-group">
                <?= form_label('Product Specification', 'specification_<?= $k + 1 ?>') ?>
                <?= form_input([
                  'name' => "specification[]",
                  'class' => "form-control",
                  'id' => "specification_<?= $k + 1 ?>",
                  'placeholder' => "Enter Specification",
                  'value' => $v
                  ]) ?>
              </div>
            </div>
            <div class="col-md-1 specifications specification_<?= $k + 1 ?>">
              <?= form_button([ 'content' => 'Remove Specification',
              'type'  => 'button',
              'onclick' => 'removeSpec(\'specification_'.($k + 1).'\')',
              'class' => 'btn btn-outline-danger mt-2']) ?>
            </div>
            <?php endforeach ?>
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