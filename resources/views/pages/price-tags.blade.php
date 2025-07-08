<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
  body {
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #FCEEB5;
      font-family: Abel, Arial, Verdana, sans-serif;
  }
  #cardContainer {
      text-align: center;
  }
  .card {
      display: inline-block;
      vertical-align: top;
      width: 450px;
      height: 250px;
      background-color: #fff;
      background: linear-gradient(#f8f8f8, #fff);
      box-shadow: 0 8px 16px -8px rgba(0,0,0,0.4);
      border-radius: 6px;
      overflow: hidden;
      margin: 1.5rem;
  }
  .card h1 {
      text-align: center;
      margin-left: 20px;
  }
  /* Add the rest of your CSS styles */
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://unpkg.com/jspdf"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $("#exportToPdf").on("click", function () {
            console.log('Export button clicked');
            // Select the container element that holds all the cards
            var container = document.getElementById('cardContainer');
            // Use html2pdf to generate PDF
            html2pdf().from(container).save('MyTags.pdf');
        });
    });
</script>
<div id="cardContainer" style="margin-top: 5px;" class="center">
    @foreach ($products as $product)
    <div class="card" style="border:1px dashed #000;margin-top:100px;">
        <div class="general">
            <h1 style="margin-left: 20px;">{{ $product->name }}</h1>
            <div class="text-center">
                ,<h1 style="margin-right;60px;">{!! DNS1D::getBarcodeHTML($product->barcode, 'C128') !!}</h1>
                <h4 class="text-center">{{ $product->barcode }}</h4>
            </div>
            <h1 class="text-center">{{ $product->selling_price }}</h1>
        </div>
    </div>
    @endforeach
</div>