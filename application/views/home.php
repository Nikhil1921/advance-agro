<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<div class="row">
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor('address',
		'<div class="info-box">
			<span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Delivery Address</span>
				<span class="info-box-number">'.$this->main->count('address', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor('company',
		'<div class="info-box mb-3">
			<span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Company</span>
				<span class="info-box-number">'.$this->main->count('company', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor('contract',
		'<div class="info-box mb-3">
			<span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Contract</span>
				<span class="info-box-number">'.$this->main->count('contract', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12 col-sm-6 col-md-3">
		<?= anchor('product',
		'<div class="info-box mb-3">
			<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Products</span>
				<span class="info-box-number">'.$this->main->count('product', ['is_deleted' => 0]).'</span>
			</div>
		</div>', 'class="text-dark"') ?>
	</div>
	<div class="col-12">
		<div class="card card-success card-outline">
			<div class="card-header">
				<h3 class="card-title">
				<i class="far fa-chart-bar"></i>
				&nbsp;
				Total Contracts of the Year.
				</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse">
					<i class="fas fa-minus"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<div id="bar-chart" style="height: 300px;"></div>
			</div>
		</div>
	</div>
</div>