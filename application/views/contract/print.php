<!-- <link rel="stylesheet" type="text/css" href="<?= assets('dist/css/print.css') ?>"> -->
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
			<table>
				<tbody>
					<tr>
						<td>SELLER </td>
						<td> : </td>
						<td><?= $data['seller'] ?><br>
							<?= $data['seller_address'] ?>
						</td>
						<td>
							<table class="contract">
								<tbody>
									<tr>
										<td>CONTRACT NOTE <hr> </td>
									</tr>
									<tr>
										<td>NO.:<?= date("Y").$data['id'] ?> <br>
										DATE:<?= date("d/m/Y") ?></td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
					<tr>
						<td>CITY  </td>
						<td> : </td>
						<td><?= $data['seller_city'] ?> </td>
					</tr>
					<tr>
						<td>GSTIN NO </td>
						<td> : </td>
						<td><?= $data['seller_gst_no'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>BUYER </td>
						<td> : </td>
						<td><?= $data['buyer'] ?><br>
							<?= $data['buyer_address'] ?>
						</td>
					</tr>
					<tr>
						<td>CITY  </td>
						<td> : </td>
						<td><?= $data['buyer_city'] ?>  </td>
					</tr>
					<tr>
						<td>GSTIN NO </td>
						<td> : </td>
						<td><?= $data['buyer_gst_no'] ?> </td>
					</tr>
					<tr>
						<td>PAN NO </td>
						<td> : </td>
						<td><?= $data['buyer_pan_no'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>PRODUCT <br>SPECIFICATION </td>
						<td> : </td>
						<td><?= $data['product'] ?><br>
							<?= $data['specification'] ?>
						</td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>QUANTITY</td>
						<td> : </td>
						<td><?= $data['quantity'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>PRICE</td>
						<td> : </td>
						<td><?= $data['price'] ?> PER M. TONES FOR MUNDRA</td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>PACKING</td>
						<td> : </td>
						<td><?= $data['packing'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>DELIVERY AT</td>
						<td> : </td>
						<td><?= $data['delivery'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>LOADING CONDITION</td>
						<td> : </td>
						<td><?= $data['conditions'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>PAYMENT</td>
						<td> : </td>
						<td><?= $data['payment'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>BROKERAGE</td>
						<td> : </td>
						<td><?= $data['brokerage'] ?></td>
					</tr>
					<tr>
						<td colspan="4"><hr></td>
					</tr>
					<tr>
						<td>OTHER TERMS</td>
						<td> : </td>
						<?php if ($data['other_terms'] == 'Not Applicable'): ?>
						<td><?= $data['other_terms'] ?></td>
						<?php else: ?>
						<td>
							<?php foreach (json_decode($data['other_terms']) as $key => $value):
								echo $value.'<br />';
							endforeach ?>
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
						<td>[] FROM AS PER REQUIREMENT & BILL LEADING MUST ON PER BILL.</td>
					</tr>
					<tr>
						<td>[] WE HAVE FULL POWER TO SETTLE ALL CLAIMS AMICABLY WILL BIND BOTH BUYER AND SELLER EQUALLY.
						</td>
					</tr>
					<tr>
						<td>[] BARGAINS MUST BE DESPATCHED IN TIME & ACCORDING TO CONDITION.</td>
					</tr>
					<tr>
						<td>[] AFTER DESPATCHING OF BARGAINS INTIMATION MUST BE GIVE TO US.</td>
					</tr>
					<tr>
						<td>[] IF ANY BARGAIN CANCELLED DUE TO ANY TIME LIMIT LOADING CONDITION OR ANY GOVT. RESTRICTION OUR BROKERAGE WILL BE CHARGED USUALLY.</td>
					</tr>
					<tr>
						<td>[] THIS CONTRACT SUBJECT TO RESPONSIBILITY OF BOTH PARTIES AND EFFECTED AS A BROKER OF BOTH PARTIES WITHOUT ANY LIABILITIES.</td>
					</tr>
				</tbody>
			</table>
			<br>
			<div class="thanks">
				ADVANCE AGRO <br>
				414, Lilamani Corporate Heights,<br> opp. Ramdev Tekra BRTS, Nava Vadaj <br>
				PH: (012) 3456 789 <br>
				MOBILE: 123567890 <br>
				E-Mail : advance-agro@gmail.com
				<div class="signature">
					For ADVANCE AGRO <br>
					<?= img(['src' => 'assets/images/sign.png', 'alt' => '', 'class' => 'logo']) ?>
					<br>
					AUTHORISED SIGNATURE
				</div>
			</div>
		</main>
	</div>
</div>