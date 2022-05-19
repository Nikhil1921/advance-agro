<div class="row">
  <div class="col-md-4">
    <div class="card card-success card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <?= img(['src' => 'assets/images/logo.png', 'alt' => '', 'class' => 'profile-user-img img-fluid img-circle']) ?>
        </div>
        <h3 class="profile-username text-center">Update Profile</h3>
        <p class="text-muted text-center"></p>
        <?= form_open('profile') ?>
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Profile Name</b>
            <?= form_input([
            'type' => 'text',
            'name' => 'name',
            'class' => 'form-control',
            'placeholder' => 'Enter Profile Name',
            'value' => $this->session->name
            ]) ?>
            <?= form_error('name') ?>
          </li>
          <li class="list-group-item">
            <b>Mobile No.</b>
            <?= form_input([
            'type' => 'text',
            'name' => 'mobile',
            'class' => 'form-control',
            'placeholder' => 'Enter Mobile No.',
            'value' => $this->session->mobile,
            'maxlength' => '10'
            ]) ?>
            <?= form_error('mobile') ?>
          </li>
          <li class="list-group-item">
            <b>Email Address</b>
            <?= form_input([
            'type' => 'email',
            'name' => 'email',
            'class' => 'form-control',
            'placeholder' => 'Enter Email Address',
            'value' => $this->session->email
            ]) ?>
            <?= form_error('email') ?>
          </li>
        </ul>
        <?= form_button([ 'content' => '<b>Update Profile</b>',
        'type'  => 'submit',
        'class' => 'btn btn-outline-primary btn-block']) ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-success card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <?= img(['src' => 'assets/images/logo.png', 'alt' => '', 'class' => 'profile-user-img img-fluid img-circle']) ?>
        </div>
        <h3 class="profile-username text-center">Send Greetings</h3>
        <p class="text-muted text-center"></p>
        <?= form_open('greetings') ?>
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Greetings</b>
            <?= form_textarea([
            'name' => 'greetings',
            'rows' => 8,
            'class' => 'form-control',
            'placeholder' => 'Enter Greetings',
            'value' => set_value('greetings')
            ]) ?>
            <?= form_error('greetings') ?>
          </li>
        </ul>
        <?= form_button([ 'content' => '<b>Send Greetings</b>',
        'type'  => 'submit',
        'class' => 'btn btn-outline-primary btn-block']) ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-success card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <?= img(['src' => 'assets/images/logo.png', 'alt' => '', 'class' => 'profile-user-img img-fluid img-circle']) ?>
        </div>
        <h3 class="profile-username text-center">Change Brokerage</h3>
        <p class="text-muted text-center"></p>
        <?= form_open('brokerage') ?>
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Brokerage</b>
            <?= form_input([
            'type' => 'text',
            'name' => 'brokerage',
            'class' => 'form-control',
            'placeholder' => 'Enter Brokerage in %',
            'maxlength' => 5,
            'value' => $this->main->check('brokerage', ['id' => 1], 'Brokerage')
            ]) ?>
            <?= form_error('brokerage') ?>
          </li>
        </ul>
        <?= form_button([ 'content' => '<b>Change Brokerage</b>',
        'type'  => 'submit',
        'class' => 'btn btn-outline-primary btn-block']) ?>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>