<style type="text/css" >
@media print{
.letterpad{
min-height: 100vh;
}
.invoice{
min-height: 100%;
}
.bank-detail{
position: absolute;
/*left: 50px;*/
bottom: 250px;
font-size: 1em;
}
.total{
position: absolute;
/*left: 50px;*/
bottom: 450px;
}
.lead{
font-size: 2em;
}
.mar-gin{
margin-left:50px;
}
}
</style>
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <?php if (!isset($print)): ?>
      <div class="no-print">
        <?= form_open() ?>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Description of Goods</label>
              <input type="text" class="form-control" name="goods" value="<?= $this->session->goods ?>" required />
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Brokerage</label>
              <input type="text" class="form-control" name="brokerage" value="<?= $this->session->brokerage ?>" required />
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Date:</label>
              <div class="input-group date" id="create_date" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#create_date" name="create_date" id="create_date" value="<?= $this->session->create_date ?>" required data-toggle="datetimepicker" />
              </div>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <button class="btn btn-outline-success col-12 mt-4" type="submit">Save</button>
            </div>
          </div>
        </div>
        <?= form_close() ?>
      </div>
      <?php endif ?>
      <?php if (isset($update)): ?>
      <div class="no-print">
        <?= form_open($url."/update/".e_id($print['id'])) ?>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label>Description of Goods</label>
              <input type="text" class="form-control" name="goods" value="<?= $print['goods'] ?>" required />
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Brokerage</label>
              <input type="text" class="form-control" name="brokerage" value="<?= $print['brokerage'] ?>" required />
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Date:</label>
              <div class="input-group date" id="create_date" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#create_date" name="create_date" id="create_date" value="<?= date('m-d-Y', strtotime($print['create_date'])) ?>" required data-toggle="datetimepicker" />
              </div>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <button class="btn btn-outline-success col-12 mt-4" type="submit">Update</button>
            </div>
          </div>
        </div>
        <?= form_close() ?>
      </div>
      <?php endif ?>
    </div>
    <?php if (isset($print)): ?>
    <div class="row letterpad">
      
      <div class="invoice col-12">
        
        <img src="<?= base_url('assets/images/letterhead.png') ?>" style="position: absolute; height: 100%;">
        <div class=" p-3 mb-3 mar-gin">
          
          <!--                <div class="container">
            <div class="row">
              <div class="col-12 text-center">
                <h2>
                Advance Agri Brokers<br>Invoice
                </h2>
                <span>subject to Unjha jurisdiction</span>
              </div>
            </div>
            <div class="row invoice-info">
              <div class="col-sm-3 invoice-col" style="border:2px solid black">
                To
                <address>
                  <strong><?= $data['company_name'] ?></strong><br>
                  <?= $data['address'] ?><br>
                  <?= $data['city'] ?><br>
                  Phone: (+91) <?= $data['contact_no'] ?><br>
                  Email: <?= $data['contact_email'] ?>
                </address>
              </div>
              <div class="col-sm-2 offset-7 " >
                <div class="col-sm-12 float-right" style="border:2px solid black">
                  <img class="logo" src="<?= base_url('assets/images/logo.png') ?>" width="100%">
                  <span class="float-right">Date: <?= (isset($print)) ? date("d-m-Y", strtotime($print['create_date'])):  '#00000' ?></span>
                  <span class="float-right">Bill-No: <?= (isset($print)) ? $print['id'].'/'.  date("m-Y", strtotime($print['create_date'])):  '#00000' ?></span>
                </div>
              </div>
            </div>
            <div class="row border-bottom mt-5">
              
              <div class="col-4">
                <b>Sr. No.</b>
              </div>
              <div class="col-4">
                <b>Description of Goods</b>
              </div>
              <div class="col-4 text-right">
                <b>Brokerage</b>
              </div>
            </div>
            <div class="row border-bottom">
              <?php if (isset($print)): ?>
              <div class="col-4" style="border:2px solid black">
                <p>1</p>
              </div>
              <div class="col-4" style="border:2px solid black">
                <p><?= $print['goods'] ?></p>
              </div>
              <div class="col-4 text-right" style="border:2px solid black">
                <p>₹ <?= $print['brokerage'] ?></p>
              </div>
              <?php else: ?>
              <div class="col-12">
                No data
              </div>
              <?php endif ?>
            </div>
            <div class="row total" style="width:100%; border:2px solid black;">
              <div class="col-12 border-bottom text-right">
                <p>₹ <?= $print['brokerage'] ?></p>
              </div>
              
            </div>
            <div class="row bank-detail" style="width:60%; border:2px solid black;">
              <div class="col-12 border-bottom">
                <p class="lead">Bank Details</p>
              </div>
              <div class="col-6" >
                <div class="row border-bottom">
                  <div class="col-4">
                    <b>Benificiary:</b>
                  </div>
                  <div class="col-8">
                    Advance Agri Brokers
                  </div>
                </div>
                <div class="row border-bottom">
                  <div class="col-4">
                    <b>Bank:</b>
                  </div>
                  <div class="col-8">
                    HDFC Bank
                  </div>
                </div>
                <div class="row border-bottom">
                  <div class="col-4">
                    <b> Branch:</b>
                  </div>
                  <div class="col-8">
                    Station Road, Unjha
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="row border-bottom">
                  <div class="col-4">
                    <b>A/C No.:</b>
                  </div>
                  <div class="col-8">
                    50200056318442
                  </div>
                </div>
                <div class="row border-bottom">
                  <div class="col-4">
                    <b>IFSC:</b>
                  </div>
                  <div class="col-8">
                    HDFC0000179
                  </div>
                </div>
                <div class="row border-bottom">
                  <div class="col-4">
                    <b>PAN No.:</b>
                  </div>
                  <div class="col-8">
                    APKPP9855M
                  </div>
                </div>
              </div>
            </div> -->
            <div class="container">
              <div class="row">
                <div class="col-12 text-center">
                  <h2 style="text-transform: uppercase;">
                  Advance Agri Brokers<br>Invoice
                  </h2>
                  <span>subject to Unjha jurisdiction</span>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-sm-3 invoice-col" style="border: 1px solid #dee2e6">
                  To
                  <address>
                    <strong><?= $data['company_name'] ?></strong><br>
                    <?= $data['address'] ?><br>
                    <?= $data['city'] ?><br>
                    Phone: (+91) <?= $data['contact_no'] ?><br>
                    Email: <?= $data['contact_email'] ?>
                  </address>
                </div>
                <div class="col-sm-2 offset-7 " >
                  <div class="col-sm-12 float-right">
                    <img class="logo" src="<?= base_url('assets/images/logo.png') ?>" width="100%">
                    <div class="float-right mt-2" style="border: 1px solid #dee2e6; padding: 5px;">
                      <span>Date: <?= (isset($print)) ? date("d-m-Y", strtotime($print['create_date'])):  '#00000' ?></span>
                      <span>Bill-No: <?= (isset($print)) ? $print['id'].'/'.  date("m-Y", strtotime($print['create_date'])):  '#00000' ?></span></div>
                    </div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-12">
                    <table class="table table-bordered mt-5" style="text-transform: uppercase;">
                      <thead>
                        <tr>
                          <th style="width: 80px;">SR. NO.</th>
                          <th>Description of Goods</th>
                          <th>HSN Code.</th>
                          <th>Brokerage</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr style="height: 380px;">
                          <?php if (isset($print)): ?>
                          <td>1</td>
                          <td><?= $print['goods'] ?></td>
                          <td>997152</td>
                          <td>₹ <?= $print['brokerage'] ?></td>
                          <?php else: ?>
                          <td>No Data</td>
                          <?php endif ?>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><b>Total</b></td>
                          <td><b><p>₹ <?= $print['brokerage'] ?></p></b></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><b>CGST</b></td>
                          <td><b><p>₹ <?= round($print['brokerage'] * 0.09) ?></p></b></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><b>SGST</b></td>
                          <td><b><p>₹ <?= round($print['brokerage'] * 0.09) ?></p></b></td>
                        </tr>
                        <tr>
                          <td colspan="3" class="text-right"><b>Grand Total</b></td>
                          <td><b><p>₹ <?= round($print['brokerage'] * 1.18) ?></p></b></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-6">
                    <table class="table table-bordered mt-5" >
                      <thead>
                        <tr>
                          <th>Beneficiary:</th>
                          <td>Advance Agri Brokers</td>
                          <th>A/C No.:</th>
                          <td>50200056318442</td>
                        </tr>
                        <tr>
                          <th>Bank:</th>
                          <td>HDFC Bank</td>
                          <th>IFSC:</th>
                          <td>HDFC0000179</td>
                        </tr>
                        <tr>
                          <th>Branch:</th>
                          <td>Station Road, Unjha</td>
                          <th>PAN No.:</th>
                          <td>APKPP9855M</td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <div class="col-3 offset-2">
                    <div class="text-left pt-5">
                      <p>For</p>
                      <p style="text-transform: uppercase;"><b>Advance Agri Brokers </b></p>
                      <P style="text-transform: uppercase;"><b>Properitor</b></P>
                    </div>
                  </div>
                </div>
                <div class="row no-print">
                  <div class="col-12">
                    <a href="<?= base_url($url) ?>" class="btn btn-outline-danger float-right col-2 ml-2">Go back</a>
                    <a onclick="window.print();" class="btn btn-default float-right col-2"><i class="fas fa-print"></i> Print</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif ?>
      </section>
    </div>