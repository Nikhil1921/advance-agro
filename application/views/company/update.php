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
                        <?= form_label('Company Name', 'company_name') ?>
                        <?= form_input([
                        'name' => "company_name",
                        'class' => "form-control",
                        'id' => "company_name",
                        'placeholder' => "Enter Company Name",
                        'value' => (!empty(set_value('company_name'))) ? set_value('company_name') : $data['company_name']
                        ]) ?>
                        <?= form_error('company_name') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('Contact Person', 'contact_person') ?>
                        <?= form_input([
                        'name' => "contact_person",
                        'class' => "form-control",
                        'id' => "contact_person",
                        'placeholder' => "Enter Contact Person",
                        'value' => (!empty(set_value('contact_person'))) ? set_value('contact_person') : $data['contact_person']
                        ]) ?>
                        <?= form_error('contact_person') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('Contact No.', 'contact_no') ?>
                        <?= form_input([
                        'name' => "contact_no",
                        'class' => "form-control",
                        'id' => "contact_no",
                        'maxlength' => 10,
                        'placeholder' => "Enter Contact No.",
                        'value' => (!empty(set_value('contact_no'))) ? set_value('contact_no') : $data['contact_no']
                        ]) ?>
                        <?= form_error('contact_no') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('Contact Email', 'contact_email') ?>
                        <?= form_input([
                        'name' => "contact_email",
                        'class' => "form-control",
                        'id' => "contact_email",
                        'placeholder' => "Enter Contact Email",
                        'value' => (!empty(set_value('contact_email'))) ? set_value('contact_email') : $data['contact_email']
                        ]) ?>
                        <?= form_error('contact_email') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('Address', 'address') ?>
                        <?= form_textarea([
                        'name' => "address",
                        'class' => "form-control",
                        'id' => "address",
                        'rows' => 3,
                        'placeholder' => "Enter Address",
                        'value' => (!empty(set_value('address'))) ? set_value('address') : $data['address']
                        ]) ?>
                        <?= form_error('address') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('City', 'city') ?>
                        <?= form_input([
                        'name' => "city",
                        'class' => "form-control",
                        'id' => "city",
                        'placeholder' => "Enter City",
                        'value' => (!empty(set_value('city'))) ? set_value('city') : $data['city']
                        ]) ?>
                        <?= form_error('city') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('GST No.', 'gst_no') ?>
                        <?= form_input([
                        'name' => "gst_no",
                        'class' => "form-control",
                        'id' => "gst_no",
                        'maxlength' => 20,
                        'placeholder' => "Enter GST No.",
                        'value' => ((!empty(set_value('gst_no'))) ? set_value('gst_no') : ($data['gst_no'] != 'Not Given')) ? $data['gst_no'] : ''
                        ]) ?>
                        <?= form_error('gst_no') ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= form_label('PAN No.', 'pan_no') ?>
                        <?= form_input([
                        'name' => "pan_no",
                        'class' => "form-control",
                        'id' => "pan_no",
                        'maxlength' => 10,
                        'placeholder' => "Enter PAN No.",
                        'value' => ((!empty(set_value('pan_no'))) ? set_value('pan_no') : ($data['pan_no'] != 'Not Given')) ? $data['pan_no'] : ''
                        ]) ?>
                        <?= form_error('pan_no') ?>
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
</div>