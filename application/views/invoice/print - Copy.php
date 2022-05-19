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
    <div class="row">
      <div class="col-12">
        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12 text-center">
              <h2>
              Invoice
              <small class="float-right">Date: <?= (isset($print)) ? date("d-m-Y", strtotime($print['create_date'])) :  date('d-m-Y') ?></small>
              </h2>
            </div>
          </div>
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              From
              <address>
                <strong>Advance Agri Brokers</strong><br>
                E-324, New market yard,<br>
                Unjha - 384170<br>
                Phone: (+91) 9825074439<br>
                Email: advanceagribrokers@gmail.com
              </address>
            </div>
            <div class="col-sm-3 invoice-col">
              To
              <address>
                <strong><?= $data['company_name'] ?></strong><br>
                <?= $data['address'] ?><br>
                <?= $data['city'] ?><br>
                Phone: (+91) <?= $data['contact_no'] ?><br>
                Email: <?= $data['contact_email'] ?>
              </address>
            </div>
          </div>
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Sr. No.</th>
                    <th>Description of Goods</th>
                    <th>Brokerage</th>
                  </tr>
                </thead>
                <tbody id="table-data">
                  <tr>
                    <?php if (isset($print)): ?>
                    <td>1</td>
                    <td><?= $print['goods'] ?></td>
                    <td>₹ <?= $print['brokerage'] ?></td>
                    <?php else: ?>
                    <td colspan="3" class="text-center">No data available</td>
                    <?php endif ?>
                  </tr>
                </tbody>
                <tfoot id="date-from">
                <tr>
                  <td colspan="2"></td>
                  <td class="text-left">Total : ₹ <?= (isset($print)) ? $print['brokerage'] : '0.00' ?></td></tr>
                  </tfoot>
                </table>
              </div>
            </div>
            <div class="row">
              <div class="col-6 offset-6">
                <p class="lead">Bank Details</p>
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <th style="width:50%">Benificiary:</th>
                        <td>Advance Agree Brokers</td>
                      </tr>
                      <tr>
                        <th style="width:50%">Bank:</th>
                        <td>HDFC Bank</td>
                      </tr>
                      <tr>
                        <th style="width:50%">Branch:</th>
                        <td>Station Road, Unjha</td>
                      </tr>
                      <tr>
                        <th style="width:50%">A/C No.:</th>
                        <td>500200056318442</td>
                      </tr>
                      <tr>
                        <th style="width:50%">IFSC:</th>
                        <td>HDFC0000179</td>
                      </tr>
                      <tr>
                        <th style="width:50%">PAN No.:</th>
                        <td>APKPP9855</td>
                      </tr>
                    </tbody>
                  </table>
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
    </section>
  </div>