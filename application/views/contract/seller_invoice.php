<div class="invoice overflow-auto">
	<div style="min-width: 600px">
		<header>
			<div class="row">
				<div class="col company-details">
					<h2 class="name">
					<?= img(['src' => 'assets/images/logo.png', 'alt' => '', 'class' => 'logo']) ?>
					</h2>
				</div>
			</div>
		</header>
		<main>
			<table style="margin-bottom: 10px;">
				<tbody>
					<tr>
						<td><strong>SELLER</strong></td>
						<td> : </td>
						<td><strong><?= $data['seller'] ?></strong><br>
							<?= $data['seller_address'] ?>
						</td>
						<td>
							<table class="contract">
								<tbody>
									<tr>
										<td>CONTRACT NOTE <hr> </td>
									</tr>
									<tr>
										<td>NO.:<?= date('Y', strtotime($data['contract_date'])).$data['id'] ?> <br>
										DATE:<?= date("d/m/Y", strtotime($data['contract_date'])) ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td><strong>CITY </strong> </td>
						<td> : </td>
						<td colspan="2"><strong><?= $data['seller_city'] ?></strong> </td>
					</tr>
					<tr>
						<td><strong>GSTIN NO</strong> </td>
						<td> : </td>
						<td colspan="2"><?= $data['seller_gst_no'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>BUYER </strong></td>
						<td> : </td>
						<td colspan="2"><strong><?= $data['buyer'] ?></strong><br>
							<?= $data['buyer_address'] ?>
						</td>
					</tr>
					<tr>
						<td><strong>CITY</strong>  </td>
						<td> : </td>
						<td colspan="2"><strong><?= $data['buyer_city'] ?></strong>  </td>
					</tr>
					<tr>
						<td><strong>GSTIN NO </strong></td>
						<td> : </td>
						<td colspan="2"><?= $data['buyer_gst_no'] ?> </td>
					</tr>
					<tr>
						<td><strong>PAN NO </strong></td>
						<td> : </td>
						<td colspan="2"><?= $data['buyer_pan_no'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>PRODUCT <br>SPECIFICATION </strong></td>
						<td> : </td>
						<td colspan="2"><?= $data['product'] ?><br>
							<?php $spec = ''; foreach (json_decode($data['specification']) as $k => $v): 
								$spec .= str_replace("_", " ", $k).' - '.$v.'<br>';
							 endforeach ?>
							<?= $spec ?>
						</td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>QUANTITY</strong></td>
						<td> : </td>
						<td colspan="2"><strong><?= $data['quantity'] ?></strong></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>PRICE</strong></td>
						<td> : </td>
						<td colspan="2"><strong><?= $data['price'] ?> PER M.T. FOR MUNDRA</strong></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>PACKING</strong></td>
						<td> : </td>
						<td colspan="2"><?= $data['packing'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>DELIVERY AT</strong></td>
						<td> : </td>
						<td colspan="2"><?= $data['delivery'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>LOADING CONDITION</strong></td>
						<td> : </td>
						<td colspan="2"><?= $data['conditions'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>PAYMENT</strong></td>
						<td> : </td>
						<td colspan="2"><?= $this->main->check('payment', ['id' => $data['payment']], 'payment') ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>BROKERAGE</strong></td>
						<td> : </td>
						<td colspan="2"><strong><?= $data['brokerage'] ?> % OF BILL VALUE</strong></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td><strong>OTHER TERMS</strong></td>
						<td> : </td>
						<?php if ($data['other_terms'] == 'Not Applicable'): ?>
						<td colspan="2"><strong><?= $data['other_terms'] ?></strong></td>
						<?php else: ?>
						<td colspan="2"><strong>
							<?php foreach (json_decode($data['other_terms']) as $key => $value):
								echo $value.'<br />';
							endforeach ?></strong>
						</td>
						<?php endif ?>
					</tr>
				</tbody>
			</table>

			<table>
				<tbody>
					<tr>
						<td><b><u>TERMS AND CONDITIONS</u></b></td>
					</tr>
					<tr>
						<td><strong style="color: red;">*</strong> REQUIREMENT &amp; BILL LADING MUST ON PER BILL.</td>
					</tr>
					<tr>
						<td><strong style="color: red;">*</strong> WE HAVE FULL POWER TO SETTEL ALL CLAIMS AMICABLY WILL BIND BOTH BUYER AND SELLER EQUALITY.
						</td>
					</tr>
					<tr>
						<td><strong style="color: red;">*</strong> CONTRACT MUST BE DESPATCHED IN TIME & ACCORDING TO CONDITIONS.</td>
					</tr>
					<tr>
						<td><strong style="color: red;">*</strong> SHOULD THE SELLERS FAILS TO DELIVER THE CONTRACTED GOODS OR EFFECT SHIPMENT IN TIME BY REASON OF FORCE MAJEURE BEYOND THEIR CONTROL, THE TIME OF SHIPMENT MIGHT BE DULY EXTENDED.</td>
					</tr>
					<tr>
						<td><strong style="color: red;">*</strong> AFTER DESPATCHING OF CONTRACTED GOODS INTIMATION MUST BE GIVEN TO US.</td>
					</tr>
					<tr>
						<td><strong style="color: red;">*</strong> IF ANY CONTRACT CANCELLED DUE TO ANY TIME LIMIT LOADING OR ANY GOVT.RESTRICTIONS OUR BROKERAGE WILL BE CHARGED AS USUALLY.</td>
					</tr>
					<tr>
						<td>
							<strong style="color: red;">*</strong> GST WILL BE APPLIEID ON BROKERAGE.
						</td>
					</tr>
					<tr>
						<td>
							<strong style="color: red;">*</strong> ONCE CONTRACTED GOODS DESPACHED ALL RESPOSIBILIITES ON BOTH THE PARTIES AS PER CONTRACT.
						</td>
					</tr>
					<tr>
						<td>
							<strong style="color: red;">*</strong> IF SETTELMENT DONE BY BOTH PARTIES LIABILITIES MUST BE FULL-FILL WITHIN A TIME LIMIT OF CONTRACT CONDITIONS.
						</td>
					</tr>
				</tbody>
			</table>
			<br>
			<div class="thanks">
				<div class="signature">
					FOR ADVANCE AGRI BROKERS <br>
					<?= img(['src' => 'assets/images/sign.png', 'alt' => '', 'class' => 'logo']) ?>
					<br>
					AUTHORISED SIGNATURE
				</div>
			</div>
		</main>
	</div>
</div>