<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="col-lg-12">
  <div class="card card-success card-outline">
    <div class="card-header">
      <h5 class="card-title m-0"><?= ucwords($operation).' '.ucwords($title) ?></h5>
    </div>
    <?= form_open($url.'/update', '', ['invoice' => $data['invoice'], 'contract_date' => $data['contract_date']]) ?>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <?php $comps = []; foreach ($companies as $company):
            $comps[$company['id']] = ucwords($company['company_name']);
            endforeach ?>
            <?= form_label('Buyer', 'buyer_id', ['class'=>'control-label']) ?>
            <?= form_dropdown('buyer_id', $comps, (!empty(set_value('buyer_id'))) ? set_value('buyer_id') : $data['buyer_id'],
            ['id' => 'buyer_id',
            'class' => 'form-control select2']) ?>
            <?= form_error('buyer_id') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Seller', 'seller_id', ['class'=>'control-label']) ?>
            <?= form_dropdown('seller_id', $comps, (!empty(set_value('seller_id'))) ? set_value('seller_id') : $data['seller_id'],
            ['id' => 'seller_id',
            'class' => 'form-control select2']) ?>
            <?= form_error('seller_id') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Product', 'prod_id', ['class'=>'control-label']) ?>
            <?php foreach ($products as $prod) $prods[$prod['id']] = ucwords($prod['name']) ?>
            <?= form_dropdown('prod_id', $prods, (!empty(set_value('prod_id'))) ? set_value('prod_id') : $data['product'],
            ['id' => 'prod_id',
            'class' => 'form-control select2 prod_id']) ?>
            <?= form_error('prod_id') ?>
          </div>
        </div>
        <div class="col-md-12">
          <div class="row showSpecs">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php $packs = []; foreach ($packing as $packing):
            $packs[$packing['id']] = ucwords($packing['packing']);
            endforeach ?>
            <?= form_label('Packing', 'packing_id', ['class'=>'control-label']) ?>
            <?= form_dropdown('packing_id', $packs, (!empty(set_value('packing_id'))) ? set_value('packing_id') : $data['packing'],
            ['id' => 'packing_id',
            'class' => 'form-control select2']) ?>
            <?= form_error('packing_id') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php $adds = []; foreach ($addresses as $address):
            $adds[$address['id']] = ucwords($address['address']);
            endforeach ?>
            <?= form_label('Delivery Address', 'address_id', ['class'=>'control-label']) ?>
            <?= form_dropdown('address_id', $adds, (!empty(set_value('address_id'))) ? set_value('address_id') : $data['delivery'],
            ['id' => 'address_id',
            'class' => 'form-control select2']) ?>
            <?= form_error('address_id') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Loading Condition', 'conditions') ?>
            <?= form_input([
            'name' => "conditions",
            'class' => "form-control",
            'id' => "conditions",
            'placeholder' => "Enter Loading Condition",
            'value' => (!empty(set_value('conditions'))) ? set_value('conditions') : $data['conditions']
            ]) ?>
            <?= form_error('conditions') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Quantity', 'quantity') ?>
            <?= form_input([
            'name' => "quantity",
            'class' => "form-control",
            'id' => "quantity",
            'placeholder' => "Enter Quantity",
            'value' => (!empty(set_value('quantity'))) ? set_value('quantity') : $data['quantity']
            ]) ?>
            <?= form_error('quantity') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php $quantity = ['M.T.' => 'M.T.']; ?>
            <?= form_label('Quantity Type', 'quantity_type', ['class'=>'control-label']) ?>
            <?= form_dropdown('quantity_type', $quantity, (!empty(set_value('quantity_type'))) ? set_value('quantity_type') : $data['quantity_type'],
            ['id' => 'quantity_type',
            'class' => 'form-control select2']) ?>
            <?= form_error('quantity_type') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Price', 'price') ?>
            <?= form_input([
            'name' => "price",
            'class' => "form-control",
            'id' => "price",
            'placeholder' => "Enter Price",
            'value' => (!empty(set_value('price'))) ? set_value('price') : $data['price']
            ]) ?>
            <?= form_error('price') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?php $payment = []; foreach ($payments as $pay):
            $payment[$pay['id']] = strtoupper($pay['payment']);
            endforeach ?>
            <?= form_label('Payment', 'payment', ['class'=>'control-label']) ?>
            <?= form_dropdown('payment', $payment, (!empty(set_value('payment'))) ? set_value('payment') : $data['payment'],
            ['id' => 'payment',
            'class' => 'form-control select2']) ?>
            <?= form_error('payment') ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <?= form_label('Brokerage', 'brokerage') ?>
            <?= form_input([
            'name' => "brokerage",
            'class' => "form-control",
            'id' => "brokerage",
            'placeholder' => "Enter Brokerage",
            'value' => (!empty(set_value('brokerage'))) ? set_value('brokerage') : $data['brokerage']
            ]) ?>
            <?= form_error('brokerage') ?>
          </div>
        </div>
        <?php $other_terms = ['AS PER GOVERNMENT RULE, "5% GST" EXTRA.', 'PLEASE SEND EXTRA 10 EMPTY BAG WITH CARGO.'] ?>
        <div class="col-sm-12">
          <?= form_label('Other Terms & Condition') ?>
          <?php foreach ($other_terms as $other_term): ?>
          <div class="form-group clearfix">
            <div class="icheck-primary d-inline">
              <?= form_checkbox([
              'name' => 'other_term[]',
              'id' => $other_term,
              'value' => $other_term,
              'checked' => (!empty(set_value('other_term[]'))) ? set_value('other_term[]') : (in_array($other_term, json_decode($data['other_terms'])))
              ]) ?>
              <?= form_label($other_term, $other_term, ['class'=>'control-label']) ?>
            </div>
          </div>
          <?php endforeach ?>
        </div>
        <?= form_error('other_terms') ?>
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