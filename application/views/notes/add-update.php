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
          <div class="col-2">
            <div class="form-group">
              <label>Actual rate</label>
              <input type="text" class="form-control" name="actual" value="<?= set_value('actual') ?>" />
              <?= form_error('actual') ?>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Settled rate</label>
              <input type="text" class="form-control" name="settled" value="<?= set_value('settled') ?>" />
              <?= form_error('settled') ?>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" class="form-control" name="quantity" value="<?= set_value('quantity') ?>" />
              <?= form_error('quantity') ?>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Brokerage Percentage</label>
              <input type="text" class="form-control" name="brokerage" value="<?= set_value('brokerage') ?>" />
              <?= form_error('brokerage') ?>
            </div>
          </div>
          <div class="col-2">
            <div class="form-group">
              <label>Brokerage</label>
              <input type="text" class="form-control" name="brok_price" value="<?= set_value('brok_price') ?>" />
              <?= form_error('brok_price') ?>
            </div>
          </div>
          <div class="col-1">
            <div class="form-group">
              <label>Note type</label>
              <select name="note_type" id="note_type" class="form-control">
                <option value="Credit" <?= set_select('note_type', 'Credit') ?>>Credit</option>
                <option value="Debit" <?= set_select('note_type', 'Debit') ?>>Debit</option>
              </select>
            </div>
          </div>
          <div class="col-1">
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
            <div class="container">
              <div class="row">
                <div class="col-12 text-center">
                  <h2 style="text-transform: uppercase;">
                  Advance Agri Brokers<br><?= $print['note_type'] ?> Note
                  </h2>
                  <span>subject to Unjha jurisdiction</span>
                </div>
              </div>
              <div class="row invoice-info">
                <div class="col-sm-3 invoice-col" style="border: 1px solid #dee2e6">
                  To
                  <address>
                    <?php $buyer = $this->main->get('company', 'company_name, city, contact_person', ['id' => $data['buyer']]) ?>
                    <strong><?= $buyer['company_name'] ?></strong><br>
                    <?= $buyer['city'] ?><br>
                  </address>
                </div>
                <div class="col-sm-2 offset-7 " >
                  <div class="col-sm-12 float-right">
                    <img class="logo" src="<?= base_url('assets/images/logo.png') ?>" width="100%">
                    <div class="float-right mt-2" style="border: 1px solid #dee2e6; padding: 5px;">
                      <span>Date: <?= (isset($print)) ? date("d-m-Y", $print['created_at']) :  '#00000' ?></span>
                      <span>Bill-No: <?= (isset($print)) ? $print['id'].'/'.  date("m-Y", $print['created_at']) :  '#00000' ?></span></div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <table class="table table-bordered mt-5" style="text-transform: uppercase;">
                      <thead>
                        <tr>
                          <th style="width: 100%;" colspan="8" class="text-center">DESCRIPTION</th>
                          <th style="width: 100%;" class="text-center">TOTAL AMT</th>
                        </tr>
                        <tr height="50">
                          <td style="width: 100%; padding: 3% 0;" colspan="8" class="text-center">FOLLOWING AMOUNT TO BE <?= $print['note_type'] ?> TO YOUR ACCOUNT TOWARDS BELOW DETAILS:</td>
                          <th style="width: 100%;" class="text-center"></th>
                        </tr>
                        <tr>
                          <th style="width: 80px;">CONTRACT DATE</th>
                          <th>CONTRACT NO.</th>
                          <th>PARTY NAME</th>
                          <th>TOTAL QTY</th>
                          <th>ACTUAL RATE</th>
                          <th>SETTLED RATE</th>
                          <th>DIFF</th>
                          <th>TOTAL</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td style="width: 80px;"><?= date("d-m-Y", strtotime($data['contract_date'])) ?></td>
                          <td><?= $data['contact_id'] ?></td>
                          <td><?= $buyer['contact_person'] ?></td>
                          <td><?= $print['quantity'] ?> <?= $data['quantity_type'] ?></td>
                          <td>BUY <?= $print['actual'] ?> / 20 kg</td>
                          <td>SELL <?= $print['settled'] ?> / 20 kg</td>
                          <td><?= $diff = abs($print['actual'] - $print['settled']) ?> / 20 kg</td>
                          <td><?= $total = $diff * $print['quantity'] * 50 ?>/-</td>
                          <td><?= $total ?>/-</td>
                        </tr>
                        <tr>
                          <td style="width: 100%;" colspan="7"><strong>BROKERAGE :-</strong> <?= number_format($print['brokerage'], 2, '.', '') ?> % OF BILL VALUE</td>
                          <td style="width: 100%;" class="text-center"><?= $print['brok_price'] ?>/-</td>
                          <td style="width: 100%;" class="text-center"><?= $print['brok_price'] ?>/-</td>
                        </tr>
                        <tr height="200">
                          <td style="width: 100%; padding: 7% 1%;" colspan="8">(THIS CONTRACT IS SETTLED FROM YOUR KIND WORDS)</td>
                          <td style="width: 100%;" class="text-center"></td>
                        </tr>
                        <tr>
                          <td style="width: 100%;" colspan="8">IN WORDS: <span id="op"></span> </td>
                          <td style="width: 100%;" class="text-center"><?= $total - $print['brok_price'] ?>/-</td>
                          <input type="hidden" id="total" value="<?= $total - $print['brok_price'] ?>">
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-6">
                  </div>
                  <div class="col-3 offset-3">
                    <div class="text-left pt-5 text-center">
                      <p style="text-transform: uppercase;"><b>THANK YOU</b></p>
                      <p style="text-transform: uppercase;"><b>Advance Agri Brokers </b></p>
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

    <script>
      function Rs(amount){
        var words = new Array();
        words[0] = 'Zero';words[1] = 'One';words[2] = 'Two';words[3] = 'Three';words[4] = 'Four';words[5] = 'Five';words[6] = 'Six';words[7] = 'Seven';words[8] = 'Eight';words[9] = 'Nine';words[10] = 'Ten';words[11] = 'Eleven';words[12] = 'Twelve';words[13] = 'Thirteen';words[14] = 'Fourteen';words[15] = 'Fifteen';words[16] = 'Sixteen';words[17] = 'Seventeen';words[18] = 'Eighteen';words[19] = 'Nineteen';words[20] = 'Twenty';words[30] = 'Thirty';words[40] = 'Forty';words[50] = 'Fifty';words[60] = 'Sixty';words[70] = 'Seventy';words[80] = 'Eighty';words[90] = 'Ninety';var op;
        amount = amount.toString();
        var atemp = amount.split('.');
        var number = atemp[0].split(',').join('');
        var n_length = number.length;
        var words_string = '';
        if(n_length <= 9){
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++){
        received_n_array[i] = number.substr(i, 1);}
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++){
        n_array[i] = received_n_array[j];}
        for (var i = 0, j = 1; i < 9; i++, j++){
        if(i == 0 || i == 2 || i == 4 || i == 7){
        if(n_array[i] == 1){
        n_array[j] = 10 + parseInt(n_array[j]);
        n_array[i] = 0;}}}
        value = '';
        for (var i = 0; i < 9; i++){
        if(i == 0 || i == 2 || i == 4 || i == 7){
        value = n_array[i] * 10;} else {
        value = n_array[i];}
        if(value != 0){
        words_string += words[value] + ' ';}
        if((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)){
        words_string += 'Crores ';}
        if((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)){
        words_string += 'Lakhs ';}
        if((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)){
        words_string += 'Thousand ';}
        if(i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)){
        words_string += 'Hundred and ';} else if(i == 6 && value != 0){
        words_string += 'Hundred ';}}
        words_string = words_string.split(' ').join(' ');}
        return words_string;
      }

      function RsPaise(n){
        nums = n.toString().split('.')
        var whole = Rs(nums[0])
        if(nums[1]==null)nums[1]=0;
        if(nums[1].length == 1 )nums[1]=nums[1]+'0';
        if(nums[1].length> 2){nums[1]=nums[1].substring(2,length - 1)}
        if(nums.length == 2){
        if(nums[0]<=9){nums[0]=nums[0]*10} else {nums[0]=nums[0]};
        var fraction = Rs(nums[1])
        if(whole=='' && fraction==''){op= 'Zero only';}
        if(whole=='' && fraction!=''){op= 'paise ' + fraction + ' only';}
        if(whole!='' && fraction==''){op='Rupees ' + whole + ' only';} 
        if(whole!='' && fraction!=''){op='Rupees ' + whole + 'and paise ' + fraction + ' only';}
        amt=parseInt(document.getElementById('total').value);
        if(amt > 999999999.99){op='Oops!!! The amount is too big to convert';}
        if(isNaN(amt) == true ){op='Error : Amount in number appears to be incorrect. Please Check.';}
        document.getElementById('op').innerHTML=op;}
      }
      RsPaise(Math.round(parseInt(document.getElementById('total').value)*100)/100);
    </script>