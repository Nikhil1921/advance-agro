<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="card">
  <div class="card-body login-card-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <?= form_open('otp') ?>
    <div class="form-group">
      <div class="input-group">
      <?= form_input([
      'name' => 'otp',
      'class' => 'form-control',
      'placeholder' => 'Enter otp',
      'maxlength' => '6'
      ]) ?>
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-phone"></span>
        </div>
      </div>
    </div>
    <?= form_error('otp') ?>
    </div>
    <div class="row">
      <div class="col-12">
        <?= form_button([ 'content' => 'Sign in',
        'type'    => 'submit',
        'class'   => 'btn btn-primary btn-block']) ?>
      </div>
    </div>
    <?= form_close() ?>
  </div>
</div>