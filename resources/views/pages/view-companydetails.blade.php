<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<style>
body{margin-top:20px;
background-color: #f7f7ff;
}
#invoice {
    padding: 0px;
}

.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #0d6efd
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #0d6efd
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #0d6efd;
    background: #e7f2ff;
    padding: 10px;
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,
.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th {
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px
}

.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #0d6efd;
    font-size: 1.2em
}

.invoice table .qty,
.invoice table .total,
.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #0d6efd
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #0d6efd;
    color: #fff
}

.invoice table tbody tr:last-child td {
    border: none
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}
.card {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 0px solid rgba(0, 0, 0, 0);
    border-radius: .25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
}

.invoice table tfoot tr:last-child td {
    color: #0d6efd;
    font-size: 1.4em;
    border-top: 1px solid #0d6efd
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px !important;
        overflow: hidden !important
    }
    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }
    .invoice>div:last-child {
        page-break-before: always
    }
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #0d6efd;
    background: #e7f2ff;
    padding: 10px;
}
</style>
<div class="container">
  <div class="card">
      <div class="card-body">
          <div id="invoice">
              <div class="toolbar hidden-print">
              
              <div class="invoice overflow-auto">
                  <div style="min-width: 600px">
                      <header>
                          <div class="row">
                              <div class="col">
                                  <a href="javascript:;">
                          <img src="assets/images/logo-icon.png" width="80" alt="">
                      </a>
                              </div>
                              <div class="col company-details">
                                  <h2 class="name">
                                      <a target="_blank" href="javascript:;">
                                      Company Name: {{$details->name}}  
                                      </a>
                                  </h2>
                                  <div>{{$details->shop_address}}</div>
                                  <div>{{$details->phone_number}}</div>
                                  <div>{{$details->email}}</div>
                                 
                              </div>
                          </div>
                      </header>
                      <main>
                          <div class="row contacts">
                             
                              
                          </div>
                          <table>
                              
                              <tbody>
                                  <tr>
                                      <td class="no">01</td>
                                      <td class="text-left">
                                          <h3>
                                              <a target="_blank" href="javascript:;">
                  Tin Number
                  </a>
                                          </h3>
                                         </td>
                                    
                                      <td class="total">{{$details->tinnumber}}</td>
                                  </tr>
                                  <tr>
                                    <tr>
                                      <td class="no">02</td>
                                      <td class="text-left">
                                          <h3>
                                              <a target="_blank" href="javascript:;">
                  Vat Number
                  </a>
                                          </h3>
                                         </td>
                                    
                                      <td class="total">{{$details->vatnumber}}</td>
                                  </tr>
                                  <tr>
                                    <tr>
                                      <td class="no">03</td>
                                      <td class="text-left">
                                          <h3>
                                              <a target="_blank" href="javascript:;">
                  Bank Details
                  </a>
                                          </h3>
                                         </td>
                                    
                                      <td class="total">{{$details->bank_details}}</td>
                                  </tr>
                                  <tr>
                                    <tr>
                                      <tr>
                                        <td class="no">04</td>
                                        <td class="text-left">
                                            <h3>
                                                <a target="_blank" href="javascript:;">
                    Bank Account Number
                    </a>
                                            </h3>
                                           </td>
                                      
                                        <td class="total">{{$details->bank_account_number}}</td>
                                    </tr>
                                                                 </tbody>
                            
                          </table>
                          
                        
                      </main>
                     
                  </div>
                  <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                  <div></div>
              </div>
          </div>
      </div>
  </div>
</div>